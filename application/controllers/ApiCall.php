<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class ApiCall extends CI_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->database('default');
    }

	public function callStart() {
		//$hash = $this->input->post('hash');
		//{'user': self.id, 'recipient': recipientId, 'call': callId}
		header('Content-Type: application/json');
		/*
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
		*/
		$result = ['code' => 200, 'message' => 'Ok', 'data' => ['call_id'=> mt_rand(100000,999999)]];
		echo json_encode($result);
		return true;
	}

	public function callAccepted() {
		$call = $this->input->post('call');
		header('Content-Type: application/json');
		if (!$call) {
			$result = ['code' => 400, 'message' => 'No call passed'];
			echo json_encode($result);
			return false;
		}

		/*
		$call = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		*/
		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function callRejected() {
		$call = $this->input->post('call');
		header('Content-Type: application/json');
		if (!$call) {
			$result = ['code' => 400, 'message' => 'No call passed'];
			echo json_encode($result);
			return false;
		}

		/*
		$call = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		*/
		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}

	public function callFinished() {
		$call = $this->input->post('call');
		header('Content-Type: application/json');
		if (!$call) {
			$result = ['code' => 400, 'message' => 'No call passed'];
			echo json_encode($result);
			return false;
		}

		/*
		$call = $this->getUserByHash($hash);
		if (!$user) {
			$result = ['code' => 403, 'message' => 'Incorrect auth hash'];
			echo json_encode($result);
			return false;
		}
		*/
		$result = ['code' => 200, 'message' => 'Ok'];
		echo json_encode($result);
		return true;
	}
}
