<?php

namespace MR4Web\Utils;

class Cache {

	private $_filename;
	private $_data;
	private $_CI;

	public function __construct ()
	{
		$this->_filename = md5('MR4Web-'.$_SERVER['SERVER_ADDR']);
		$this->_CI = &get_instance();
		$this->init();
	}

	private function init()
	{
		// load cache it it's found 
		if ($this->isFound())
		{
			$this->_data = $this->load();
		}
	}

	private function load()
	{
		return $this->_decode(file_get_contents(CACHE_DIR.$this->_filename));
	}

	public function save($data)
	{
		return file_put_contents($this->_filename, $this->_encode($data));
	}

	private function _decode($data)
	{
		// do decoding.
		return $data;
	}

	private function _encode($data)
	{
		// do encoding.
		return $data;
	}

	public function isFound()
	{
		return file_exists($this->_filename);
	}

	public function isExpired()
	{

	}

	public function erase()
	{

	}

}

?>