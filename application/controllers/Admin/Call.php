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
	private $s3Bucket = 'coolfriend';
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
        $type 	= ($this->input->get("type"))?'random':'';

        $totalCount = $this->call_model->getTotalCount($type);
        $filterCount = $this->call_model->getFilterCount($search,$type);

        $results = $this->call_model->getData($search, $order, $start, $length,$type);
        
        foreach($results as $index => $result) {
			$callerVideo = $this->getVideoLink($result->callerVideo,$result->callerThumb);
			$calleeVideo = $this->getVideoLink($result->calleeVideo,$result->calleeThumb);
			
			$view_url = site_url('Admin/Users/View/'.$result->callerId);
			if($result->callerGender == 'male'){
				$results [$index]->callerId 			= '<a style="color: blue;" href='.$view_url.'>'.$result->callerId.'</a>';
			}else{
				$results [$index]->callerId 			= '<a style="color: red;" href='.$view_url.'>'.$result->callerId.'</a>';
			}
            $results [$index]->callerVideo 	= $callerVideo;
            $results [$index]->callerGender = ucfirst($result->callerGender);
			$view_url = site_url('Admin/Users/View/'.$result->calleeId);
			if($result->calleeGender == 'male'){
				$results [$index]->calleeId 	= '<a style="color: blue;" href='.$view_url.'>'.$result->calleeId.'</a>';
			}else{
				$results [$index]->calleeId 	= '<a style="color: red;" href='.$view_url.'>'.$result->calleeId.'</a>';
			}
            $results [$index]->calleeVideo 	= $calleeVideo;
			if(empty($result->connected_at)&&empty($result->end_at))
			$call_status = 'Canceled';
			if(!empty($result->connected_at)&&!empty($result->end_at))
			$call_status = 'Accepted';
			if(!empty($result->end_at)&&empty($result->connected_at))
			$call_status = 'Rejected';
            $results [$index]->call_status 	= $call_status;
            $results [$index]->duration 	= $result->duration;
        }

        echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        ));
	}
	public function getVideoLink($video,$thumb){
		$this->load->library('s3');
		if($video){
				$video_url = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$video;
				$video_url = S3::getAuthenticatedURL($this->s3Bucket, $video, 10*365*86400, false, true);
		}else{
			$video_url =  base_url('uploads/videos/sample.mp4');
		}
		$thumb = $this->getVideoThumbLink($thumb);
		return '<a href="javascript:void(0);" onclick="onShowModal(\'' . $video_url.'\')" class="show_v"><img src='.$thumb.' class="img-fluid1" height="50px"></a>';
	}
	public function getVideoThumbLink($videoThumb){
		if($videoThumb){
			$video_thumb = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$videoThumb;
		}else{
			$video_thumb =  base_url('uploads/videos/sample.jpg');
		}
		return $video_thumb;
	}
}