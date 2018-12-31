<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class General extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('email')){
			redirect('Login/');
		}
		$this->load->model('general_model');
	}
	public function getStates($country_id = false){
		$country_id 	= $this->input->post('country_id');
		$data['states'] = $this->general_model->getStates($country_id);
		$data['title']  = 'State';
		$this->output->set_output( $this->load->view('Admin/Notification/dropdown',$data,true));
	}
	public function getCities($state_id = false){
		$state_id 	= $this->input->post('state_id');
		$data['cities'] = $this->general_model->getCities($state_id);
		$data['title']  = 'City';
		$this->output->set_output( $this->load->view('Admin/Notification/dropdown',$data,true));
	}
}