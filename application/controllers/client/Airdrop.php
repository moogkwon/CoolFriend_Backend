<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Airdrop extends CI_Controller {

	public $userData = NULL;

	public function __construct() {
        parent::__construct();

		$this->load->library('session');
		$this->userData = $this->session->userdata("user");
		if ($this->userData == NULL)
			redirect("/login");
		
		$this->load->helper('url');
        $this->load->database('default');
		$this->load->model('ConfigModal');
    }
    
	public function index() {
		$user_id = $this->userData->user_id;

		$query = "SELECT total_score 
				FROM airdrop_user_info
				WHERE user_id = $user_id";
		$totalScore = $this->db->query($query)->result()[0]->total_score;

		$query = "SELECT COUNT(id) AS total,
						SUM(IF(total_score > $totalScore, 1, 0)) AS rank
				FROM airdrop_user_info";
		$result = $this->db->query($query)->result()[0];
		$totalCount = $this->db->query($query)->result()[0]->total;
		$rank = $result->rank;

		$tempRank = $rank - 5;
		if ($tempRank < 0)	$tempRank = 0;

		$query = "SELECT airdrop_user_info.user_id,
						username,
						email,
						total_score,
						avatar
				FROM airdrop_user_info
				JOIN tbl_users ON(airdrop_user_info.user_id = tbl_users.user_id)
				WHERE activated = 1 AND role_id = 2
				ORDER BY total_score DESC
				LIMIT $tempRank, 10";
		$result = $this->db->query($query)->result();

		$this->load->view('client/airdrop', array(
			"user_id" => $user_id,
			"list" => $result,
			"total" => $totalCount,
			"totalScore"=>$totalScore,
			"rank" => $rank,
			"tempRank" => $tempRank
		));
	}

    public function logout() {
        $this->session->unset_userdata("user");
        redirect('/');
    }
}
