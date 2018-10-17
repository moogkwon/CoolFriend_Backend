<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Call extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('email')){
			redirect('Login/');
		}
		$this->load->model('user_model');
		$this->load->model('call_model');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['calls'] = $this->call_model->getCalls();
		$this->load->view('Admin/Call/index',$data);
	}
	public function getData(){
		$search = $this->input->get("search")["value"];
        $order  = $this->input->get('order') [0];
        $start  = $this->input->get("start");
        $length = $this->input->get("length");

        $totalCount = $this->call_model->getTotalCount();
        $filterCount = $this->call_model->getFilterCount($search);

        $results = $this->call_model->getData($search, $order, $start, $length);
        
        foreach($results as $index => $result) {
            $results [$index]->id 			= $result->id;
            $results [$index]->type 		= $result->type;
            $results [$index]->callerName 	= $result->callerName;
            $results [$index]->callerEmail 	= $result->callerEmail;
            $results [$index]->calleeName 	= $result->calleeName;
            $results [$index]->calleeEmail 	= $result->calleeEmail;
            $results [$index]->connected_at = date('Y-m-d H:i:s',strtotime($result->connected_at));
            $results [$index]->end_at = date('Y-m-d H:i:s',strtotime($result->end_at));
            $results [$index]->duration 	= $result->duration;
        }

        echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        ));
	}
}