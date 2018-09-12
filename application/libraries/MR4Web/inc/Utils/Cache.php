<?php

namespace MR4Web\Utils;

class Cache {

	private $_filename;
	private $_filePath;
	private $_data;
	private $_CI;

	public function __construct ()
	{
		$this->_filename = md5('MR4Web-'.$_SERVER['SERVER_ADDR']);
		$this->_filePath = CACHE_DIR.$this->_filename;
		$this->_CI = &get_instance();
		$this->init();
	}

	private function init()
	{
		$this->_CI->load->library('encryption');
		// load cache it it's found 
		if ($this->isFound())
		{
			logger('Cache was found.');
			$data = $this->load();
			$this->_data = is_array($data)? $data : [] ;
			/*
			echo '<pre>';
			echo 'Cache data: <br>';
			print_r($this->_data);
			echo '</pre>';
			*/
		}
	}

	private function load()
	{
		return json_decode($this->_decode(file_get_contents($this->_filePath)), true);
	}

	public function save($data)
	{
		/*
			the cache has :
				- expiretion time
				- license
				- IP (server host)
				- product name & version
				- customer name & email
		*/
		$data['expire'] = time() + Config::get('cache')['expire'];
		$content = $this->_encode(json_encode($data));
		logger('Cache saving...');
		return file_put_contents($this->_filePath, $content);
	}

	private function _decode($data)
	{
		// do decoding.
		logger('Cashe decrypting...');
		return $this->_CI->encryption->decrypt($data);
	}

	private function _encode($data)
	{
		// do encoding.
		logger('Cashe crypting...');
		return $this->_CI->encryption->encrypt($data);
	}

	public function isFound()
	{
		return file_exists($this->_filePath);
	}

	public function isExpired()
	{
		if ($this->get('expire') > time() && $this->get('expire') < time() + Config::get('cache')['expire'])
			return false;
		return true;
	}

	public function get($key)
	{
		if (isset($this->_data[$key]))
			return $this->_data[$key];
		return NULL;
	}

	public function erase()
	{
		logger('Cache deleting...');
		if($this->isFound())
			unlink($this->_filePath);
	}

}

?>