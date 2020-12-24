<?php

class Home extends MY_controller
{

	public function __construct ()
	{
		parent::__construct();
	}

	public function index ()
	{
		$data['title'] = config_item('sitename');
	
		$this->load->view("templates/header",$data);
		$this->load->view("pages/home",$data);
		$this->load->view("templates/footer",$data);

	}

}


?>