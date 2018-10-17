<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Api extends CI_Controller {

	private $s3Bucket = 'coolfriend';

	public function __construct() {
        parent::__construct();

		$this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->database('default');
        //require_once APPPATH.'libraries/Google/Client.php';
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

		if ($type == 'google') {
			$client = new Google_Client();
			$client->setApplicationName('coolfriend.co');
			$client->setClientId('506573866454-rmso2gqr104etl02g2dpota945v0jnph.apps.googleusercontent.com');
			$client->setClientSecret('MoV-lHR9GOtScDTt_9Ds1NUN');
			$client->setRedirectUri('http://coolfriend.co');

			$client->setAccessToken($token);

			$httpClient = $client->authorize();
			$response = $httpClient->get('https://www.googleapis.com/plus/v1/people/me');
			$found = $response->getBody()->getContents();
			if (!$found) {
				$result = ['code' => 404, 'message' => 'Incorrect login/password'];
				echo json_encode($result);
				return false;
			}
			$found = json_decode($found);
			$data = [
				'extid' => @$found->id,
				'first_name'  => @$found->name->givenName,
				'last_name'  => @$found->name->familyName,
				'email' => @$found->emails[0]->value,
				'gender' => @$found->gender,
				'avatar' => @$found->image->url
			];
			$user = $this->getAuthorizedUser($type, $token, $data);
		} elseif ($type == 'facebook') {
			$fb = new \Facebook\Facebook([
			  'app_id' => '1821673364590265',
			  'app_secret' => '6b2d8d9488a02c8e4b9712f50704764f',
			  'default_graph_version' => 'v2.10',
			  //'default_access_token' => '{access-token}', // optional
			]);

			try {
			  $response = $fb->get('/me?fields=name,picture,email,gender,link', $token);
			} catch(\Facebook\Exceptions\FacebookResponseException $e) {
				$result = ['code' => 404, 'message' => 'Incorrect login/password'];
				echo json_encode($result);
				return false;
			  	//echo 'Graph returned an error: ' . $e->getMessage();
			} catch(\Facebook\Exceptions\FacebookSDKException $e) {
				$result = ['code' => 404, 'message' => 'Incorrect login/password'];
				echo json_encode($result);
				return false;
			  	//echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  	//exit;
			}
			$me = $response->getGraphUser();
			$data = [
				'extid' => $me->getId(),
				'first_name' => $me->getName(),
				'avatar' => $me->getPicture() ? $me->getPicture()->getUrl() : false,
				'email' => $me->getEmail(),
				'gender' => $me->getGender(),
				'unique' => $me->getId()
			];
			$user = $this->getAuthorizedUser($type, $token, $data);
		}
		/*
		if ($location && $location['lat'] && $location['lng']) {
			$this->setLocation($user->id, $location['lat'], $location['lng']);
		}
		*/

		$hash = bin2hex(random_bytes(64));
		$sql = 'INSERT INTO `user_hashes` SET `user_id`=' . (int)$user->id . ',
							`hash`=' . $this->db->escape($hash) . ',
							`created`=NOW()';
		$this->db->query($sql);

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

		$sql = 'UPDATE `users` SET `online`=1 WHERE `id`=' . (int)$user->id;
		$this->db->query($sql);

		if ($user->video) {
			$user->video = S3::getAuthenticatedURL($this->s3Bucket, $user->video, 10*365*86400, false, true);
		}

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

	/*
	public function online() {
		$hash = $this->input->post('hash');
		$online  = $this->input->post('online');
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

		$isOnline = $online ? 1 : 0;
		$sql = 'UPDATE `users` SET `online`=' . $isOnline . ' WHERE `id`=' . (int)$user->id;
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok', 'online' => $isOnline];
		echo json_encode($result);
		return true;
	}
	*/
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
		foreach($data AS $key=>$value) {
			switch($key) {
				case 'first_name':
				case 'last_name':
				case 'email':
				case 'phone':
				case 'instagram':
					$sql .= ' `' . $key . '`=' . $this->db->escape($value) . ',';
					break;
				case 'location':
					try {
						$value = json_decode($value, 1);
					} catch (Exception $e) {
						continue 2;
					}
					$sql .= ' `location_city`=' . $this->db->escape($value['city']) . ',';
					$sql .= ' `location_country`=' . $this->db->escape($value['country']) . ',';
					$sql .= ' `location_country_code`=' . $this->db->escape($value['country_code']) . ',';
					$sql .= ' `location_lat`=' . $this->db->escape($value['lat']) . ',';
					$sql .= ' `location_lng`=' . $this->db->escape($value['lng']) . ',';
					break;
				case 'birthdate':
					$date = date('Y-m-d', strtotime($value));
					if ($date) {
						$date = '\'' . $date . '\'';
					} else {
						$date = 'null';
					}
					$sql .= ' `' . $key . '`=' . $this->db->escape($date) . ',';
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
					break;
				default: continue 2;
			}
		}
		if (isset($_FILES['avatar']) && $_FilES['avatar']['tmp_name'] && !$_FilES['avatar']['error']) {
			$input = S3::inputFile($_FILES['tmp_name']['tmp_name']);
			$uri = 'avatar/' . microtime(true) . '-' . mt_rand(10000, 99999) . '.avi';
		    if (S3::putObject($input, $this->s3Bucket, $uri, S3::ACL_PUBLIC_READ)) {
				$sql .= '`avatar`=' .  $this->db->escape($uri) . ',';
		    } else {
				$result = ['code' => 500, 'message' => 'Can`t store file to S3'];
				echo json_encode($result);
				return false;
		    }
		}
		$sql = preg_replace('!,\s*$!', '', $sql);
		$sql .= ' WHERE `id`=' . (int)$user->id;
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok'];
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

		$input = S3::inputFile($_FILES['video']['tmp_name']);
		$uri = 'profile/' . microtime(true) . '-' . mt_rand(10000, 99999) . '.avi';
	    if (S3::putObject($input, $this->s3Bucket, $uri, S3::ACL_PUBLIC_READ)) {
			$sql = 'INSERT INTO `user_videos` SET
						`user_id`=' . (int)$user->id . ',
						`video`=' .  $this->db->escape($uri) . ',
						`uploaded`=NOW(),
						`active`=1';
			$this->db->query($sql);
			$sql = 'UPDATE `user_videos` SET `active`=1 WHERE `user_id`=' . (int)$user->id . ' AND `video`!=' .  $this->db->escape($uri);
			$this->db->query($sql);

			$path = S3::getAuthenticatedURL($this->s3Bucket, $uri, 10*365*86400, false, true);
			$result = ['code' => 200, 'message' => 'Ok', 'url' => $path];
			echo json_encode($result);
			return true;
	    } else {
			$result = ['code' => 500, 'message' => 'Can`t store file to S3'];
			echo json_encode($result);
			return false;
	    }
	}

	public function random() {
		$hash = $this->input->post('hash');
		$limit  = $this->input->post('limit');
		header('Content-Type: application/json');

		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if ($limit < 1 || $limit > 10) {
			$limit = 3;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'SELECT
					u.*, uv.`video`
				FROM
									`users` u
					LEFT OUTER JOIN	`user_videos` uv ON (u.`id`=uv.`user_id`)
				WHERE
					u.`id`  != ' . (int)$user->id . ' AND
					uv.`active` = 1
				ORDER BY RAND()
				LIMIT ' . (int)$limit;
		$query = $this->db->query($sql);
		$users = $query->result_array();
		foreach($users AS $k=>$user) {
			if ($user['video']) {
				$users[$k]['video'] = S3::getAuthenticatedURL($this->s3Bucket, $user['video'], 10*365*86400, false, true);
			}
		}
		$result = ['code' => 200, 'message' => 'Ok', 'data' => $users];
		echo json_encode($result);
		return true;
	}

	public function selective() {
		$hash = $this->input->post('hash');
		$limit  = $this->input->post('limit');
		$gender  = $this->input->post('gender');
		header('Content-Type: application/json');

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

		$sql = 'SELECT
					u.*, uv.`video`, uf.`dated` is_friend
				FROM
									`users` u
					LEFT OUTER JOIN	`user_videos` uv ON (u.`id`=uv.`user_id`)
					LEFT OUTER JOIN	`user_friends` uf ON ((u.`id`=uf1.`a` AND if1.`b`=' . (int)$user->id . ') OR (u.`id`=uf1.`b` AND if1.`a`=' . (int)$user->id . '))
				WHERE
					' . ($gender ? 'u.`gender` = ' . ($gender == 1 ? '\'male\' AND' : '\'female\' AND' )  : '' ) . '
					u.`id`  != ' . (int)$user->id . ' AND
					uv.`active` = 1
				ORDER BY RAND()
				LIMIT ' . (int)$limit;
		$query = $this->db->query($sql);
		$users = $query->result_array();
		foreach($users AS $k=>$user) {
			if ($user['video']) {
				$users[$k]['video'] = S3::getAuthenticatedURL($this->s3Bucket, $user['video'], 10*365*86400, false, true);
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
		$sql = 'SELECT COUNT(*) FROM `user_friend_requests` WHERE `user`=' . (int)$friend . ' AND `friend`=' . (int)$user->id;
		$query = $this->db->query($sql);
		$exists = $query->result_array();
		if ($exists) {
			$sql = 'INSERT INTO `user_friends` SET `a`=' . (int)$friend . ' AND `b`=' . (int)$user->id . ', `dated`=NOW()';
			$this->db->query($sql);
			$sql = 'DELETE FROM `user_friend_requests` WHERE `user`=' . (int)$friend . ' AND `friend`=' . (int)$user->id;
			$query = $this->db->query($sql);
		} else {
			$sql = 'INSERT INTO `user_friend_requests` SET `user`=' . (int)$friend . ', `friend`=' . (int)$user->id . ', `dated`=NOW()';
			$query = $this->db->query($sql);
		}
		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	private function getAuthorizedUser($type, $token, $data) {
		$user = $this->getUserByExtId($type, $data['extid']);
		if (!$user) {
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
		$sql = 'SELECT
					u.*, uv.`video`
				FROM
									`users` u
					LEFT OUTER JOIN	`user_videos` uv ON (u.`id`=uv.`user_id`)
				WHERE
					' . ($data['gender'] ? 'u.`gender` = ' . ($data['gender'] == 1 ? '\'male\' AND' : '\'female\' AND' )  : '' ) . '
					u.`id` = ' . (int)$userId;
		$query = $this->db->query($sql);
		$user = $query->row();
		$user->video = S3::getAuthenticatedURL($this->s3Bucket, $user->video, 10*365*86400, false, true);
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
					ua.`extid` = ' . (int)$extId;
		$query = $this->db->query($sql);
		$row = $query->row();
		if (!$row) {
			return false;
		}
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
					u.*, uv.`video`
				FROM
									`users` u
					LEFT JOIN		`user_hashes` uh ON (u.`id`=uh.`user_id`)
					LEFT OUTER JOIN	`user_videos` uv ON (u.`id`=uv.`user_id`)
				WHERE
					uh.`hash` = ' . $this->db->escape($hash);
		$query = $this->db->query($sql);
		$user = $query->row();

		$sql = 'UPDATE `user_hashes` SET `used`=NOW() WHERE `hash`=' . $this->db->escape($hash);
		$this->db->query($sql);
		return $user;
	}

	private function setLocation($id, $lat, $lng) {
		$sql = 'UPDATE `users` SET
					`lat`=' . $this->db->escape($lat) . ',
					`lng`=' . $this->db->escape($lng) . '
				WHERE `id`=' . (int)$id;
		$this->db->query($sql);
	}
}
