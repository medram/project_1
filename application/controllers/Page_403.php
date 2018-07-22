<?php

class Page_403 extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		header('location: '.base_url());
		exit();
		
		$data['title'] = langLine('theme.403.title', false);
		$data['heading'] = langLine('theme.403.title', false);
		$data['message'] = langLine('theme.403.message', false);
		// set header here for SEO
		//$this->output->set_status_header('403');
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/403', $data);
		$this->load->view('templates/footer', $data);
	}
}

?>