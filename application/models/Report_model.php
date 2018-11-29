<?php
class Report_model extends CI_Model {
	
	public function getReports(){
		$this->db->select(	"complaints.id, 
							user.id AS userID,
							user.blocked AS blocked,
							user.first_name AS userName,
							user.phone AS userPhone,
							user.email AS userEmail,
							user.avatar AS photoUrl_user,
							reporter.first_name AS reporterName,
							reporter.last_name AS reporterlName,
							reporter.phone AS reporterPhone,
							reporter.email AS reporterEmail,
							reporter.avatar AS photoUrl_reporter,
							message,
							screenshot,
							complaints.dated"
		);
		$this->db->from('complaints');
		$this->db->join('users as reporter','applicant = reporter.id','inner');
		$this->db->join('users as user','suspect = user.id','inner');
		$this->db->order_by('complaints.id','DESC');
		$query  = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function getReporteeScreenshots($user_id){
		$this->db->select('T1.*');
		$this->db->from('complaints T1');
		//$this->db->join('users T2','T1.suspect = ','inner');
		$this->db->where('T1.suspect',$user_id);
		$query	= $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function getReporteeCount($user_id){
		$this->db->select("c1.suspect,COUNT(c1.suspect) total,(SELECT count(message) FROM complaints c2 Where c1.suspect  = c2.suspect And c2.message = 'Person is mean') person_mean,(SELECT count(message) FROM complaints c2 Where c1.suspect  = c2.suspect And c2.message = 'Person is nude') person_nude,(SELECT count(message) FROM complaints c2 Where c1.suspect  = c2.suspect And c2.message = 'Inappropriate video profile ')  inappropriate");
		$this->db->from('complaints c1');
		//$this->db->join('users T2','T1.suspect = ','inner');
		$this->db->where('c1.suspect',$user_id);
		$this->db->group_by('c1.suspect');
		$query  = $this->db->get();
		$result = $query->row();
		return $result;
	}
	public function mostReportedUsers(){
		$this->db->select("c1.suspect,COUNT(c1.suspect) total,user.email email,user.blocked blocked,(SELECT count(message) FROM complaints c2 Where c1.suspect  = c2.suspect And c2.message = 'Person is mean') person_mean,(SELECT count(message) FROM complaints c2 Where c1.suspect  = c2.suspect And c2.message = 'Person is nude') person_nude,(SELECT count(message) FROM complaints c2 Where c1.suspect  = c2.suspect And c2.message = 'Inappropriate video profile ')  inappropriate");
		$this->db->from('complaints c1');
		$this->db->where('user.blocked',0);
		$this->db->join('users as user','c1.suspect = user.id','inner');
		$this->db->group_by('c1.suspect');
		$query  = $this->db->get();
		$result = $query->result();
		return $result;
	}
}