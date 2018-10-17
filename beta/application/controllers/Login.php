<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
		if($this->session->userdata('email')){
			redirect('Admin/Dashboard/');
		}
		$this->load->model('user_model');
		$this->load->library('form_validation');
	}
	public function index()
	{
		/* if($this->session->userdata('email')){
			redirect('/Login');
		} */
		$data = array(
				'title' => 'My Title',
				'heading' => 'My Heading',
				'message' => 'My Message'
			);
		if($this->input->post('user_login'))
		{
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required',
			array('required' => 'You must provide a %s.')
			);
			if ($this->form_validation->run() == FALSE){
				$this->load->view('Login',$data);	
			}else{
				$form['email']		= $this->input->post('email');
				$form['password'] 	= $this->input->post('password');
				$form['role_id'] 	= 1;
				if($this->user_model->isEmailExists($form['email'],$form['role_id'])){
					$row 				= $this->user_model->login($form);
					$this->session->set_userdata((array)$row);				
					if(empty($row)){
						$data['error'] 	= 'Password is not correct';
						$this->load->view('Login',$data);	
					}else{
						redirect('/Admin/Dashboard');
					}
				}else{
					$data['error'] 	= 'User is not registered';
					$this->load->view('Login',$data);
				}				
			}
		}else{
			$this->load->view('Login',$data);		
		}
	}
}
