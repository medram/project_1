<?php
/**
*	@author: MR4WEB <contact@mr4web.com>.
*	@copyright: 2018 MR4Web
*	@link: https://www.mr4web.com
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

	private function _getHostIP()
	{
		if (isset($_SERVER['SERVER_ADDR']))
			return $_SERVER['SERVER_ADDR'];
		return '127.0.0.1';
	}

	private function _getDomain()
	{
		return 'http://'.$_SERVER['HTTP_HOST'];
	}

	private function init()
	{
		// make a listener class on the codeigniter constractor
		#$this->makerListener();

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
			'domain'	=> $this->_getDomain(),
			'ip'		=> $this->_getHostIP(),
			'c_name'	=> $this->_customer->get('username'),
			'c_email'	=> $this->_customer->get('email'),
			'p_name'	=> $this->_product->get('name'),
			'p_version'	=> $this->_product->get('version'),
			'listener'	=> base_url(Config::get('listener')['pagename'])
			);

/*		echo '<pre>';
		print_r($params);
		echo '</pre>';*/


		// connect to the server
		$this->_response = MyCURL(Config::get('URLs')['license'], $params);

/*		echo '<pre>';
		print_r($this->_response);
		echo '</pre>';*/

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
			'ip'		=> $this->_getHostIP(),
			'domain'	=> $this->_getDomain()
			);

		// echo '<pre>';
		// print_r($params);
		// echo '</pre>';


		// connect to the server
		$this->_response = MyCURL(Config::get('URLs')['license'], $params);

		// echo '<pre>';
		// print_r($this->_response);
		// echo '</pre>';
		// return results
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
				|| $this->_cache->get('ip') != $this->_getHostIP()
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

	// check manually (automatically every day/week) for new Updates & News.
	public function checkUpdates($type = 'all')
	{
		if (config_item('last_update') < time())
		{
			logger('Checking New Stuff from the Server...');
			// do the update...
			$this->_CI->cms_model->update('settings', ['option_value' => time() + Config::get('check_update_every')], ['option_name' => 'last_update']);

			$data['check'] = $type;
			$data['license'] = config_item('purchase_code');
			$data['p_version'] = config_item('version');
			$data['IP'] = $this->_getHostIP();
			$receivedData = MyCURL(Config::get('URLs')['update'], $data);

			/*
			{
			    "status": 1,
			    "news": [
			        {
			            "id": "1",
			            "title": "ADLinker v1.5 coming soon.",
			            "description": "Be ready, And Make Sure That you Get your Newest Version.",
			            "image_URL": "http://localhost/ci-copy/img/pexels-1.jpg",
			            "news_URL": "http://www.mr4web.com/news/ADLinker-v1.5-coming-soon",
			            "created": "2018-11-29 20:04:18",
			            "products_id": "1"
			        },
			        {
			            "id": "2",
			            "title": "Earn Coins Calculator - just for $15.",
			            "description": "Earn Coins Calculator will helps you to save your calculation time, easy to use, fast access and more.",
			            "image_URL": "http://localhost/ci-copy/img/pexels-2.jpg",
			            "news_URL": "http://www.mr4web.com/news/Earn-Coins-Calculator-just-for-$15.",
			            "created": "2018-11-29 20:04:18",
			            "products_id": "1"
			        }
			    ],
			    "software": {
			        "product": {
			            "id": "1",
			            "name": "ADLinker",
			            "version": "1.2",
			            "small_desc": "Revenue Accelerator",
			            "email_support": "adlinker@moakt.ws",
			            "created": "2018-10-22 20:16:16"
			        },
			        "update": {
			            "id": "1",
			            "paid": "0",
			            "download_url": "http://updates.mr4web.com/test3.zip",
			            "created": "2018-11-29 20:04:18",
			            "products_id": "1",
			            "plans_id": "7"
			        },
			        "features": [
			            {
			                "desc": "Advanced Dashboard & Analytics."
			            },
			            {
			                "desc": "Includes Supports For 6 Months."
			            },
			            {
			                "desc": "And More Features Comming SOON."
			            }
			        ]
			    }
			}
			*/
			if (isset($receivedData['status']) && $receivedData['status'] == 1)
			{
				// update news
				if (isset($receivedData['news']) && count($receivedData['news']))
				{
					logger("Updating news...");
					// auto truncate news table.
					$this->_CI->db->truncate('news');

					$err = 0;
					foreach ($receivedData['news'] as $news)
					{
						$insert = [
							'title' 		=> isset($news['title'])? $news['title'] : '',
							'description' 	=> isset($news['description'])? $news['description'] : '',
							'image_URL'		=> isset($news['image_URL'])? $news['image_URL'] : '',
							'news_URL'		=> isset($news['news_URL'])? $news['news_URL'] : '',
							'created'		=> isset($news['created'])? $news['created'] : ''
						];

						if (!$this->_CI->cms_model->insert('news', $insert))
						{
							$err = 1;
							break;
						}
					}

					if (!$err)
					{
						// auto show notification "News" label
						$this->_CI->cms_model->update('settings', ['option_value' => '0'],['option_name' => 'viewed_news']);
					}
				}


				// update software
				$this->_CI->db->truncate('updates');
				if (isset($receivedData['software']) && is_array($receivedData['software']))
				{
					logger('Updating software data...');
					// auto truncate updates table.
					//$this->_CI->db->truncate('updates');
					$softUpdate = $receivedData['software'];

					$customData = array(
							'product_name' 			=> $softUpdate['product']['name'],
							'product_version' 		=> $softUpdate['product']['version'],
							'update_download_url' 	=> $softUpdate['update']['download_url'],
							'features' 				=> json_encode($softUpdate['features']),
							'time' 					=> $softUpdate['product']['created']
						);


					$this->_CI->cms_model->insert('updates', $customData);
				}
			}

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
