<?php

namespace MR4Web\Utils;

class Config 
{
	private static $_config;

	private function __construct(){} 
	private function __clone(){}

	public static function Get($param=null)
	{
		if (empty(self::$_config))
			self::Load();

		/*
		echo '<pre>';
		print_r(self::$_config);
		echo '</pre>';
		*/
		
		if (isset(self::$_config[$param]))
			return self::$_config[$param];
		return NULL;
	} 

	private static function load()
	{
		$path = INC.'config.php';
		//echo $path.'<br>';
		if (file_exists($path))
		{
			self::$_config = include $path; 
		}
	} 
}

?>