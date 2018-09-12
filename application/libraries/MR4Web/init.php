<?php

define('DEBUG', false);
define('DEBUG_SHOW_OPERATIONS', false);

define('ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
define('INC', ROOT.'inc/');
define('CACHE_DIR', ROOT.'cache/');

require_once INC.'common.php';

/*
* autoload classes.
*/
spl_autoload_register(function ($filename){
	//echo $filename.'<br>';
	$path = str_ireplace('MR4Web\\', INC, $filename);
	$path = $path.'.php';
	$path = str_ireplace('\\', '/', $path);

	//echo '<pre><b>Loading ...</b> '.$path.'</pre>';
	if (file_exists($path))
		require $path;
	else
		echo "<pre>Fatal Error: The Class <b>\"".$filename."\"</b> Not Found on this path <b>".$path."</b></pre>";
});

?>