<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Call extends MY_Controller {
    
	public function __construct() {
        parent::__construct();

		$this->load->model('CallModel');
    }
    
	public function index() {
        $data = array();
        $data['title'] = "Management";
        $data['page'] = 'Griit';

		$this->load->view('admin/call/index', $data);
    }

    public function getData() {
        $search = $this->input->get("search")["value"];
        $order  = $this->input->get('order') [0];
        $start  = $this->input->get("start");
        $length = $this->input->get("length");

        $totalCount = $this->CallModel->getTotalCount();
        $filterCount = $this->CallModel->getFilterCount($search);

        $results = $this->CallModel->getData($search, $order, $start, $length);
        
        foreach($results as $index => $result) {
            $results [$index]->no = $start + $index + 1;
        }

        echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        ));
    }
}
