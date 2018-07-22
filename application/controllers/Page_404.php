<?php

class Page_404 extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = langLine('theme.404.title', false);
		$data['heading'] = langLine('theme.404.title', false);
		$data['message'] = langLine('theme.404.message', false);

		// set header here for SEO
		$this->output->set_status_header('404');
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/404', $data);
		$this->load->view('templates/footer', $data);
	}
}

?>