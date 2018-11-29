<?php
class Login_model extends CI_Model {
	public function checkUser(){
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('email',$this->input->post('email'));
		$query 	= $this->db->get();
		$row 	= $query->row();
		if(!empty($row)){
			$row = $this->checkLogin();
			return $row;
		}else{
			return false;
		}
	}
	public function checkLogin(){
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('password',md5($this->input->post('password')));
		$query 	= $this->db->get();
		$row 	= $query->row();
		return $row;
	}
}