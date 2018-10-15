<?php

class MY_Controller extends CI_Controller {

    public $userData = NULL;
    public $node_server = '192.168.42.1:8443';
    
	public function __construct() {
        parent::__construct();

		$this->load->library('session');
        $this->userData = $this->session->userdata("admin");

		if ($this->userData == NULL)
            redirect("/");

        $this->load->helper('url');
        $this->load->database('default');
    }

    public function getPhotoUrl($url) {
        if ($url == "" || $url == null)
            $url = base_url()."\/asset/img/default.png";
        return $url;
    }
}