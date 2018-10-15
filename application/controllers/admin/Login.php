<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

		$this->load->library('session');
		if ($this->session->userdata("admin") != NULL)
            redirect("admin/airdrop");
            
        $this->load->model('AdminModel');
        $this->load->helper('form');
        $this->load->helper('alert');
        $this->load->helper('language');
        $language = "english";
        $this->lang->load($language, $language);
    }

    public function index(){
        if(isset($_POST) && !empty($_POST)){
            $data = [];
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->input->post('password');
            $rlt = $this->AdminModel->login($data, true);
            if($rlt) {
                redirect('admin/user');
            }
            else {
                $this->session->set_flashdata('error', lang('incorrect_email_or_username'));
                redirect('login');
            }
        }
        $this->load->view('admin/login');
    }

    public function logout() {
        $this->session->unset_userdata("admin");
        redirect('/');
    }
}
