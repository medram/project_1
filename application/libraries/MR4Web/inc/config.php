<?php

return [
	'URLs'	=> [
		'license' 	=> 'http://localhost/test/gateway/api/v1/license.php',
		'update' 	=> 'http://localhost/test/gateway/api/v1/update.php'
	],

	'cache'	=> [
		// expire time in seconds
		'expire'	=> 24*3600 // 1 days
	],
	
	'license_page' => 'license', // the license checker page name
	'listener'	=> [
		'pagename'	=> 'MR4Web_Listener_'.sha1($_SERVER['SERVER_ADDR'].'/'.$_SERVER['SERVER_NAME']),
		'template'	=> 'listener.tpl.php'
	],
	'check_update_every'	=> 24*3600, // 1 day
];

?>