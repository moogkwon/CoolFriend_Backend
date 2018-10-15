<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
    
	public function __construct() {
        parent::__construct();

		$this->load->model('UserModel');
    }
    
	public function index() {
        $data = array();
        $data['title'] = "Management";
        $data['page'] = 'Griit';

		$this->load->view('admin/user/index', $data);
    }

    public function getData() {
        $search = $this->input->get("search")["value"];
        $order  = $this->input->get('order') [0];
        $start  = $this->input->get("start");
        $length = $this->input->get("length");

        $totalCount = $this->UserModel->getTotalCount();
        $filterCount = $this->UserModel->getFilterCount($search);

        $results = $this->UserModel->getData($search, $order, $start, $length);

        $STATUS = array(
            -1 => "<i class='fa fa-circle text-danger'/>",
            0 => "<i class='fa fa-circle  text-gray'/>",
            1 => "<i class='fa fa-circle text-success'/>",
        );
        $GENDER = array("Male", "Female", "Both");

        foreach($results as $index => $result) {
            $results [$index]->no = $start + $index + 1;

            $results [$index]->phoneNumber = "<img src='".$this->getPhotoUrl($result->photoUrl)."' class='profile-table-thumb'>".$result->phoneNumber;
            $results [$index]->gender = $GENDER [$result->gender];
            $results [$index]->action = $this->getAction($result->id, $result->activated);
            $results [$index]->activated = $STATUS [$result->activated];
            $results [$index]->location = $results [$index]->city ." , ". $results [$index]->country;
            $results [$index]->videoshow = '<a href="#" onclick="onShowModal(\'http://' . $this->node_server."\/video/".$results [$index]->id .'.mov\')">Show</a>';
        }

        echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        ));
    }

    function getAction($id, $status) {
        switch ($status) {
            case -1:
                return "<a href='#' class='btn-approve' data-id='$id'>Unblock</a>";
            case 0:
                return "<a href='#' class='btn-approve' data-id='$id'>Unblock</a>";
            case 1:
                return "<a href='#' class='btn-reject' data-id='$id'>Block</a>";
        }
    }

    function changeStatus($id = 0, $status) {
        if ($id == 0)   return;
        $this->UserModel->changeStatus($id, $status);
    }
}
