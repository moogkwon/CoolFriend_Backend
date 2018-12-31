<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
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
	 private $s3Bucket = 'coolfriend';
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('email')){
			redirect('Login/');
		}
		$this->load->model('user_model');
		$this->load->model('report_model');
		$this->load->model('call_model');
		$this->load->library('form_validation');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$role_id = 2;
		$data['status'] = array(
            0 => "<i class='fa fa-circle text-success'/>",
            0 => "<i class='fa fa-circle  text-success'/>",
            1 => "<i class='fa fa-circle text-danger'/>",
        );
		
		/* $ffmpeg = APPPATH.'third_party/ffmpeg';
		

//video dir
$video = FCPATH.'uploads/videos/sample.mp4';

//where to save the image
$image = FCPATH.'uploads/videos/sample.jpg';

//time to take screenshot at
$interval = 2;

//screenshot size
$size = '720x360';

//ffmpeg command

$cmd = "$ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y -s $size $image 2>&1"; 
$return = shell_exec($cmd); */
		$this->load->view('Admin/Users/index',$data);
	}
	public function View($user_id = false){
		$this->load->library('s3');
		$user			= $this->user_model->getUserById($user_id,'users');
		$reports		= $this->report_model->getReporteeScreenshots($user_id);
		$reporteecount	= $this->report_model->getReporteeCount($user_id);
		$all_calls		= $this->call_model->userAllCalls($user_id);
		$in_coming_conn	= $this->call_model->inComingConnected($user_id);
		$in_coming		= $this->call_model->inComingCall($user_id);
		$in_coming_s	= $this->call_model->inComingSelective($user_id);
		$in_coming_r	= $this->call_model->inComingRandom($user_id);
		$out_going_conn	= $this->call_model->outGoingConnected($user_id);
		$out_going		= $this->call_model->outGoingCall($user_id);
		$out_going_r	= $this->call_model->outGoingSelective($user_id);
		$out_going_s	= $this->call_model->outGoingRandom($user_id);
		/*  echo '<pre>'; print_r($reporteecount); echo '</pre>'; die(__FILE__.' On this line '.__LINE__);  */
		if($user->video){
			$video_url = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$user->video;
			$video_url = S3::getAuthenticatedURL($this->s3Bucket, $user->video, 10*365*86400, false, true);
		}else{
			$video_url =  base_url('uploads/videos/sample.mp4');
		}
		if($user->thumbnail){
			$video_thumb = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$user->thumbnail;
		}else{
			$video_thumb =  base_url('uploads/videos/sample.jpg');
		}
		if($user->avatar){
			if(strpos($user->avatar, "http://") !== false || strpos($user->avatar, "https://") !== false){
			$profile_picture =  $user->avatar;
			}else{
			$profile_picture = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$user->avatar;
			}
		}else{
			$profile_picture =  base_url('assets/img/img1.jpg');
		}
		$data['user']				=  $user;
		$data['video_url']			=  $video_url;
		$data['video_thumb']		=  $video_thumb;
		$data['profile_picture']	=  $profile_picture;
		$data['reports']			=  $reports;
		$data['all_calls']			=  $all_calls;
		$data['in_coming']			=  $in_coming;
		$data['in_coming_s']		=  $in_coming_s;
		$data['in_coming_r']		=  $in_coming_r;
		$data['out_going']			=  $out_going;
		$data['out_going_r']		=  $out_going_r;
		$data['out_going_s']		=  $out_going_s;
		$data['out_going_conn']		=  $out_going_conn;
		$data['in_coming_conn']		=  $in_coming_conn;
		$data['reportee_count']		=  $reporteecount;
		$data['bucket']				=  $this->s3Bucket;
		$this->load->view('Admin/Users/view',$data);
	}
	public function getData(){
		$this->load->library('s3');
        $search = $this->input->get("search")["value"];
        $order  = $this->input->get('order') [0];
        $start  = $this->input->get("start");
        $length = $this->input->get("length");
        $blocked = $this->input->get("blocked");
		
        $totalCount = $this->user_model->getTotalCount();
        $filterCount = $this->user_model->getFilterCount($search,$blocked);

        $results = $this->user_model->getData($search, $order, $start, $length,$blocked);

        $STATUS = array(
            0 => "<i class='fa fa-circle text-success'/>",
            1 => "<i class='fa fa-circle text-danger'/>",
        );
        $GENDER = array("Male", "Female", "Both");
        $LGBTQ = array("No", "Yes");
		
        foreach($results as $index => $result) {
			if($result->video_url){
				$video_url = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$result->video_url;
				$video_url = S3::getAuthenticatedURL($this->s3Bucket, $result->video_url, 10*365*86400, false, true);
			}else{
				$video_url =  base_url('uploads/videos/sample.mp4');
			}
			if($result->video_thumb){
				$video_thumb = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$result->video_thumb;
			}else{
				$video_thumb =  base_url('uploads/videos/sample.jpg');
			}
			if($result->avatar){
				if(strpos($result->avatar, "http://") !== false || strpos($result->avatar, "https://") !== false){
				$profile_picture =  $result->avatar;
				}else{
				$profile_picture = 'https://s3.amazonaws.com/'.$this->s3Bucket.'/'.$result->avatar;
				}
			}else{
				$profile_picture =  base_url('assets/img/img1.jpg');
			}
			$id = $result->id;
			$view_url =  base_url('Admin/Users/View/'.$id);
			if($result->gender == 'female'){
				$results [$index]->id = '<a style="color: red" href='.$view_url.'>'.$id.'</a>';
			}else{
				$results [$index]->id = '<a style="color: blue" href='.$view_url.'>'.$id.'</a>';
			}
            $results [$index]->profile_picture = '<a href='.$profile_picture.' class="popup-ajax"><img src='.$profile_picture.' class="img-fluid" width="50px"></a>';
            $results [$index]->ig_username = $result->instagram;
            $results [$index]->username = $result->first_name;
            $results [$index]->first_name = $result->first_name;
            $results [$index]->last_name = $result->last_name;
            $results [$index]->email = $result->email;
            $results [$index]->social = $result->social;
            $results [$index]->birthyear = $result->birthyear;

            $results [$index]->phoneNumber = $result->phone;
            $results [$index]->gender = $result->gender;
            $results [$index]->lgbtq = $LGBTQ [$result->lgbtq];
            $results [$index]->action = $this->getAction($id, $result->blocked);
            $results [$index]->activated = $STATUS [$result->blocked];
            $results [$index]->city = $results [$index]->location_city;
            $results [$index]->state = $results [$index]->location_state;
            $results [$index]->country = $results [$index]->location_country;
			if(!empty($result->created_at)){
				$carteddate = date('Y-m-d H:i:s',strtotime($result->created_at));
			}else{
				$carteddate = '';
			}
			if($result->video_rejected)
			$view_v = 'Rejected';
			else
			$view_v = 'Reject Video';
				
			$asa = "onclick='deleteUser(".$id.")'";
            $results [$index]->created_at = $carteddate;
            $results [$index]->videoshow = '<a href="javascript:void(0);" onclick="onShowModal(\'' . $video_url.'\')" class="show_v"><img src='.$video_thumb.' class="img-fluid1" height="50px"></a><p><a href="javascript:void(0);" onclick="rejectVideo('.$id.');">'.$view_v.'</a></p>';
            $results [$index]->delete_user = '<a href="javascript:void(0);" '.$asa.'>Delete</a>';
        }

        echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        )); exit();
    }
	public function deleteUser($user_id){
		$this->user_model->deleteUser($user_id);
		echo 'success'; exit();
	}
	public function getAction($row_id, $status) {
        switch ($status) {
            case 0:
                return '<a href="javascript:void(0);" class="btn-reject" data-id='.$row_id.'>Block</a>';
            case 1:
                return '<a href="javascript:void(0);" class="btn-approve" data-id='.$row_id.'>Unblock</a>';
        }
    }

    public function changeStatus($id = 0, $status) {
        if ($id == 0)   return;
        $this->user_model->changeStatus($id, $status);
    }
	public function rejectVideo($id = 0) {
        if ($id == 0)   return;
        $this->user_model->rejectVideo($id);
    }
	public function BlockedUser(){
        $data['users'] = $this->user_model->getBlockedUser();
		$this->load->view('Admin/Users/blocked',$data);
	}
}