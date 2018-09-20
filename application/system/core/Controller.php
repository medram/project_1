<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		self::check_mr4web_api();
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

	private static function check_mr4web_api()
	{
		if (self::finalHash() != 'e9f826eada5ead3db15ea42456f8c5973f0fd48a')
		{
			exit('<pre>'.base64_decode('UGxlYXNlIERvbid0IE1lc3MgV2l0aCBNUjRXZWIgQVBJLg==').'</pre>');
		}
	}

	private static function getHash($path)
	{
	    if (file_exists($path))
	    {
	        $data = preg_replace('/([\s\t\n\r]*)/', '', file_get_contents($path));
	        return hash('md5', $data);
	    }

	    return NULL;
	}

	private static function getFolderHashArray($path, array $skipped = array())
	{
		$path = rtrim($path).'/';
		$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
		$path = str_replace('/', DIRECTORY_SEPARATOR, $path);

		$hashes = [];
		if (is_dir($path))
		{
			$files = array_diff(scandir($path), array('.', '..'), $skipped);
			/*echo "<pre>";
			print_r($files);
			echo "</pre>";*/
			foreach ($files as $file)
			{
				if (is_dir($path.$file))
					$hashes = array_merge($hashes, self::getFolderHashArray($path.$file));
				else if (is_file($path.$file))
				{
					//echo "<pre>file:".$path.$file." => ".self::getHash($path.$file)."</pre>";
					$hashes[] = self::getHash($path.$file);
				}
			}
		}

		return $hashes;
	}

	private static function getFolderHash($path, array $skipped = array())
	{
		$path = rtrim($path, '/');
		$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
		$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
		
		if (is_dir($path))
		{
			$hashes = self::getFolderHashArray($path, $skipped);
			/*
			echo "<pre>";
			print_r($hashes);
			echo "</pre>";
			*/
			return sha1(implode('', $hashes));
		}
		return NULL;
	}

	private static function finalHash()
	{
		$DEBUG = false;
		$MR4webFolder = APPPATH.'libraries/MR4Web/';
		$MR4webClass = APPPATH.'libraries/MR4Web.php';
		$MY_Controller = APPPATH.'core/MY_Controller.php';

		$skipped = ['cache']; // cache folder

		$hash = sha1(self::getHash($MY_Controller).self::getHash($MR4webClass).self::getFolderHash($MR4webFolder, $skipped));

		if ($DEBUG)
			die($hash);
		
		return $hash;
	}
}
