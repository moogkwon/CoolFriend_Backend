<?php
class Access_model extends CI_Model{
	public function getAccess(){
		$this->db->select('access.*,user.username as Username,user.phoneNumber as phoneNumber');
		$this->db->from('tbl_access_history as access');
		$this->db->join('tbl_users as user','user.id = access.user_id','inner');
		$query = $this->db->get();
		return $query->result();
	}
}