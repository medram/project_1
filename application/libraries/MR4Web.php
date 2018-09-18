<?php
/**
*	@author: MR4WEB <contact@mr4web.com>.
*	@copyright: 2018 MR4Web
*	@link: http://www.mr4web.com
*	@package: MR4Web. (09/09/2018)
*	@version: 1.0
*/

require "MR4Web/init.php";

use MR4web\Utils\Config;
use MR4web\Utils\License;
use MR4web\Utils\Customer;
use MR4web\Utils\Product;
use MR4web\Utils\Cache;

class MR4Web {

	private $_cache;
	private $_license;
	private $_customer;
	private $_product;
	private $_CI;
	private $_response;

	public function __construct()
	{
		$this->_CI = &get_instance();
		$this->init();
	}

	private function init()
	{
		// make a listener class on the codeigniter constractor
		$this->makerListener();

		$this->_cache = new Cache();
		$this->_license = new License(config_item('purchase_code'));
		$this->_product = new Product(config_item('version'));
		$stm = $this->_CI->cms_model->select('users', ['user_status' => 1]);
		$userdata = $stm->row_array();
		$this->_customer = new Customer($userdata);
		$stm->free_result();
	}

	public function activate($purchaseCode = NULL)
	{
		logger('Activating from a server...');
		// get URL
		// build post fields
		$params = array(
			'action'	=> 'activate',
			'code' 		=> $purchaseCode != NULL ? $purchaseCode : $this->_license->getPurchaseCode(),
			'domain'	=> $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'],
			'ip'		=> $_SERVER['SERVER_ADDR'] == '::1' ? '127.0.0.1' : $_SERVER['SERVER_ADDR'],
			'c_name'	=> $this->_customer->get('username'),
			'c_email'	=> $this->_customer->get('email'),
			'p_name'	=> $this->_product->get('name'),
			'p_version'	=> $this->_product->get('version'),
			'listener'	=> base_url(Config::get('listener')['pagename'])
			);

/*		echo '<pre>';
		print_r($params);
		echo '</pre>';
*/

		// connect to the server
		$this->_response = MyCURL(Config::get('URLs')['license'], $params);

/*		echo '<pre>';
		print_r($this->_response);
		echo '</pre>';
*/
		// return results
		if (isset($this->_response['response']['activate']) && $this->_response['response']['activate'] == 1)
		{
			logger('license is <b>OK</b>.');
			array_shift($params);
			$this->_cache->save($params);
			return true;
		}

		logger('license is <b>BAD</b>.');
		return false;
	}

	public function deactivate($purchaseCode = NULL)
	{
		logger('Deactivating from a server...');
		// get URL
		// build post fields
		$params = array(
			'action'	=> 'deactivate',
			'code' 		=> $purchaseCode != NULL ? $purchaseCode : $this->_license->getPurchaseCode(),
			'ip'		=> $_SERVER['SERVER_ADDR']
			);

/*		echo '<pre>';
		print_r($params);
		echo '</pre>';
*/

		// connect to the server
		$this->_response = MyCURL(Config::get('URLs')['license'], $params);

/*		echo '<pre>';
		print_r($this->_response);
		echo '</pre>';
*/		// return results
		if (isset($this->_response['response']['deactivate']) && $this->_response['response']['deactivate'] == 1)
		{
			logger('license is <b>OFF</b>.');
			if ($purchaseCode == $this->_license->getPurchaseCode())
				$this->_cache->erase();
			return true;
		}

		logger('license is <b>Not OFF</b>.');
		return false;
	}

	public function getResMessage()
	{
		if (isset($this->_response['response']['message']))
			return $this->_response['response']['message'];
		return NULL;
	}

	public function checkLicense()
	{
		logger('start checking a license...');
		if (!$this->_cache->isFound() && config_item('purchase_code') == '')
		{
			redirectToLicensePage();
		}
		else // cache found => check from the server & store new cache for 1 to 5 days.
		{
			logger('start checking a Cache...');
			// check the cache file if it's valid with this server & decoded properly
			if ($this->_cache->isExpired() 
				|| $this->_cache->get('ip') != ($_SERVER['SERVER_ADDR'] == '::1' ? '127.0.0.1' : $_SERVER['SERVER_ADDR']) 
				|| $this->_cache->get('code') != config_item('purchase_code')
				|| $this->_cache->get('p_name') != Config::get('product')['name']
				|| $this->_cache->get('p_version') != config_item('version')
				)
			{
				logger('Cache is not valid');
				$this->_cache->erase();
				// check & save new Cache 
				if (!$this->activate())
				{
					redirectToLicensePage();
				}
			}
			else
			{
				logger('Cache is Valid.');
			}
		}
	}

	// check manually (automatically every week) for new Updates & News. 
	public function checkUpdates()
	{
		if (config_item('last_update') < time())
		{
			logger('Checking New Stuff from the Server...');
			// do the update...
			$this->_CI->cms_model->update('settings', ['option_value' => time() + Config::get('check_update_every')], ['option_name' => 'last_update']);

			$data['check'] = 'Im_alive';
			$d['product_name'] = Config::get('product')['name'];
			$d['product_version'] = config_item('version');
			$d['IP'] = $_SERVER['SERVER_ADDR'] == '::1'? '127.0.0.1' : $_SERVER['SERVER_ADDR'];
			$data['data'] = json_encode($d);
			MyCURL(Config::get('URLs')['check'], $data);
		}
	}

	public function makerListener()
	{
		$filename = Config::get('listener')['pagename'];
		$path = APPPATH."controllers/{$filename}.php";
		if (!file_exists($path))
		{
			$content = file_get_contents(INC.Config::get('listener')['template']);
			$content = str_replace('%CLASS_NAME%', $filename, $content);
			file_put_contents($path, $content);
		}
	}

	public function debugStatus()
	{
		return (bool)DEBUG;
	}

}


?>