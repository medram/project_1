<?php

return [
	'URLs'	=> [
		//'license' => 'http://localhost/test/api/v1/license.php',
		//'check' 	=> 'http://localhost/test/api/v1/check.php'
		'license' 	=> 'https://checkout.mr4web.com/api/v1/license.php',
		'check' 	=> 'https://checkout.mr4web.com/api/v1/update.php'
	],

	'cache'	=> [
		// expire time in seconds
		'expire'	=> 24*3600 // 1 days
	],
	
	'product'	=> [
		'name'	=> 'ADLinker'
	],
	
	'license_page' => 'license', // the license checker page name
	'listener'	=> [
		'pagename'	=> 'MR4Web_Listener_'.sha1($_SERVER['SERVER_ADDR']),
		'template'	=> 'listener.tpl.php'
	],
	'check_update_every'	=> 7*24*3600, // 1 week
];

?>