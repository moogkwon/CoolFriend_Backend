<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->database('default');
    }

	public function index() {
		$this->load->view('home/index');
	}

	public function ref($ref_id = 0) {
		if ($ref_id != 0 && !isset($_COOKIE["ref_id"])) {
			$query = "INSERT INTO airdrop_submits (user_id, note, campaign_id, score, `status`, created_at)
					VALUES ($ref_id, 'Affiliate one user visit.', 0, 1, 1, NOW())";
			$this->db->query($query);
			setcookie("ref_id", $ref_id, time()+3600*24*30, '/');
		}
		redirect(base_url(), 'refresh');
	}
}
