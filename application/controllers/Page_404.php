<?php

class Page_404 extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = config_item('sitename').' : هذه الصفحة غير موجودة';
		$data['heading'] = 'هذه الصفحة غير موجودة';
		$data['message'] = 'عذرا فهذه الصفحة غير متوفرة حاليا ، ربما قد حدفت أو ما شابه !';

		// set header here for SEO
		$this->output->set_status_header('404');
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/404', $data);
		$this->load->view('templates/footer', $data);
	}
}

?>