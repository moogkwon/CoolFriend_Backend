<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	*/
	public $s3Bucket = 'coolfriend';
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('email')){
			redirect('Login/');
		}
		//$this->load->library('s3');
		$this->load->model('user_model');
		$this->load->model('report_model');
	}
	public function index()
	{
		$data['reports'] = $this->report_model->getReports();
		$this->load->view('Admin/Report/index',$data);
	}
	public function MostReportedUser(){
		$data['reports'] = $this->report_model->mostReportedUsers();
		//echo '<pre>'; print_r($data['reports']); echo '</pre>'; die(__FILE__.' On this line '.__LINE__);
		$this->load->view('Admin/Report/most_reported_user',$data);
	}
}