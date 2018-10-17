<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
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
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('email')){
			redirect('Login/');
		}
		$this->load->model('user_model');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$user_id 				= $this->session->userdata('id');
		$userDetails 			= $this->user_model->getUserById($user_id);
		$data['id'] 			= $userDetails->id;
		$data['username'] 		= $userDetails->username;
		$data['phoneNumber'] 	= $userDetails->phoneNumber;
		$data['city'] 			= $userDetails->city;
		$data['country'] 		= $userDetails->country;
		if($this->input->post('profile_update')){
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('phoneNumber', 'Phone number', 'required');
			if ($this->form_validation->run() == FALSE){
				$data['validation_errors'] = $this->form_validation->error_array();
				$this->load->view('Admin/Profile/index',$data);	
			}else{
				$form['id']				= $this->session->userdata('id'); 
				$form['username']		= $this->input->post('username'); 
				$form['phoneNumber']	= $this->input->post('phoneNumber'); 
				$form['password']		= $this->input->post('password'); 
				$form['city']			= $this->input->post('city'); 
				$form['country']		= $this->input->post('country'); 
				$usernameExist 			= $this->user_model->checkMyUsername($form); 
				
				if(!($usernameExist)){
					$row 				= $this->user_model->update($form);
				}else{
					if($usernameExist){
						$this->session->set_flashdata('error','Username already taken');
					}
					redirect('/Admin/Profile/');
					$this->load->view('Admin/Profile/index',$data);
				}
				if(isset($row)&&$row){
					$this->session->set_flashdata('success_msg','Profile Updated.'); 
					redirect('/Admin/Profile/');
				}
								
			}
		}else{
			$this->load->view('Admin/Profile/index',$data);
		}
	}
	public function do_upload()
	{
		$config['upload_path']          = './uploads/registration/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 2048;
		$config['max_width']            = 0;
		$config['max_height']           = 0;
		$config['remove_spaces']        = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('reg_file'))
		{
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}
	public function MyOrders(){
		$user_id 		= $this->session->userdata('id');
		$data['orders'] = $this->order_model->getMyOrders($user_id);
		$this->load->view('Admin/Orders/myorders',$data);
	}
}