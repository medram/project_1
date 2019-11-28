<?php

class closed extends MY_Controller
{
	public $data;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = config_item('sitename');
		$this->data['shutdown_msg'] = get_config_item('shutdown_msg');

		$this->load->view('errors/cli/error_closed',$this->data);
	}

}

?>