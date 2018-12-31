<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Api extends CI_Controller {

	private $s3Bucket = 'coolfriend';
	private $cloudFrontWeb = 'https://d2po1euy792wnk.cloudfront.net/';
	private $cloudFrontRTMP = 'rtmp://s3n1hbcfo4ow5g.cloudfront.net/';

	public function __construct() {
        parent::__construct();
		$this->load->library('s3');
		$this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->database('default');
    }

	public function login() {
		$type  = $this->input->post('type');
		$token = $this->input->post('token');
		$location = $this->input->post('location');
		header('Content-Type: application/json');

		if (!$type) {
			$result = ['code' => 400, 'message' => 'No auth type passed'];
			echo json_encode($result);
			return false;
		}
		if (!$token) {
			$result = ['code' => 400, 'message' => 'No auth token passed'];
			echo json_encode($result);
			return false;
		}

		$urlForAvatar = false;
		if ($type == 'google') {
			$url = 'https://www.googleapis.com/plus/v1/people/me?access_token=' . $token;
			try {
				$raw = file_get_contents($url);
				$found = json_decode($raw);
			} catch(Exception $e) {
				//print_r($e);
				$result = ['code' => 404, 'message' => 'Incorrect auth token'];
				echo json_encode($result);
				return false;
			}
			if (!$found) {
				$result = ['code' => 404, 'message' => 'Incorrect auth token'];
				echo json_encode($result);
				return false;
			}
			$data = [
				'extid' => @$found->id,
				'first_name'  => @$found->name->givenName,
				'last_name'  => @$found->name->familyName,
				'email' => @$found->emails[0]->value,
				'gender' => (@$found->gender == 'male' ? 1 : (@$found->gender == 'female' ? 2 : null))
			];
			if ($found && $found->image->url && $found->image->url && !$found->image->isDefault) {
				$urlForAvatar = $found->image->url;
			}
		} elseif ($type == 'facebook') {
			$fb = new \Facebook\Facebook([
			  'app_id' => '1821673364590265',
			  'app_secret' => '6b2d8d9488a02c8e4b9712f50704764f',
			  'default_graph_version' => 'v2.10',
			]);

			try {
			  $response = $fb->get('/me?fields=name,picture,email,gender,link,first_name,last_name,birthday', $token);
			} catch(\Facebook\Exceptions\FacebookResponseException $e) {
				$result = ['code' => 404, 'message' => 'Incorrect auth token'];
				echo json_encode($result);
				return false;
			} catch(\Facebook\Exceptions\FacebookSDKException $e) {
				$result = ['code' => 404, 'message' => 'Incorrect auth token'];
				echo json_encode($result);
				return false;
			}
			$me = $response->getGraphUser();
			//print_r($me); exit;
			$data = [
				'extid' => $me->getId(),
				'first_name' => $me->getFirstName(),
				'last_name' => $me->getLastName(),
				'email' => $me->getEmail(),
				'gender' => $me->getGender(),
				'unique' => $me->getId()
			];
			if ($me->getPicture()) {
				if (!$me->getPicture()->isSilhouette()) {
					$urlForAvatar = $me->getPicture()->getUrl();
				} else {
					$urlForAvatar = false;
				}
			}
		} else {
			$result = ['code' => 500, 'message' => 'Unknown authentification method'];
			echo json_encode($result);
			return false;
		}
		if ($urlForAvatar) {
			// Generate temp file names
			$filename = microtime(true) . '-' . mt_rand(10000, 99999) . '.jpg';
			$copied = @copy($urlForAvatar, '/tmp/' . $filename);
			if ($copied) {
				$input = S3::inputFile('/tmp/' . $filename);
				$uri = 'avatar/' . $filename;
				if (S3::putObject($input, $this->s3Bucket, $uri, S3::ACL_PUBLIC_READ)) {
					$data['avatar'] = $uri;
				}
			}
		}
		$user = $this->getAuthorizedUser($type, $token, $data);
		if (!$user) {
			$result = ['code' => 401, 'message' => 'Incorrect login/password'];
			echo json_encode($result);
		}

		$sql = 'SELECT * FROM `user_hashes` WHERE `user_id`=' . (int)$user->id;
		$query = $this->db->query($sql);
		$hashRow = $query->row();
		if ($hashRow) {
			$hash = $hashRow->hash;
		} else {
			$hash = bin2hex(random_bytes(64));
			//$sql = 'DELETE FROM `user_hashes` WHERE `user_id`=' . (int)$user->id;
			//$this->db->query($sql);
			$sql = 'INSERT INTO `user_hashes` SET `user_id`=' . (int)$user->id . ',
								`hash`=' . $this->db->escape($hash) . ',
								`created`=NOW()';
			$this->db->query($sql);
		}

		$user = $this->getUserByHash($hash);
		$result = ['code' => 200, 'message' => 'Ok', 'hash' => $hash, 'data' => $user];
		echo json_encode($result);
		return true;
	}

	public function checkUser() {
		$hash = $this->input->post('hash');
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed', 'data' => json_encode($_POST), 'get' => json_encode($this->input->get())];
			echo json_encode($result);
			return false;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'UPDATE `users` SET `online`=1, `online_at`=NOW() WHERE `id`=' . (int)$user->id;
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok', 'data' => $user];
		echo json_encode($result);
		return true;
	}

	public function userDisconnected() {
		$hash = $this->input->post('hash');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'UPDATE `users` SET `online`=0 WHERE `id`=' . (int)$user->id;
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function update() {
		$hash = $this->input->post('hash');
		$data = $this->input->post();
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'UPDATE `users` SET ';
		$somethingUpdated = false;
		foreach($data AS $key=>$value) {
			switch($key) {
				case 'first_name':
				case 'last_name':
				case 'email':
				case 'phone':
				case 'instagram':
					$sql .= ' `' . $key . '`=' . $this->db->escape($value) . ',';
					$somethingUpdated = true;
					break;
				case 'location':
					try {
						$value = urldecode($value);
						$value = json_decode($value, 1);
					} catch (Exception $e) {
						//print_r(e); exit;
						continue 2;
					}
					if (isset($value['city'])) {
						$sql .= ' `location_city`=' . $this->db->escape($value['city']) . ',';
					} elseif (isset($value['location_city'])) {
						$sql .= ' `location_city`=' . $this->db->escape($value['location_city']) . ',';
					}
					if (isset($value['country'])) {
						$sql .= ' `location_country`=' . $this->db->escape($value['country']) . ',';
					} elseif (isset($value['location_country'])) {
						$sql .= ' `location_country`=' . $this->db->escape($value['location_country']) . ',';
					}
					if (isset($value['state'])) {
						$sql .= ' `location_state`=' . $this->db->escape($value['state']) . ',';
					} elseif (isset($value['location_state'])) {
						$sql .= ' `location_state`=' . $this->db->escape($value['location_state']) . ',';
					}
					if (isset($value['country_code'])) {
						$sql .= ' `location_country_code`=' . $this->db->escape($value['country_code']) . ',';
					} elseif (isset($value['location_country_code'])) {
						$sql .= ' `location_country_code`=' . $this->db->escape($value['location_country_code']) . ',';
					}
					if (isset($value['location_lat'])) {
						$sql .= ' `location_lat`=' . $this->db->escape($value['location_lat']) . ',';
					}
					if (isset($value['location_lng'])) {
						$sql .= ' `location_lng`=' . $this->db->escape($value['location_lng']) . ',';
					}
					$somethingUpdated = true;
					break;
				case 'birthday':
					$date = date('Y-m-d', strtotime($value . ' 12:00:00'));
					if ($date) {
						$date = '\'' . $date . '\'';
					} else {
						$date = 'null';
					}
					$sql .= ' `' . $key . '`=' . $this->db->escape($date) . ',';
					$somethingUpdated = true;
					break;
				case 'birthyear':
					$sql .= ' `' . $key . '`=' . (int)$value . ',';
					$somethingUpdated = true;
					break;
				case 'gender':
					switch($value) {
						case 1:
						case 'm':
						case 'male':
							$gender = '\'male\''; break;
						case 2:
						case 'f':
						case 'female':
							$gender = '\'female\''; break;
						default:
							$gender = 'null';
					}
					$sql .= ' `' . $key . '`=' . $gender . ',';
					$somethingUpdated = true;
					break;
				case 'lgbtq':
					$sql .= ' `lgbtq`=' . ($value ? 1 : 0) . ',';
					$somethingUpdated = true;
				default: continue 2;
			}
		}
		if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name'] && !$_FILES['avatar']['error']) {
			if ($user->avatar) {
				S3::deleteObject($this->s3Bucket, $user->avatar);
			}
			$input = S3::inputFile($_FILES['avatar']['tmp_name']);
			$uri = 'avatar/' . microtime(true) . '-' . mt_rand(10000, 99999) . '.jpg';
		    if (S3::putObject($input, $this->s3Bucket, $uri, S3::ACL_PUBLIC_READ)) {
				$sql .= '`avatar`=' .  $this->db->escape($uri) . ',';
				$somethingUpdated = true;
		    } else {
				$result = ['code' => 500, 'message' => 'Can`t store file to S3'];
				echo json_encode($result);
				return false;
		    }
		}
		if ($somethingUpdated) {
			$sql = preg_replace('!,\s*$!', '', $sql);
			$sql .= ' WHERE `id`=' . (int)$user->id;
			$this->db->query($sql);
		}

		$user = $this->getUserByHash($hash);
		$result = ['code' => 200, 'message' => 'Ok', 'data' => $user];
		echo json_encode($result);
		return true;
	}

	public function setLocation() { // $id, $lat, $lng
		$lat  = $this->input->post('lat');
		$lng  = $this->input->post('lng');
		$hash = $this->input->post('hash');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$lat || !$lng) {
			$result = ['code' => 400, 'message' => 'No lat/lng passed'];
			echo json_encode($result);
			return false;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'UPDATE `users` SET
					`location_lat`=' . $this->db->escape($lat) . ',
					`location_lng`=' . $this->db->escape($lng) . '
				WHERE `id`=' . (int)$user->id;
		$this->db->query($sql);

		$user = $this->getUserByHash($hash);
		$result = ['code' => 200, 'message' => 'Ok', 'data' => $user];
		echo json_encode($result);
		return true;
	}

	public function uploadVideo() {
  		$this->load->library('s3');
		$hash = $this->input->post('hash');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$_FILES['video']['tmp_name'] || !$_FILES['video']['tmp_name'] || $_FILES['video']['error']) {
			$result = ['code' => 400, 'message' => 'File upload error'];
			echo json_encode($result);
			return false;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		// Remove old data
		if ($user->thumbnail) {
			S3::deleteObject($this->s3Bucket, $user->thumbnail);
		}
		if ($user->video) {
			S3::deleteObject($this->s3Bucket, $user->video);
		}

		// Make thumbnail
		$thumb = '/tmp/' . mt_rand(100000, 999999) . '.jpg';
		$cmd = 'ffmpeg -i ' . $_FILES['video']['tmp_name'] . ' -deinterlace -an -ss 0 -t 1 -r 1 -y ' . $thumb;
		$return = shell_exec($cmd);
		$input = S3::inputFile($thumb);
		$uriThumb = 'thumb/' . microtime(true) . '-' . mt_rand(10000, 99999) . '.jpg';
		if (!S3::putObject($input, $this->s3Bucket, $uriThumb, S3::ACL_PUBLIC_READ)) {
			$result = ['code' => 500, 'message' => 'Can`t store file to S3'];
			echo json_encode($result);
			return false;
		}

		// Store video
		$input = S3::inputFile($_FILES['video']['tmp_name']);
		$uriVideo = 'profile/' . str_pad($user->id, 8, '0', STR_PAD_LEFT) . '-' . mt_rand(10000, 99999) . '.avi';
	    if (!S3::putObject($input, $this->s3Bucket, $uriVideo, S3::ACL_PUBLIC_READ)) {
			$result = ['code' => 500, 'message' => 'Can`t store file to S3'];
			echo json_encode($result);
			return false;
	    }

		$sql = 'UPDATE `users` set `video`=' . $this->db->escape($uriVideo) . ', `thumbnail`=' . $this->db->escape($uriThumb) . ' WHERE `id`=' . $user->id;
		$this->db->query($sql);

		$user = $this->getUserByHash($hash);
		$result = ['code' => 200, 'message' => 'Ok', 'data' => $user];
		echo json_encode($result);
		return true;
		unlink($thumb);
	}

	public function selective() {
		$hash = $this->input->post('hash');
		$limit  = $this->input->post('limit');
		$gender  = $this->input->post('gender');
		header('Content-Type: application/json');

		$sql = 'UPDATE `users` SET `online`=0 WHERE TIMESTAMPDIFF(MINUTE, `online_at`, NOW()) > 20';
		$query = $this->db->query($sql);

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if ($limit < 1 || $limit > 100) {
			$limit = 100;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		//print_r($user);

		$sql = 'SELECT
					u.*, uf.`dated` is_friend
				FROM
									`users` u
					LEFT OUTER JOIN	`user_friends` uf ON ((u.`id`=uf.`a` AND uf.`b`=' . (int)$user->id . ') OR (u.`id`=uf.`b` AND uf.`a`=' . (int)$user->id . '))
				WHERE
					' . ($gender ? 'u.`gender` = ' . ($gender == 'm' ? '\'male\' AND' : '') . ($gender == 'f' ? '\'female\' AND' : '' )  : '' ) . '
					u.`id`  != ' . (int)$user->id . ' AND
					u.`video` IS NOT NULL AND
					u.`online`=1 AND
					u.`blocked`=0
				ORDER BY
					RAND()
				LIMIT ' . (int)$limit;

		$query = $this->db->query($sql);
		$users = $query->result_array();
		foreach($users AS $k=>$user) {
			if ($user['video']) {
				//$users[$k]['video'] = S3::getAuthenticatedURL($this->s3Bucket, $user['video'], 10*365*86400, false, true);
				$users[$k]['video'] = $this->cloudFrontWeb . $user['video'];
				$users[$k]['video_rtmp'] = $this->cloudFrontRTMP . $user['video'];
				$users[$k]['avatar'] = $this->cloudFrontWeb . $user['avatar'];
				$users[$k]['thumbnail'] = $this->cloudFrontWeb . $user['thumbnail'];
			}
		}
		$result = ['code' => 200, 'message' => 'Ok', 'data' => $users];
		echo json_encode($result);
		return true;
	}

	public function addFriend() {
		$hash = $this->input->post('hash');
		$friend  = $this->input->post('friend');
		header('Content-Type: application/json');

		// Remove all old friend requests
		$sql = 'DELETE FROM `user_friend_requests` WHERE TIMESTAMPDIFF(MINUTE, dated, NOW()) > 60';
		$query = $this->db->query($sql);

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$friend || !(int)$friend) {
			$result = ['code' => 400, 'message' => 'No friend ID passed'];
			echo json_encode($result);
			return false;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		if ($friend == $user->id) {
			$result = ['code' => 400, 'message' => 'You can`t be friends with yourself'];
			echo json_encode($result);
			return false;
		}
		$sql = 'SELECT COUNT(*) cnt FROM `users` WHERE `id`=' . (int)$friend;
		$query = $this->db->query($sql);
		$exists = $query->row();
		if (!$exists || !$exists->cnt) {
			$result = ['code' => 404, 'message' => 'Friend not found'];
			echo json_encode($result);
			return false;
		}

		// Have we request from friend?
		$sql = 'SELECT COUNT(*) cnt FROM `user_friend_requests` WHERE `user`=' . (int)$friend . ' AND `friend`=' . (int)$user->id;
		$query = $this->db->query($sql);
		$exists = $query->row();
		if ($exists && $exists->cnt) {
			$sql = 'SELECT COUNT(*) cnt FROM `user_friends` WHERE (`a`=' . (int)$user->id . ' AND `b`=' . (int)$friend . ') OR (`b`=' . (int)$user->id . ' AND `a`=' . (int)$friend . ')';
			$query = $this->db->query($sql);
			$exists = $query->row();
			if (!$exists || !$exists->cnt) {
				$sql = 'INSERT IGNORE INTO
							`user_friends`
						SET
							`a`=' . (int)$friend . ', `b`=' . (int)$user->id . ', `dated`=NOW()
						ON DUPLICATE KEY UPDATE
							`dated`=NOW()';
				$this->db->query($sql);
			}
			$sql = 'DELETE FROM `user_friend_requests` WHERE `user`=' . (int)$user->id . ' AND `friend`=' . (int)$friend;
			$query = $this->db->query($sql);
			$sql = 'DELETE FROM `user_friend_requests` WHERE `user`=' . (int)$friend . ' AND `friend`=' . (int)$user->id;
			$query = $this->db->query($sql);
			$areFriends = true;
		} else {
			$sql = 'INSERT IGNORE INTO `user_friend_requests` SET `user`=' . (int)$user->id . ', `friend`=' . (int)$friend . ', `dated`=NOW()';
			$query = $this->db->query($sql);
			$areFriends = false;
		}
		$result = ['code' => 200, 'message' => 'Ok', 'are_friends' => (int)$areFriends];
		echo json_encode($result);
		return true;
	}

	public function removeFriend() {
		$hash = $this->input->post('hash');
		$friend  = $this->input->post('friend');
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$friend || !(int)$friend) {
			$result = ['code' => 400, 'message' => 'No friend ID passed'];
			echo json_encode($result);
			return false;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		if ($friend == $user->id) {
			$result = ['code' => 400, 'message' => 'You can`t be friends with yourself'];
			echo json_encode($result);
			return false;
		}

		// Have we request from friend?
		$sql = 'DELETE FROM `user_friend_requests` WHERE `user`=' . (int)$friend . ' AND `friend`=' . (int)$user->id;
		$query = $this->db->query($sql);
		$sql = 'DELETE FROM `user_friend_requests` WHERE `user`=' . (int)$user->id . ' AND `friend`=' . (int)$friend;
		$query = $this->db->query($sql);
		$sql = 'DELETE FROM `user_friends` WHERE `a`=' . (int)$friend . ' AND `b`=' . (int)$user->id;
		$this->db->query($sql);
		$sql = 'DELETE FROM `user_friends` WHERE `a`=' . (int)$user->id . ' AND `b`=' . (int)$friend;
		$this->db->query($sql);
		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function listFriends() {
		$hash = $this->input->post('hash');
		//$friend  = $this->input->post('friend');
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		$sql = 'SELECT u.*, COALESCE(f1.`dated`, f2.`dated`) AS become_friends FROM
									`users` u
					LEFT OUTER JOIN `user_friends` f1 ON (u.`id`=f1.`a` AND f1.`b`=' . (int)$user->id . ')
					LEFT OUTER JOIN `user_friends` f2 ON (u.`id`=f2.`b` AND f2.`a`=' . (int)$user->id . ')
				WHERE
					f1.`dated` IS NOT NULL OR f2.`dated` IS NOT NULL
				ORDER BY
					become_friends DESC';
		$query = $this->db->query($sql);
		$users = $query->result_array();
		foreach ($users AS $k=>$user) {
			if ($user['avatar']) {
				$users[$k]['avatar'] = $this->cloudFrontWeb . $user['avatar'];
			}
			if ($user['thumbnail']) {
				$users[$k]['thumbnail'] = $this->cloudFrontWeb . $user['thumbnail'];
			}
			if ($user['video']) {
				$users[$k]['video'] = $this->cloudFrontWeb . $user['video'];
				$users[$k]['video_rtmp'] = $this->cloudFrontRTMP . $user['video'];
			}
		}
		$result = ['code' => 200, 'message' => 'Ok', 'users' => $users];
		echo json_encode($result);
		return true;
	}

	public function checkFriend() {
		$hash = $this->input->post('hash');
		$friend  = $this->input->post('friend');
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$friend || !(int)$friend) {
			$result = ['code' => 400, 'message' => 'No friend ID passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		$sql = 'SELECT COUNT(*) cnt FROM `user_friends` WHERE (`a`=' . (int)$user->id . ' AND `b`=' . (int)$friend . ') OR (`b`=' . (int)$user->id . ' AND `a`=' . (int)$friend . ')';
		$query = $this->db->query($sql);
		$exists = $query->row();
		$result = ['code' => 200, 'message' => 'Ok', 'is_friend' => (int)$exists->cnt];
		echo json_encode($result);
		return true;
	}

	public function payment() {
		$hash = $this->input->post('hash');
		$amount = $this->input->post('amount');
		$currency = $this->input->post('currency');
		$expire = $this->input->post('expire');
		$package = $this->input->post('package');
		$duration = $this->input->post('duration');
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$expire) {
			$result = ['code' => 400, 'message' => 'No expiration date passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		$sql = 'INSERT INTO
						`user_payments`
				SET
					`user_id`  = ' . (int)$user->id . ',
					`dated`    = NOW(),
					`amount`   = ' . (float)$amount . ',
					`currency` = ' . $this->db->escape($currency) . ',
					`package` = ' . $this->db->escape($package) . ',
					`duration` = ' . $this->db->escape($duration) . ',
					`expire` = ' . $this->db->escape($expire) .  '';
		$query = $this->db->query($sql);

		$user = $this->getUserByHash($hash);
		$result = ['code' => 200, 'message' => 'Ok', 'data' => $user];
		echo json_encode($result);
		return true;
	}

	public function getPushes() {
		$toSend = array();
		// Filtered notifications
		$sql = 'SELECT
					n.`content`, n.`title`, f.*, co.`country_name`, st.`state_name`, ci.`city_name`, n.`type`
				FROM
									`notifications` n
						LEFT JOIN	`filtered_notifications` f ON (n.`id` = f.`notification_id`)
						LEFT JOIN	`countries` co ON (co.`country_id` = f.`country_id`)
						LEFT JOIN	`states` st ON (st.`state_id` = f.`state_id`)
						LEFT JOIN	`cities` ci ON (ci.`city_id` = f.`city_id`)
				WHERE
					n.`status` IN (\'1\',\'2\') AND
					f.`id` IS NOT NULL
				ORDER BY RAND()
				LIMIT 10';
		$query = $this->db->query($sql);
		$notifications = $query->result_array();
		foreach($notifications AS $notification) {
			$sql = 'SELECT
						u.`id`, t. `token`
						FROM
										`users` u
							LEFT JOIN	`user_firebase_tokens` t ON (u.`id`=t.`user_id`)
						WHERE ((true AND ';
			if ($notification['country_name']) {
				$sql .= 'u.`location_country` = ' . $this->db->escape($notification['country_name']) . ' AND ';
			}
			if ($notification['state_name']) {
				$sql .= 'u.`location_state` = ' . $this->db->escape($notification['state_name']) . ' AND ';
			}
			if ($notification['city_name']) {
				$sql .= 'u.`location_city` = ' . $this->db->escape($notification['city_name']) . ' AND ';
			}
			if ($notification['activity']) {
				$sql .= 'u.`online` = ' . $this->db->escape($notification['gender']) . ' AND ';
			}
			if ($notification['gender']) {
				$sql .= 'u.`gender` = ' . $this->db->escape($notification['gender']) . ' AND ';
			}
			if ($notification['lgbtq']) {
				$sql .= 'u.`lgbtq` = ' . ($notification['lgbtq'] == 'yes' ? 1 : 0) . ' AND ';
			}
			if ($notification['birth_year_from']) {
				$sql .= 'u.`birthday` >= \'' . $notification['birth_year_from'] . '-00-00\' AND ';
			}
			if ($notification['birth_year_to']) {
				$sql .= 'u.`birthday` <= \'' . $notification['birth_year_to'] . '-12-31\' AND ';
			}
			$sql .= ' true) OR u.`id` IN (SELECT nu.`user_id` FROM `notification_users` nu WHERE nu.`notification_id`=' . (int)$notification['notification_id'] . ')) AND
						u.`id` NOT IN (SELECT `user_id` FROM `notifications_sent` WHERE `notification_id`=' . (int)$notification['notification_id'] . ') AND
					  t.`token` IS NOT NULL';
			$sql .= ' LIMIT 1000';
			$query = $this->db->query($sql);
			$users = $query->result_array();

			$sql = 'UPDATE `notifications` n SET n.`sent`=(SELECT COUNT(*) FROM `notifications_sent` s WHERE n.`id`=s.`notification_id`) WHERE n.`id`=' . (int)$notification['notification_id'];
			$this->db->query($sql);

			if (!$users) {
				$sql = 'UPDATE `notifications` SET `status`=\'3\' WHERE `id`=' . (int)$notification['notification_id'];
				$this->db->query($sql);
			} else {
				$sql = 'UPDATE `notifications` SET `status`=\'2\' WHERE `id`=' . (int)$notification['notification_id'];
				$this->db->query($sql);
			}
			foreach($users AS $user) {
				$toSend[] = array('id' => (int)$notification['notification_id'],
								  'title' => $notification['title'],
								  'type' => $notification['type'],
								  'content' => $notification['content'],
								  'user_id' => (int)$user['id'],
								  'token' => $user['token']);
			}
		}
		if (!$toSend && false) {
			//exit;
			// Broadcast notifications
			$sql = 'SELECT
						n.`id`, n.`content`, n.`title`, n.`type`
					FROM
										`notifications` n
							LEFT OUTER JOIN	`filtered_notifications` f ON (n.`id` = f.`notification_id`)
					WHERE
						n.`status` IN (\'1\',\'2\') AND
						f.`id` IS NULL
					ORDER BY RAND()
					LIMIT 10';
			$query = $this->db->query($sql);
			$notifications = $query->result_array();
			foreach($notifications AS $notification) {
				$sql = 'SELECT
							u.`id`, t. `token`
							FROM
											`users` u
								LEFT JOIN	`user_firebase_tokens` t ON (u.`id`=t.`user_id`)
							WHERE
								u.`id` NOT IN (SELECT `user_id` FROM `notifications_sent` WHERE `notification_id`=' . (int)$notification['id'] . ') AND
						  		t.`token` IS NOT NULL
							LIMIT 1000';
				$query = $this->db->query($sql);
				$users = $query->result_array();

				$sql = 'UPDATE `notifications` n SET n.`sent`=(SELECT COUNT(*) FROM `notifications_sent` s WHERE n.`id`=s.`notification_id`) WHERE n.`id`=' . (int)$notification['id'];
				$this->db->query($sql);

				if (!$users) {
					$sql = 'UPDATE `notifications` SET `status`=\'3\' WHERE `id`=' . (int)$notification['id'];
					$this->db->query($sql);
				} else {
					$sql = 'UPDATE `notifications` SET `status`=\'2\' WHERE `id`=' . (int)$notification['id'];
					$this->db->query($sql);
				}
				foreach($users AS $user) {
					$toSend[] = array('id' => (int)$notification['id'],
									  'title' => $notification['title'],
									  'type' => $notification['type'],
									  'content' => $notification['content'],
									  'user_id' => (int)$user['id'],
									  'token' => $user['token']);
				}
			}
		}
		$result = ['code' => 200, 'message' => 'Ok', 'data' => $toSend];
		echo json_encode($result);
		return true;
	}

	public function storeToken() {
		$hash = $this->input->post('hash');
		$token = $this->input->post('token');
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$token) {
			$result = ['code' => 400, 'message' => 'No token passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		$sql = 'INSERT IGNORE INTO `user_firebase_tokens` SET
					`token`=' . $this->db->escape($token) . ',
					`user_id`=' . (int)$user->id;
		$query = $this->db->query($sql);
		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function pushSent() {
		$id = $this->input->post('id');
		$user_id = $this->input->post('user_id');
		$error = $this->input->post('error');
		$sql = 'INSERT IGNORE INTO `notifications_sent` SET
					`notification_id`=' . (int)$id . ',
					`user_id`=' . (int)$user_id . ',
					`sent`=' . ($error ? 0 : 1);
		$query = $this->db->query($sql);
		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	private function getAuthorizedUser($type, $token, $data) {
		if (!$data || !$data['extid']) {
			return false;
		}
		$user = $this->getUserByExtId($type, $data['extid']);
		if ($data['email'] && (!$user || !$user->id)) {
			$user = $this->getUserByEmail($data['email']);
		}
		if (!$user || !$user->id) {
			//getAuthorizedUser
			if (isset($data['email']) && $data['email']) {
				$sql = 'SELECT * FROM `users` WHERE `email`=' . $this->db->escape($data['email']);
				$query = $this->db->query($sql);
				$user = $query->row();
				if ($user) {
					$userId = $user->id;
					$sql = 'DELETE FROM `user_auth` WHERE
								`user_id` = ' . (int)$userId . ' AND
								`type` 	  = \'' . $type . '\'';
					$this->db->query($sql);
				}
			}
			if (!$user) {
				$sql = 'INSERT INTO `users` SET
							`first_name`=\'\',
							`last_name`=\'\',
							`created_at`=NOW(),
							`updated_at`=NOW(),
							`online_at`=NOW()
							';
				$this->db->query($sql);
				$userId = $this->db->insert_id();
			}
			$sql = 'INSERT INTO `user_auth` SET
						`user_id` = ' . (int)$userId . ',
						`extid` = ' . (int)$data['extid'] . ',
						`type` 	  = \'' . $type . '\',
						`token`	  = ' . $this->db->escape($token);
			$this->db->query($sql);
		} else {
			$userId = $user->id;
		}
		if (isset($data['first_name']) && $data['first_name'] && (!$user || !$user->first_name)) {
			$sql = 'UPDATE `users` SET `first_name`=' .  $this->db->escape($data['first_name']) . ' WHERE `id`=' . (int)$userId;
			$this->db->query($sql);
		}
		if (isset($data['last_name']) && $data['last_name'] && (!$user || !$user->last_name)) {
			$sql = 'UPDATE `users` SET `last_name`=' .  $this->db->escape($data['last_name']) . ' WHERE `id`=' . (int)$userId;
			$this->db->query($sql);
		}
		if (isset($data['email']) && $data['email'] && (!$user || !$user->email)) {
			$sql = 'UPDATE `users` SET `email`=' .  $this->db->escape($data['email']) . ' WHERE `id`=' . (int)$userId;
			$this->db->query($sql);
		}
		if (isset($data['gender']) && $data['gender'] && (!$user || !$user->gender)) {
			$gender = ($data['gender'] == 'm' || $data['gender'] == 'male') ? 'male' : 'female';
			$sql = 'UPDATE `users` SET `gender`=\'' .  $gender . '\' WHERE `id`=' . (int)$userId;
			$this->db->query($sql);
		}
		if (isset($data['avatar']) && $data['avatar'] && (!$user || !$user->avatar)) {
			$sql = 'UPDATE `users` SET `avatar`=' .  $this->db->escape($data['avatar']) . ' WHERE `id`=' . (int)$userId;
			$this->db->query($sql);
		}
		$sql = 'SELECT * FROM `users` u WHERE u.`id` = ' . (int)$userId;
		$query = $this->db->query($sql);
		$user = $query->row();
		if ($user->video) {
			$user->video = $this->cloudFrontWeb . $user->video;
			$user->video_rtmp = $this->cloudFrontRTMP . $user->video;
		}
		if ($user->avatar) {
			$user->avatar = $this->cloudFrontWeb . $user->avatar;
		}
		if ($user->thumbnail) {
			$user->thumbnail = $this->cloudFrontWeb . $user->thumbnail;
		}

		return $user;
	}

	private function getUserByExtId($type, $extId) {
		$sql = 'SELECT
					u.*
				FROM
								`users` u
					LEFT JOIN	`user_auth` ua ON (u.`id`=ua.`user_id`)
				WHERE
					ua.`type`  = ' . $this->db->escape($type) . ' AND
					ua.`extid` = ' . $this->db->escape($extId);
		$query = $this->db->query($sql);
		$row = $query->row();
		if (!$row) {
			return false;
		}
		return $row;
	}

	private function getUserByEmail($email) {
		$sql = 'SELECT u.* FROM `users` u WHERE u.`email`  = ' . $this->db->escape($email);
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row;
	}

	private function getUserByToken($type, $token) {
		$sql = 'SELECT
					u.*
				FROM
								`users` u
					LEFT JOIN	`user_auth` ua ON (u.`id`=ua.`user_id`)
				WHERE
					ua.`type`  = ' . $this->db->escape($type) . ' AND
					ua.`token` = ' . $this->db->escape($token);
		$query = $this->db->query($sql);
		$row = $query->row();
		if (!$row) {
			return false;
		}
		return $row;
	}

	private function getUserByHash($hash) {
		$sql = 'DELETE FROM `user_hashes` WHERE `used`< DATE_SUB(NOW(), INTERVAL 1 WEEK)';
		$this->db->query($sql);

		$sql = 'SELECT
					u.*,
					(SELECT up.`expire` FROM `user_payments` up WHERE u.`id`=up.`user_id` ORDER BY up.`expire` DESC LIMIT 1) payment_expiration
				FROM
									`users` u
					LEFT JOIN		`user_hashes` uh ON (u.`id`=uh.`user_id`)
				WHERE
					u.`blocked` = 0 AND
					uh.`hash` = ' . $this->db->escape($hash);
		$query = $this->db->query($sql);
		$user = $query->row();
		if (!$user) {
			return false;
		}
		if ($user->video) {
			//$user->video = S3::getAuthenticatedURL($this->s3Bucket, $user->video, 10*365*86400, false, true);
			$user->video = $this->cloudFrontWeb . $user->video;
			$user->video_rtmp = $this->cloudFrontRTMP . $user->video;
		}
		if ($user->avatar) {
			//$user->avatar = S3::getAuthenticatedURL($this->s3Bucket, $user->avatar, 10*365*86400, false, true);
			$user->avatar = $this->cloudFrontWeb . $user->avatar;
		}
		if ($user->thumbnail) {
			//$user->avatar = S3::getAuthenticatedURL($this->s3Bucket, $user->avatar, 10*365*86400, false, true);
			$user->thumbnail = $this->cloudFrontWeb . $user->thumbnail;
		}

		$sql = 'UPDATE `user_hashes` SET `used`=NOW() WHERE `hash`=' . $this->db->escape($hash);
		$this->db->query($sql);
		return $user;
	}
}
