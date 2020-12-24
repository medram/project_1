<?php

namespace MR4Web\Utils;

class Product {

	private $_data = array();

	public function __construct($version)
	{
		$this->_data['name'] = isset(Config::get('product')['name']) ? Config::get('product')['name']: 'ADLinker' ;
		$this->_data['version'] = $version;
	}

	public function get($key)
	{
		if (isset($this->_data[$key]))
			return $this->_data[$key];
		return NULL;
	}
}

?>