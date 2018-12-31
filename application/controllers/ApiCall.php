<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class ApiCall extends CI_Controller {

	private $s3Bucket = 'coolfriend';

	public function __construct() {
        parent::__construct();

		$this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->database('default');
		$this->load->library('s3');
    }

	public function callStart() {
		$hash = $this->input->post('hash');
		$type = $this->input->post('type');
		$callee = $this->input->post('callee');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed', 'data' => json_encode($_POST), 'get' => json_encode($this->input->get())];
			echo json_encode($result);
			return false;
		}
		if (!$type) {
			$result = ['code' => 400, 'message' => 'No type passed'];
			echo json_encode($result);
			return false;
		}
		if (!$callee || !(int)$callee) {
			$result = ['code' => 400, 'message' => 'No callee passed'];
			echo json_encode($result);
			return false;
		}

		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'SELECT * FROM `users` WHERE `id` = ' . (int)$callee;
		$query = $this->db->query($sql);
		$callee = $query->row();

		$sql = 'INSERT INTO `tbl_call_history` SET
					`type`=' . $this->db->escape($type) . ',
					`caller_id`=' . (int)$user->id . ',
					`callee_id`=' . (int)$callee->id . ',
					`created_at`=NOW()';
		$this->db->query($sql);
		$callId = $this->db->insert_id();

		$result = ['code' => 200, 'message' => 'Ok', 'data' => ['call_id'=> $callId]];
		echo json_encode($result);
		return true;
	}

	public function callAccepted() {
		$hash = $this->input->post('hash');
		$call = $this->input->post('call');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed', 'data' => json_encode($_POST), 'get' => json_encode($this->input->get())];
			echo json_encode($result);
			return false;
		}
		if (!$call) {
			$result = ['code' => 400, 'message' => 'No call passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'UPDATE `tbl_call_history` SET `connected_at`=NOW() WHERE `id`=' . (int)$call;
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function callRejected() {
		$hash = $this->input->post('hash');
		$call = $this->input->post('call');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed', 'data' => json_encode($_POST), 'get' => json_encode($this->input->get())];
			echo json_encode($result);
			return false;
		}
		if (!$call) {
			$result = ['code' => 400, 'message' => 'No call passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'UPDATE `tbl_call_history` SET `end_at`=NOW() WHERE `id`=' . (int)$call;
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function callFinished() {
		$hash = $this->input->post('hash');
		$call = $this->input->post('call');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed', 'data' => json_encode($_POST), 'get' => json_encode($this->input->get())];
			echo json_encode($result);
			return false;
		}
		if (!$call) {
			$result = ['code' => 400, 'message' => 'No call passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'UPDATE `tbl_call_history` SET `end_at`=NOW(), `duration`=NOW()-`connected_at` WHERE `id`=' . (int)$call;
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function addComplaint() {
		$suspect = $this->input->post('suspect');
		$message = $this->input->post('message');
		$hash = $this->input->post('hash');
		header('Content-Type: application/json');
		if (!$hash) {
			$result = ['code' => 400, 'message' => 'No hash passed'];
			echo json_encode($result);
			return false;
		}
		if (!$suspect) {
			$result = ['code' => 400, 'message' => 'No suspect passed'];
			echo json_encode($result);
			return false;
		}
		if (!$message) {
			$result = ['code' => 400, 'message' => 'No message passed'];
			echo json_encode($result);
			return false;
		}
		$user = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}

		$sql = 'SELECT `id` FROM `users` WHERE `id`=' . (int)$suspect;
		$query = $this->db->query($sql);
		$suspected = $query->row();
		if (!$suspected) {
			$result = ['code' => 403, 'message' => 'Suspected user not found'];
			echo json_encode($result);
			return false;
		}

		if (isset($_FILES['screenshot']) && $_FILES['screenshot']['tmp_name'] && !$_FILES['screenshot']['error']) {
			$input = S3::inputFile($_FILES['screenshot']['tmp_name']);
			$uri = 'complaint/' . time() . '-' . mt_rand(10000, 99999) . '.jpg';
		    if (S3::putObject($input, $this->s3Bucket, $uri, S3::ACL_PUBLIC_READ)) {
				$somethingUpdated = true;
		    } else {
				$result = ['code' => 500, 'message' => 'Can`t store file to S3'];
				echo json_encode($result);
				return false;
		    }
		} else {
			//$result = ['code' => 400, 'message' => 'No screenshot passed'];
			//echo json_encode($result);
			//return false;
		}

		$sql = 'INSERT INTO `complaints` SET
					`applicant`=' . (int)$user->id . ',
					`suspect`=' . (int)$suspect . ',
					`message`=' . $this->db->escape($message) . ',
					`screenshot`=' . $this->db->escape($uri) . ',
					`dated`=NOW()';
		$this->db->query($sql);

		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	private function getUserByHash($hash) {
		$sql = 'SELECT
					u.*
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

		$sql = 'UPDATE `users` SET `online`=1, `online_at`=NOW() WHERE `id`=' . $user->id;
		$this->db->query($sql);

		$sql = 'UPDATE `user_hashes` SET `used`=NOW() WHERE `hash`=' . $this->db->escape($hash);
		$this->db->query($sql);
		return $user;
	}
}
