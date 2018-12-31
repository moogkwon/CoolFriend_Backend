<?php
class General_model extends CI_Model{
	public function getCountries(){
		$this->db->select('*');
		$this->db->from('countries');
		$query = $this->db->get();
		$rows  = $query->result();
		return $rows;
	}
	public function getStates($country_id = false){
		$this->db->select('*');
		$this->db->from('states');
		if($country_id)
		$this->db->where('country_id',$country_id);
		$query = $this->db->get();
		$rows  = $query->result();
		//echo '<pre>'; print_r($this->db->last_query()); echo '</pre>'; die(__FILE__.' On this line '.__LINE__);
		return $rows;
	}
	public function getCities($state_id = false){
		$this->db->select('*');
		$this->db->from('cities');
		if($state_id)
		$this->db->where('state_id',$state_id);
		$query = $this->db->get();
		$rows  = $query->result();
		return $rows;
	}
}