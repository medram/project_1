<?php

namespace MR4Web\Utils;

class Customer {

	private $_data = array();

	public function __construct(array $userdata)
	{
		$this->_data = $userdata;
	}

	public function get($key)
	{
		if (isset($this->_data[$key]))
			return $this->_data[$key];
		return NULL;
	}
}

?>