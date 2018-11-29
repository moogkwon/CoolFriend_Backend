<?php
 if($this->session->userdata('user_type')=='admin'){ 
	$this->load->view('elements/left_sidebar_admin');
 }else{
	$this->load->view('elements/left_sidebar_dealer');
 }