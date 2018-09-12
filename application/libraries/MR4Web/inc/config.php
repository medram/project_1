<?php

return [
	'URLs'	=> [
		'license' 	=> 'http://localhost/test/api/v1/license.php',
		'update'	=> 'https://api.mr4web.com/update.php',
		'news'		=> 'https://api.mr4web.com/news.php' 
	],

	'cache'	=> [
		// expire time in seconds
		'expire'	=> 24*3600 // 1 days
	],
	
	'product'	=> [
		'name'	=> 'ADLinker'
	],
	
	'license_page' => 'license', // the license checker page name
];

?>