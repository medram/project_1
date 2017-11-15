<?php

class MY_controller extends CI_controller
{
	public function __construct()
	{
		define('MICROTIME',microtime(TRUE));
		//$this->check_the_server_is_ready();
		parent::__construct();
		$this->load->model('cms_model');
		$this->cms_model->site_config(); // get the configuration of my site :D
		date_default_timezone_set(config_item('default_timezone'));
		$this->cms_model->onlineVisitors();
		$this->cms_model->is_closed();
		$this->cms_model->test_login_using_cookie();
	}

	
	private function check_the_server_is_ready ()
	{
		$path = __DIR__.'..\..\..\install'; // the path of instalation folder.
		
		if (file_exists($path))
		{
			header('location: ./install');
			exit();
		}
	}

} // end class


?>