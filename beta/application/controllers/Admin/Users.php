<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
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
		$this->load->library('form_validation');
	}
	public function index()
	{
		include(APPPATH.'third_party/vendor/autoload.php');
		$role_id = 2;
		$data['status'] = array(
            -1 => "<i class='fa fa-circle text-danger'/>",
            0 => "<i class='fa fa-circle  text-gray'/>",
            1 => "<i class='fa fa-circle text-success'/>",
        );
		/* $ffmpeg = FFMpeg\FFMpeg::create();
		$video = $ffmpeg->open(FCPATH.'uploads/videos/sample.mp4');
		$video
		->filters()
		->resize(new FFMpeg\Coordinate\Dimension(320, 240))
		->synchronize();
		$video
		->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
		->save(FCPATH.'frame.jpg'); */
		
		/* $video
		->save(new FFMpeg\Format\Video\X264(), 'export-x264.mp4')
		->save(new FFMpeg\Format\Video\WMV(), 'export-wmv.wmv')
		->save(new FFMpeg\Format\Video\WebM(), 'export-webm.webm'); */
		//$data['users'] = $this->user_model->getUsers($role_id);
		$this->load->view('Admin/Users/index',$data);
	}
	public function getData() {
        $search = $this->input->get("search")["value"];
        $order  = $this->input->get('order') [0];
        $start  = $this->input->get("start");
        $length = $this->input->get("length");
		
        $totalCount = $this->user_model->getTotalCount();
        $filterCount = $this->user_model->getFilterCount($search);

        $results = $this->user_model->getData($search, $order, $start, $length);

        $STATUS = array(
            -1 => "<i class='fa fa-circle text-danger'/>",
            0 => "<i class='fa fa-circle  text-gray'/>",
            1 => "<i class='fa fa-circle text-success'/>",
        );
        $GENDER = array("Male", "Female", "Both");
        $LGBTQ = array("No", "Yes");
		
        foreach($results as $index => $result) {
			if($result->video_url){
				$video_url = $result->video_url;
			}else{
				$video_url =  base_url('uploads/videos/sample.mp4');
			}
            $results [$index]->id = $result->id;
            $results [$index]->firstName = $result->firstName;
            $results [$index]->email = $result->email;
            $results [$index]->social = $result->social;
            $results [$index]->birthday = $result->birthday;

            $results [$index]->phoneNumber = $result->phoneNumber;
            $results [$index]->gender = $GENDER [$result->gender];
            $results [$index]->lgbtq = $LGBTQ [$result->lgbtq];
            $results [$index]->action = $this->getAction($result->id, $result->activated);
            $results [$index]->activated = $STATUS [$result->activated];
            $results [$index]->city = $results [$index]->city;
            $results [$index]->state = $results [$index]->state;
            $results [$index]->country = $results [$index]->country;
			if(!empty($result->created)){
				$carteddate = date('Y-m-d H:i:s',strtotime($result->created));
			}else{
				$carteddate = '';
			}
            $results [$index]->created_at = $carteddate;
            $results [$index]->videoshow = '<a href="javascript:void(0);" onclick="onShowModal(\'' . $video_url.'\')">Show</a>';
            $results [$index]->delete_user = '<a href="javascript:void(0);" onclick="deleteUser(\'' . $result->id.'\')">Delete</a>';
        }

        echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        ));
    }
	public function deleteUser($user_id){
		$this->user_model->deleteUser($user_id);
		echo 'success'; exit();
	}
	public function getAction($id, $status) {
        switch ($status) {
            case -1:
                return "<a href='javascript:void(0);' class='btn-approve' data-id='$id'>Unblock</a>";
            case 0:
                return "<a href='javascript:void(0);' class='btn-approve' data-id='$id'>Unblock</a>";
            case 1:
                return "<a href='javascript:void(0);' class='btn-reject' data-id='$id'>Block</a>";
        }
    }

    public function changeStatus($id = 0, $status) {
        if ($id == 0)   return;
        $this->user_model->changeStatus($id, $status);
    }
}