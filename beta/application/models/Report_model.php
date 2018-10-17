<?php
class Report_model extends CI_Model {
	
	public function getReports(){
		$this->db->select(	"tbl_report.id, 
							user.id AS userID,
							user.activated AS activated,
							user.firstName AS userName,
							user.phoneNumber AS userPhone,
							user.email AS userEmail,
							user.photoUrl AS photoUrl_user,
							reporter.firstName AS reporterName,
							reporter.phoneNumber AS reporterPhone,
							reporter.email AS reporterEmail,
							reporter.photoUrl AS photoUrl_reporter,
							report,
							report_image,
							tbl_report.created_at"
					);
		$this->db->from('tbl_report');
		$this->db->join('tbl_users as reporter','reporter_id = reporter.id','inner');
		$this->db->join('tbl_users as user','user_id = user.id','inner');
		$query  = $this->db->get();
		$result = $query->result();
		return $result;
	}
}