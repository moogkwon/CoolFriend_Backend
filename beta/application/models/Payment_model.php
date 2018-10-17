<?php
class Payment_model extends CI_Model{
	public function getPayments(){
		$this->db->select('payment.*,user.username as Username,user.phoneNumber as phoneNumber');
		$this->db->from('tbl_payment as payment');
		$this->db->join('tbl_users as user','user.id = payment.user_id','inner');
		$query = $this->db->get();
		return $query->result();
	}
}