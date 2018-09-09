<?php
/**
*	@author: MR4WEB <contact@mr4web.com>.
*	@copyright: 2018 MR4Web
*	@link: http://www.mr4web.com
*	@package: MR4Web. (09/09/2018)
*	@version: 1.0
*/

/*
$MR = new MR4Web();
$MR->activate($purchase_code);
$MR->checkLicense();
$MR->checkUpdate();
$MR->checkNews();
*/

require "MR4Web/init.php";

use MR4web\Utils\Config;
use MR4web\Utils\License;
use MR4web\Utils\Customer;
use MR4web\Utils\Product;
use MR4web\Utils\Cache;

class MR4Web {

	private $_license;
	private $_customer;
	private $_product;
	private $_CI;

	public function __construct()
	{
		$this->_CI = &get_instance();
		$this->init();
	}

	private function init()
	{
		$this->_license = new License(config_item('purchase_code'));
		$this->_product = new Product(config_item('version'));
		$stm = $this->_CI->cms_model->select('users', ['user_status' => 1]);
		$userdata = $stm->row_array();
		$this->_customer = new Customer($userdata);
		$stm->free_result();
	}

	private function curl($URL, array $fields = array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		if (count($fields))
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		}

		$res = json_decode(curl_exec($ch), true);
		curl_close($ch);

		return $res;
	}

	public function activate()
	{
		// get URL
		// build post fields
		$params = array(
			'code' 		=> $this->_license->getPurchaseCode(),
			'domain'	=> $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'],
			'ip'		=> get_client_ip(),
			'c_name'	=> $this->_customer->get('username'),
			'c_email'	=> $this->_customer->get('email'),
			'p_name'	=> $this->_product->get('name'),
			'p_version'	=> $this->_product->get('version')
			);

		// connect to the server
		$res = $this->curl(Config::get('urls')['license'], $data);
		// return results
		if ($res['response']['activate'] == 1)
			return true;

		return false;
	}

	public function checkLicense()
	{
		// let check caching
		$cache = new Cache();
		
		if (!$cache->isFound())
		{
			if ($this->_CI->uri->segment(2) != Config::get('license_page'))
			{
				header("location: ".Config::get('license_page'));
				exit;
			}
		}
		else // cache found => check from the server & store new cache for 1 to 5 days.
		{
			/*
			*	the cache has :
			*		- expiretion time
					- license
					- IP (server host)
					- product name & version
					- customer name & email

			*/
		}
	}

	public function checkUpdate()
	{

	}

	public function checkNews()
	{

	}

}


?>