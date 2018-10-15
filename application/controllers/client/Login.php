<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
          parent::__construct();
        
		$this->load->library('session');
		if ($this->session->userdata("user") != NULL)
            redirect("/dashboard");
            
        $this->load->model('login_model');
        $this->load->helper('form');
        $this->load->helper('alert');
        $this->load->helper('language');
        $this->load->helper('messages');
        
		$this->load->library('session');
		$this->load->helper('cookie');
        messages_helper();
        $language = "english";
        $this->lang->load($language, $language);
    }
    
    public function login(){
        if(isset($_POST) && !empty($_POST)){
            $data = [];
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->input->post('password');
			$rlt = $this->login_model->check_login_data($data);
            if($rlt) redirect('dashboard');
            else{
				$data['activation'] = 1;
				$rlt = $this->login_model->check_login_data($data);
				if($rlt) $this->session->set_flashdata('error', 'Activation link sent to you.Please check your email box.');
                else $this->session->set_flashdata('error', lang('incorrect_email_or_username'));
                redirect('login');
            }
        }
        $this->load->view('client/login');
    }

    function send_email($type, $email, &$data) {
        switch ($type) {
            case 'forgot_password':
                return $this->send_email_forgot_password($email, $data);
                break;  

            case 'reset_password':
                return $this->send_email_reset_password($email, $data);
                break;
            
            case 'activate':
                return $this->send_activation_email($email, $data);
                break;
            
        }
    }

    function send_activation_email($email, $data) {

        $email_template = $this->login_model->check_by(array('email_group' => 'activate_account'), 'tbl_email_templates');

        $activate_url = str_replace("{ACTIVATE_URL}", site_url('/login/activate/' . $data['user_id'] . '/' . $data['new_pass_key']), $email_template->template_body);
        $activate_period = str_replace("{ACTIVATION_PERIOD}", $data['activation_period'], $activate_url);
        $username = str_replace("{USERNAME}", $data['username'], $activate_period);
        $user_email = str_replace("{EMAIL}", $data['email'], $username);
        $user_password = str_replace("{PASSWORD}", $data['password'], $user_email);
        $message = str_replace("{SITE_NAME}", config_item('company_name'), $user_password);

        $params['recipient'] = $email;
        $params['subject'] = '[ ' . config_item('company_name') . ' ]' . ' ' . $email_template->subject;
        $params['message'] = $message;
        $params['resourceed_file'] = '';

        $this->login_model->send_email($params);
    }

    function send_email_reset_password($email, $data) {
        $email_template = $this->login_model->check_by(array('email_group' => 'reset_password'), 'tbl_email_templates');

        $message = $email_template->template_body;
        $subject = $email_template->subject;

        $username = str_replace("{USERNAME}", $data['username'], $message);
        $user_email = str_replace("{EMAIL}", $data['email'], $username);
        $user_password = str_replace("{NEW_PASSWORD}", $data['new_password'], $user_email);
        $message = str_replace("{SITE_NAME}", config_item('company_name'), $user_password);

       $params['recipient'] = $email;

        $params['subject'] = '[ ' . config_item('company_name') . ' ]' . $subject;
        $params['message'] = $message;

        $params['resourceed_file'] = '';

        $this->login_model->send_email($params);

    }

    function send_email_forgot_password($email, $data) {

        $email_template = $this->login_model->check_by(array('email_group' => 'forgot_password'), 'tbl_email_templates');

        $message = $email_template->template_body;
        $subject = $email_template->subject;
        $site_url = str_replace("{SITE_URL}", base_url() . 'login', $message);
        $key_url = str_replace("{PASS_KEY_URL}", base_url() . 'login/reset_password/' . $data['user_id'] . '/' . $data['new_pass_key'], $site_url);
        $message = str_replace("{SITE_NAME}", config_item('company_name'), $key_url);

        $params['recipient'] = $email;

        $params['subject'] = '[ ' . config_item('company_name') . ' ] ' . $subject;
        $params['message'] = $message;

        $params['resourceed_file'] = '';
        $this->login_model->send_email($params);

    }

    public function activate($user_id, $new_pass_key){
        $check_reset_pass = $this->login_model->can_reset_password_or_activate($user_id, $new_pass_key, 'login');
        
        if ($check_reset_pass == true) {
            $this->login_model->activate_user($user_id);
            $type = 'success';
            $message = lang('activation_completed');
        } else {
            $type = 'error';
            $message = lang('message_expire');
        }

        set_message($type, $message);
        redirect('login');

    }

    public function reset_password($user_id, $new_pass_key) {
        $data['title'] = lang('welcome_to') . ' ' . config_item('company_name');

        $check_reset_pass = $this->login_model->can_reset_password_or_activate($user_id, $new_pass_key, 'login');
        $random_pass = rand(100000,9999999);
        if ($check_reset_pass == true) {
            $this->login_model->get_reset_password($user_id, $new_pass_key,$random_pass);

            $login_details = $this->db->where('user_id', $user_id)->get('tbl_users')->row();
            $data = array(
                'username' => $login_details->username,
                'email' => $login_details->email,
                'new_password' => $random_pass,
            );
            // Send email with new password
            $this->send_email('reset_password', $data['email'], $data);
            $type = 'success';
            $message = lang('message_new_password_sent');
        } else {
            $type = 'error';
            $message = lang('message_expire');
        }
        set_message($type, $message);
        redirect('login');

        $data['subview'] = $this->load->view('login/forgot_password', $data, TRUE);
        $this->load->view('login', $data);
    }

    public function forgot_password(){
        if(isset($_POST) && !empty($_POST)){
            $login_details = $this->login_model->get_user_details($this->input->post('email'));
            if(!empty($login_details)){
                $data = array(
                    'user_id' => $login_details[0]->user_id,
                    'email' => $login_details[0]->email,
                    'new_pass_key' => md5(rand() . microtime()),
                );
                $this->login_model->set_password_key($data['user_id'],$data['new_pass_key']);

                $this->send_email('forgot_password', $data['email'], $data);

                $type = 'success';
                $message = lang('message_new_password_confirm');
                set_message($type, $message);
                redirect('login');
            }
            else{
                $type = 'error';
                $message = lang('email_error');
                set_message($type, $message);
                redirect('forgot_password');
            }
        }
        $this->load->view('client/forgot_password');
    }

    public function register(){
        if(isset($_POST) && !empty($_POST)){
            $data = [];
            $data['email'] = $this->input->post('email');
            $data['ethereum'] = $this->input->post('ethereum');
            $data['password'] = $this->input->post('password');
            $data['repassword'] = $this->input->post('repassword');
            $data['username'] = $this->input->post('username');

            $result = $this->login_model->check_username_equal($data['username']);
            if($result){
                $type = 'error';
                $message = lang('existing_username');
                set_message($type, $message);
                redirect('register'); 
            }

            $result = $this->login_model->check_email_equal($data['email']);
			if($result){
                $type = 'error';
                $message = lang('existing_email');
                set_message($type, $message);
                redirect('register');
            }

            $this->login_model->register_client($data);

            $login_details = $this->login_model->get_user_details($this->input->post('email'));
            $data = array(
                'user_id' => $login_details[0]->user_id,
                'email' => $login_details[0]->email,
                'new_pass_key' => md5(rand() . microtime()),
            );

            $this->login_model->set_password_key($data['user_id'],$data['new_pass_key']);
            $this->send_email('activate', $data['email'], $data);

            $type = 'success';
            $message = lang('message_registration_completed_1');
            set_message($type, $message);

            //Process Referral
            if (isset($_COOKIE["ref_id"])) {
                $ref_id = $_COOKIE["ref_id"];
                $query = "INSERT INTO airdrop_submits (user_id, note, campaign_id, score, `status`, created_at)
                        VALUES ($ref_id, 'Affiliate one user register', 0, 100, 1, NOW())";
                $this->db->query($query);
                setcookie("ref_id", $ref_id, time()+3600*24*30, '/');
            }
            ///////////////////

            redirect('login');
        }
        $this->load->view('client/register');
    }
}
