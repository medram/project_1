<?php

class MY_controller extends CI_controller
{
	public function __construct()
	{
		define('MICROTIME',microtime(TRUE));

		$this->check_the_server_is_ready();
		parent::__construct();
		$this->load->model('cms_model');
		$this->cms_model->site_config(); // get the configuration of my site :D
		date_default_timezone_set(config_item('default_timezone'));
		
		// language
		$this->check_language();

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

	private function check_language()
	{
		$langs = $this->cms_model->select('languages', ['active' => 1])->result_array();
		$lang_id = config_item('default_language');
		$sym = $this->input->cookie('lang', true);

		// check the cookie
		if (isset($_GET['lang']) && $_GET['lang'] != '')
		{
			// create new cookie
			$sym = $this->input->get('lang', true); // en, ar, ...
			set_cookie('lang', $sym, 30*24*3600); // 30 days
		}

		if ($sym != '')
		{
			foreach ($langs as $k => $row)
			{
				if ($row['symbol'] == $sym)
				{
					$lang_id = $k+1;
					break;
				}
			}
		}


		$language = $langs[$lang_id-1];
		$this->config->set_item('validLang', $language);
		$this->config->set_item('languages', $langs);
	}

} // end class


?>