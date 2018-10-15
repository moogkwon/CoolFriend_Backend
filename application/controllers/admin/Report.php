<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {
    
	public function __construct() {
        parent::__construct();

		$this->load->model('ReportModel');
    }
    
	public function index() {
        $data = array();
        $data['title'] = "Management";
        $data['page'] = 'Griit';

		$this->load->view('admin/report/index', $data);
    }

    public function getData() {
        $search = $this->input->get("search")["value"];
        $order  = $this->input->get('order') [0];
        $start  = $this->input->get("start");
        $length = $this->input->get("length");

        $totalCount = $this->ReportModel->getTotalCount();
        $filterCount = $this->ReportModel->getFilterCount($search);

        $results = $this->ReportModel->getData($search, $order, $start, $length);
        
        foreach($results as $index => $result) {
            $results [$index]->userName = "<img src='".$this->getPhotoUrl($results [$index]->photoUrl_user)."' class='profile-table-thumb'>".$result->userName;
            $results [$index]->reporterName = "<img src='".$this->getPhotoUrl($results [$index]->photoUrl_reporter)."' class='profile-table-thumb'>".$result->reporterName;

            $report = $results [$index]->report;
            $report = str_replace("'", "\\'", $report);
            $results [$index]->videoshow = '<a href="#" onclick="onShowModal(\''.$report.'\', \'/upload/report/' . $results [$index]->id .'.jpg\')">Show</a>';
//            $results [$index]->videoshow = '<a href="/upload/report/1.jpg" target="_blank">Show</a>';
        }

        echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        ));
    }
}
