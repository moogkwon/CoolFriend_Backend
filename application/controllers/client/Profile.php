<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public $userData = NULL;

	public function __construct() {
          parent::__construct();

		$this->load->library('session');
		$this->userData = $this->session->userdata("user");
		if ($this->userData == NULL)
            redirect("/login");
        
		$this->load->model('login_model');
		$this->load->model('airdrop_user_model');
        $this->load->helper('form');
        $this->load->helper('alert');
		$this->load->helper('language');
		$this->load->helper('campaign');
    }

    public function index(){
		$result = $this->airdrop_user_model->get_table_data();
		$userData = $this->session->userdata('user');
		$username = $this->login_model->get_username();

		$data['avatar'] = $result[0]->avatar;
		$data['email'] = $userData->email;
		$data['username'] = $username;

		$data["social_accounts"] = json_decode($result [0]->social_accounts, true);

        $this->load->view('client/profile',$data);
	}
	
	public function update_profile(){
		$this->login_model->update_username($this->input->post('username'));
		$data['social_accounts'] = json_encode($this->input->post('social_accounts'));
		
		if (!empty($_FILES['avatar']['name'])) {
			$file_ext = explode('.', $_FILES['avatar']['name']);
			$len = count($file_ext);
			if(in_array(strtolower($file_ext[$len-1]), array('jpg','jpeg','png','gif')) == false){
				set_message('error', "Your avatar must be an image!");
				redirect('profile');
			}
			$image_data['upload_path'] = FCPATH.'/asset/uploads';
			$image_data['allowed_types'] = 'jpg|jpeg|png|gif';
			$image_data['max_size'] = '2048';
			$image_data['file_name'] = date("YmdHis");
			
			$this->load->library('upload', $image_data);
			$this->upload->initialize($image_data);
			$this->upload->do_upload('avatar');

			$data['avatar'] = $image_data['file_name'].'.'.$file_ext[$len-1];
		}

		$this->airdrop_user_model->update_data($data);
		set_message('success', "Successfully changed!");
		redirect('profile');
	}

	public function change_password(){
		$data['oldpassword'] = $this->input->post('oldpassword');
		$data['password'] = $this->input->post('password');
		$data['repassword'] = $this->input->post('repassword');
		if($data['password'] != $data['repassword']){
			set_message('error', "Retyped password dosen't match.Please insert same password");
			redirect('profile');
		}
		$result = $this->airdrop_user_model->check_oldpassword($data['oldpassword']);
		if(!$result){
			set_message('error', "Old password dosen't incorrect.Please insert correct old password!");
			redirect('profile');
		}
		$this->airdrop_user_model->update_password($data['password']);
		set_message('success', "Successfully changed!");
		redirect('profile');
	}
}
