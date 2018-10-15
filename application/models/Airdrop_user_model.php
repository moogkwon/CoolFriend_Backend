<?php
/**
 * Description of client_model
 *
 * @author yakov
 */
class Airdrop_User_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
	}
	
	public function get_table_data(){
		$userData = $this->session->userdata("user");
		$this->db->select('*')
        ->from('airdrop_user_info')
        ->where("(airdrop_user_info.user_id  = '$userData->user_id')");
        $result = $this->db->get()->result();
		return $result;
	}

	public function update_data($data){
		$userData = $this->session->userdata("user");
		$this->db->set('social_accounts', $data['social_accounts']);
		$userData->social_accounts = json_decode($data ["social_accounts"], true);
		if(isset($data['avatar'])){
			$this->db->set('avatar', $data['avatar']);
			$userData->avatar = $data ["avatar"];
		}
        $this->db->where('user_id', $userData->user_id);
		$this->db->update('airdrop_user_info');

		$this->session->set_userdata(array("user" => $userData));
	}

	public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
	}

	public function check_oldpassword($data,$flag=0){
		
		$sha_password = $this->hash($data);
		$userData = $this->session->userdata("user");
		$param = $userData->user_id;
		if($flag) $param = 1;
		$this->db->select('*')
        ->from('tbl_users')
		->where("(tbl_users.user_id  = '$param')");
		$result = $this->db->get()->result();
		return $result[0]->password == $sha_password;
	}

	public function update_password($data,$flag=0){
		$sha_password = $this->hash($data);
		$userData = $this->session->userdata("user");
		$param = $userData->user_id;
		if($flag) $param = 1;
		$this->db->set('password', $sha_password);
        $this->db->where('user_id',$param);
        $this->db->update('tbl_users');
	}
    
}
