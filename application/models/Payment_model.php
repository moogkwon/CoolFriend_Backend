<?php
class Payment_model extends CI_Model{
	public function getPayments(){
		$this->db->select('payment.*,user.first_name as Username,user.id as user_id,user.email as email,user.phone as phoneNumber,user.gender as gender');
		$this->db->from('user_payments as payment');
		$this->db->join('users as user','user.id = payment.user_id','inner');
		$query = $this->db->get();
		return $query->result();
	}
}