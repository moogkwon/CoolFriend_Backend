<?php
/**
 * Description of client_model
 *
 * @author yakov
 */
class Login_Model extends CI_Model {

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function __construct() {
        parent::__construct();
		$this->load->library('session');
    }
    public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
	}

	public function update_username($data){
		$userData = $this->session->userdata("user");
		$this->db->set('username', $data);
        $this->db->where('user_id', $userData->user_id);
        $this->db->update('tbl_users');
	}

	public function get_username(){
		$userData = $this->session->userdata("user");
		$this->db->select('*')
        ->from('tbl_users')
        ->where('user_id', $userData->user_id);
		$result = $this->db->get()->result();
		return $result[0]->username;
	}
	
    public function register_client($data){

        $sha_password = $this->hash($data['password']);
        $sql = "INSERT INTO tbl_users (email, password, eth_address,username)
                VALUES ("."'".$data['email']."','".$sha_password."','".$data['ethereum']."','".$data['username']."')";
        $this->db->query($sql);

        $query = "SELECT MAX(user_id) AS user_id FROM tbl_users";
        $user_id = $this->db->query($query)->result()[0]->user_id;

        $query = "INSERT INTO airdrop_user_info (user_id, social_accounts) VALUES ($user_id, '{}')";
        $this->db->query($query);

    }

    public function get($p_key = NULL, $type = FALSE) {

        if ($p_key != NULL) {
            $convert = $this->_primary_filter;
            $p_key = $convert($p_key);
            $this->db->where($this->_primary_key, $p_key);
            $return_type = 'row';
        } elseif ($type == TRUE) {
            $return_type = 'row';
        } else {
            $return_type = 'result';
        }
        return $this->db->get($this->_table_name)->$return_type();
    }

    public function check_login_data($data, $isAdmin = false){
        $sha_password = $this->hash($data['password']);
        $this->db->select('*')
        ->from('tb_admin')
        ->where("(email = '$data[email]' AND password = '$sha_password')");
        $result = $this->db->get()->result();

        if(!empty($result))
        {
            $this->db->set("lastLogin", "NOW()")
                    ->where("email", $data["email"])
                    ->update("tb_admin");
                    
            $this->session->set_userdata(array("admin" => $result [0]));
            return true;
        }
        else return false;
    }

    public function get_user_details($data){
        $this->db->select('*')
        ->from('tbl_users')
        ->where("(tbl_users.email = '$data')");
        $result = $this->db->get()->result();
        return $result;
    }

    function set_password_key($user_id, $new_pass_key) {
        $this->db->set('new_password_key', $new_pass_key);
        $this->db->set('new_password_requested', date('Y-m-d H:i:s'));
        $this->db->where('user_id', $user_id);
        $this->db->update('tbl_users');
        return $this->db->affected_rows() > 0;
    }

    public function check_by($sql_condition, $tbl_name) {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $this->db->where($sql_condition);
        $query_result = $this->db->get();
        $return_data = $query_result->row();
        return $return_data;
    }

    function send_email($email_data) {

        if (config_item('use_postmark') == 'TRUE') {
            $image_data = array('api_key' => config_item('postmark_api_key'));
            $this->load->library('postmark', $image_data);
            $this->postmark->from(config_item('postmark_from_address'), config_item('company_name'));
            $this->postmark->to($email_data['recipient']);
            $this->postmark->subject($email_data['subject']);
            $this->postmark->message_plain($email_data['message']);
            $this->postmark->message_html($email_data['message']);
            
            if (isset($email_data['resourcement_url'])) {
                $this->postmark->resource($email_data['resourceed_file']);
            }
            $this->postmark->send();
        } else if (config_item('use_mailgun') == 'true') {
			$mail = [];
			$mail['to'] = $email_data['recipient'];
			$mail['from'] = config_item('mailgun_from');
			$mail['subject'] = $email_data['subject'];
			$mail['body'] = $email_data['message'];
			
			return $Email = sendmail($mail);
		}else {
            if (config_item('protocol') == 'smtp') {
                $this->load->library('encrypt');
                $smtp_pass = config_item('smtp_pass');
                $image_data = array(
                    'smtp_host' => config_item('smtp_host'),
                    'smtp_port' => config_item('smtp_port'),
                    'smtp_user' => config_item('smtp_user'),
                    'smtp_pass' => $smtp_pass,
                    'crlf' => "\r\n",
                    'protocol' => config_item('protocol'),
                    'smtp_auth'=>true
                );
            }

            $image_data['mailtype'] = "html";
            $image_data['newline'] = "\r\n";
            $image_data['charset'] = 'utf-8';
            $image_data['wordwrap'] = TRUE;
            $image_data['priority'] = "1";
			
            $this->load->library('email', $image_data);
            $this->email->from(config_item('company_email'), config_item('company_name'));
            
			$this->email->to($email_data['recipient']);

            $this->email->subject($email_data['subject']);
            $this->email->message($email_data['message']);
            if ($email_data['resourceed_file'] != '') {
                $this->email->resource($email_data['resourceed_file']);
            }
            $status = $this->email->send();
        }
    }

    function activate_user($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->set('activated',1);
        $this->db->update('tbl_users');
    }

    function check_username_equal($username){
        $this->db->where('activated', 1);
        $this->db->where('username', $username);
        $query = $this->db->get('tbl_users');
        return $query->num_rows() >= 1;
    }

    function check_email_equal($email){
        $this->db->where('activated', 1);
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_users');
        return $query->num_rows() >= 1;
    }

    function can_reset_password_or_activate($user_id, $new_pass_key) {
        //$expire_period = 900;
        $this->db->select('1', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->where('new_password_key', $new_pass_key);
       // $this->db->where('UNIX_TIMESTAMP(new_password_requested) >', time() - $expire_period);
        $query = $this->db->get('tbl_users');
        return $query->num_rows() == 1;
    }

    function get_reset_password($user_id, $new_pass_key,$random_pass=null) {
        //$expire_period = 900;
		if(isset($random_pass) && !empty($random_pass)){
			$this->db->set('password', $this->hash($random_pass));
		}else{
			$this->db->set('password', $this->hash('123456'));
		}
        $this->db->set('new_password_key', NULL);
        $this->db->set('new_password_requested', NULL);
        $this->db->where('user_id', $user_id);
        //$this->db->where('new_password_key', $new_pass_key);
        //$this->db->where('UNIX_TIMESTAMP(new_password_requested) >=', time() - $expire_period);
        $this->db->update('tbl_users');
        return $this->db->affected_rows() > 0;
    }
}
