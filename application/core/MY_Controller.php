<?php

$ALERT_MESSAGES = [];

// register all Hooks in the glocal scoop to be accessable everywhere.
require_once APPPATH."helpers/register_hooks.php";

class MY_controller extends CI_controller
{
	public function __construct()
	{
		define('MICROTIME', microtime(TRUE));

		//$this->check_the_server_is_ready();
		parent::__construct();
		$this->load->model('cms_model');
		$this->cms_model->site_config(); // get the configuration of my site :D
		date_default_timezone_set(config_item('default_timezone'));

		// language
		$this->check_language();
		// check the license.
		$this->check_license_updates_news();
		$this->cms_model->onlineVisitors();
		$this->cms_model->is_closed();
		$this->cms_model->test_login_using_cookie();
	}

	public function __destruct()
	{
		global $ALERT_MESSAGES;
	    //$CI->load->helper('cookie');
	    if (is_array($ALERT_MESSAGES))
	    {
		    set_cookie('ALERT_MESSAGES', json_encode($ALERT_MESSAGES), 86500000);
	    }
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
		$langs = get_langs();
		$default_lang = get_default_lang();
		$language = $default_lang; // get and use the default language (default value).
		$sym = $this->input->cookie('lang', true);

		// check the cookie
		if (isset($_GET['lang']) && $_GET['lang'] != '')
		{
			// create new cookie
			$sym = $this->input->get('lang', true); // en, ar, ...
			set_cookie('lang', $sym, 30*24*3600); // 30 days
		}

		// Getting and set language by cookie.
		if ($sym != '')
		{
			foreach ($langs as $k => $l)
			{
				if ($l['symbol'] == $sym)
				{
					$language = $l;
					break;
				}
			}
		}

		// echo "default:";
		// print_r(get_default_lang());
		// echo "will be used:";
		// print_r($language);

		$this->config->set_item('validLang', $language);
		$this->config->set_item('languages', $langs);
	}

	private function check_license_updates_news()
	{
		$MR = $this->load->library('MR4Web', '', 'MR');
		$this->MR->checkLicense();
		$this->MR->checkUpdates();
	}
} // end class


?>
