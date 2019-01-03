<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notifications extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('email')){
			redirect('Login/');
		}
		$this->load->model('user_model');
		$this->load->model('general_model');
		$this->load->model('notification_model');
		$this->load->library('form_validation');
		$this->status_arr = array('New','Ready to send','Sending','Finished');
	}
	public function index()
	{
		$data['title'] 			= '';
		$data['type'] 			= '';
		$data['content'] 		= '';
		$data['status']			= '0';
		$data['active']			= '0';
		$data['countries']		= $this->general_model->getCountries();
		$data['users']			= $this->user_model->getUsers();
		$data['status_arr'] 	= $this->status_arr;
		$data['added_date'] 	= '';
		if($this->input->post('save_noti')){
			$form_data 					= [];
			$form_data['title'] 		= $this->input->post('title');
			$form_data['type'] 			= $this->input->post('type');
			$form_data['content'] 		= $this->input->post('content');
			$form_data['status']		= (string)$this->input->post('status');
			$form_data['added_date'] 	= $this->input->post('added_date');
			$form_data['created_date'] 	= date('Y-m-d H:i:s');
			$form_data['updated_date'] 	= date('Y-m-d H:i:s');
			$res 						= $this->notification_model->insertNotification($form_data);
			$this->session->set_flashdata('success', 'Notification Added Successfully.');
			redirect('Admin/Notifications/');
		}
		if($this->input->post('search')){
			$form_data 					= [];
			$form_data['activity'] 		= $this->input->post('activity');
			$form_data['title'] 		= $this->input->post('title');
			$form_data['type'] 			= $this->input->post('type');
			//$form_data['content'] 		= $this->input->post('content');
			$form_data['country_id'] 	= $this->input->post('country_id');
			$form_data['state_id'] 		= $this->input->post('state_id');
			$form_data['city_id'] 		= $this->input->post('city_id');
			$form_data['status']		= (string)$this->input->post('status');
			$form_data['gender']			= (string)$this->input->post('gender');
			$form_data['lgbtq']				= $this->input->post('status');
			$form_data['birth_year_from'] 	= $this->input->post('birth_year_from');
			$form_data['birth_year_to'] 	= $this->input->post('birth_year_to');
			$form_data['added_date'] 		= $this->input->post('added_date');
			$form_data['created_date'] 		= date('Y-m-d H:i:s');
			$form_data['updated_date'] 		= date('Y-m-d H:i:s');
			if(!empty($this->input->post('user_ids'))){
				$form_data['user_ids'] 		= $this->input->post('user_ids');
			}
			$filtered_noti 					= $this->notification_model->filterNotifications($form_data);
			echo '<pre>'; print_r($filtered_noti); echo '</pre>'; die(__FILE__.' On this line '.__LINE__);
			if($filtered_noti){
				$data['notifications'] 			= $this->notification_model->insertFilteredNotification($form_data,$filtered_noti);
				$this->session->set_flashdata('success', 'Filtered Notification Added Successfully.');
				redirect('Admin/Notifications/');
			}else{
				$this->session->set_flashdata('success', 'Filtered Notification was not found.');
				redirect('Admin/Notifications/');
			}
		}else{
			$data['notifications'] 		= $this->notification_model->getNotifications();
		}
		$data['noti_types'] = $this->notification_model->getNotiType();
		$this->load->view('Admin/Notification/index',$data);
	}
	public function Confirm(){
		if($this->input->get('search')){
			$form_data 	= $this->formData();
			$user_check = $this->notification_model->filterCheckUsers($form_data);	
			if($user_check){
				$filtered_noti 					= $this->notification_model->filterNotifications($form_data);
				if($filtered_noti){
					$data['user_checks'] = $user_check;
					$data['form_data'] = $form_data;
					$data['user_ids'] = isset($form_data['user_ids'])?$form_data['user_ids']:'';
					$data['filtered_notis'] = $filtered_noti;
					unset($data['form_data']['user_ids']);
					$this->load->view('Admin/Notification/confirm',$data);
				}else{
					$this->session->set_flashdata('success', 'Filtered Notification was not found.');
					redirect('Admin/Notifications/');
				}
			}else{
				$this->session->set_flashdata('success', 'No user found for filtered condition.');
				redirect('Admin/Notifications/');
			}
		}
		if($this->input->post('confirm_submit')){
			$form_data 						= $this->formData();
			$form_data['checked_user'] 		= $this->input->post('checked_user');
			$filtered_noti 		= $this->notification_model->filterNotifications($form_data);
			
			if($filtered_noti){
				$data['notifications'] 			= $this->notification_model->insertFilteredNotification($form_data,$filtered_noti);
				$this->session->set_flashdata('success', 'Filtered Notification Added Successfully.');
				redirect('Admin/Notifications/');
			}else{
				$this->session->set_flashdata('success', 'Filtered Notification was not found.');
				redirect('Admin/Notifications/');
			}
		}
	}
	public function formData(){
		$form_data 					= [];
		$form_data['activity'] 		= $this->input->get_post('activity');
		$form_data['title'] 		= $this->input->get_post('title');
		$form_data['type'] 			= $this->input->get_post('type');
		//$form_data['content'] 		= $this->input->post('content');
		$form_data['country_id'] 	= $this->input->get_post('country_id');
		$form_data['state_id'] 		= $this->input->get_post('state_id');
		$form_data['city_id'] 		= $this->input->get_post('city_id');
		$form_data['status']		= (string)$this->input->get_post('status');
		$form_data['gender']			= (string)$this->input->get_post('gender');
		$form_data['lgbtq']				= $this->input->get_post('lgbtq');
		$form_data['birth_year_from'] 	= $this->input->get_post('birth_year_from');
		$form_data['birth_year_to'] 	= $this->input->get_post('birth_year_to');
		$form_data['added_date'] 		= $this->input->get_post('added_date');
		$form_data['created_date'] 		= date('Y-m-d H:i:s');
		$form_data['updated_date'] 		= date('Y-m-d H:i:s');
		if(!empty($this->input->get_post('user_ids'))){
			$form_data['user_ids'] 		= $this->input->get_post('user_ids');
		}
		
		return $form_data;
	}
	public function Filtered(){
		$data['notifications'] 	= $this->notification_model->filteredNotifications();
		$data['status_arr'] 	= $this->status_arr;
		$this->load->view('Admin/Notification/filtered',$data);
	}
	public function getData()
	{
		$search = $this->input->get("search")["value"];
        $order  = $this->input->get('order') [0];
        $start  = $this->input->get("start");
        $length = $this->input->get("length");
        $totalCount		= $this->notification_model->getTotalCount();
        $filterCount	= $this->notification_model->getFilterCount($search);
        $results		= $this->notification_model->getData($search, $order, $start, $length);
		foreach($results as $index => $result){
			 $results [$index]->id = $result->id;
			 $results [$index]->title = $result->title;
			 $results [$index]->type = $result->type;
			 $results [$index]->content = $result->content;
			 $results [$index]->status = $result->status;
			 $results [$index]->added_date = $result->added_date;
			 $results [$index]->action = 'edit';
		}
		echo json_encode(array(
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $filterCount,
            "data" => $results
        )); exit();
	}
	public function deleteData(){
		if(isset($_POST['ids'])&&!empty($_POST['ids'])){
			//$ids = implode(',',$_POST['ids']);
			$this->notification_model->deleteData($_POST['ids']);
			$this->session->set_flashdata('success', 'Notification Deleted Successfully.');
		}
	}
	public function getDataByID(){
		if(isset($_POST['noti_id'])&&!empty($_POST['noti_id'])){
			$data['notification'] = $this->notification_model->getNotifications($_POST['noti_id']);
			$data['noti_types'] = $this->notification_model->getNotiType();
			$data['status_arr'] = $this->status_arr;
			$result = array(
				'view' => $this->load->view('Admin/Notification/edit',$data,true),
			);
			$this->output->set_output( $this->load->view('Admin/Notification/edit',$data,true));
		}
	}
	public function update($id){
		if(!empty($id)){
			$form_data 					= [];
			$form_data['id'] 			= $id;
			$form_data['title'] 		= $this->input->post('title');
			$form_data['type'] 			= $this->input->post('type');
			$form_data['content'] 		= $this->input->post('content');
			$form_data['status']		= (string)$this->input->post('status');
			$form_data['added_date'] 	= $this->input->post('added_date');
			$form_data['updated_date'] 	= date('Y-m-d H:i:s');
			$this->notification_model->updateNotification($form_data);
		}
		$this->session->set_flashdata('success', 'Notification Updated Successfully.');
		redirect('Admin/Notifications/');
	}
	public function Send(){
		$this->load->library('email');
		$this->email->from('admin@coolfriend.co', 'coolfriend');
		$this->email->to('ashish@zonvoir.com');
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');
		$res = $this->email->send();
		if (!$res){
		$this->email->print_debugger();
		echo '<pre>'; print_r($this->email->print_debugger()); echo '</pre>'; die(__FILE__.' On this line '.__LINE__);
		}
		$this->session->set_flashdata('success', 'Notification Sent Successfully.');
		echo 'sent'; exit();
	}
}