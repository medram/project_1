<?php

namespace MR4Web\Utils;

class License {

	private $_purchaseCode;

	public function __construct($purchaseCode)
	{
		$this->_purchaseCode = $purchaseCode;
	}

	public function getPurchaseCode()
	{
		return $this->_purchaseCode;
	}
}


?>