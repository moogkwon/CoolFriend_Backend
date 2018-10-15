<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
    
	public function __construct() {
        parent::__construct();
        
        $this->load->helper('form');
        $this->load->helper('alert_helper');
        $this->load->model('AdminModel');
    }
    
	public function index() {
        $this->load->view('admin/user/profile');
	}

	function change_password(){
		$data['oldpassword'] = $this->input->post('oldpassword');
		$data['password'] = $this->input->post('password');
        $data['repassword'] = $this->input->post('repassword');
        
		if($data['password'] != $data['repassword']){
			set_message('error', "Retyped password dosen't match.Please insert same password");
			redirect('admin/profile');
		}
		$result = $this->AdminModel->checkOldPwd($data['oldpassword']);
		if(!$result){
			set_message('error', "Old password dosen't incorrect.Please insert correct old password!");
			redirect('admin/profile');
		}

		$this->AdminModel->updatePwd($data['password']);
		set_message('success', "Successfully changed!");
		redirect('admin/profile');
	}
}
