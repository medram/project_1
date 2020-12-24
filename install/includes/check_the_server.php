<?php

$err = array();
/*
if (file_exists('../install'))
{
	$err[] = 'You can\'t install the site again !';
}
*/

/*=============== You can remove this if you are confident that your PHP version is sufficient. ====*/
if (version_compare(PHP_VERSION,'5.6') < 0)
{
	$err[] = 'Your <b>PHP version</b> must be 5.6 or higher.';
}

if (version_compare(PHP_VERSION,'7.5') >= 0)
{
	$err[] = 'Your <b>PHP version</b> must be 5.6, 7.3 or 7.4, that\'s what this application supports for the time being.';
}

/*=============== Check if the mod_rewrite is enabled ====================*/
if (function_exists('apache_get_modules'))
{
	if (!in_array('mod_rewrite', apache_get_modules()))
	{
		$err[] = 'You must enable <b>mod_rewrite</b> on your server.';
	}
}
/*else
{

	die("The 'apache_get_modules' function is undefined!");
}
*/
/*=============== Check if the file_get_contents() exists ====================*/

if (!function_exists('file_get_contents'))
{
	$err[] = 'You must enable <b>file_get_contents</b> function on your server.';
}

/*=============== Check for curl extension ====================*/

if (!in_array('curl', get_loaded_extensions()))
{
	$err[] = 'You must enable <b>curl</b> extension on PHP.';
}

/*=============== Check for gd extension ====================*/

if (!in_array('gd', get_loaded_extensions()))
{
	$err[] = 'You must enable <b>gd</b> extension on PHP.';
}

/*=============== Check for mysqli extension ====================*/

if (!in_array('mysqli', get_loaded_extensions()))
{
	$err[] = 'You must enable <b>mysqli</b> extension on PHP.';
}

/*=============== Check for PDO extension ====================*/

if (!in_array('PDO', get_loaded_extensions()))
{
	$err[] = 'You must enable <b>PDO</b> extension on PHP.';
}

/*=============== Check for pdo_mysql extension ====================*/

if (!in_array('pdo_mysql', get_loaded_extensions()))
{
	$err[] = 'You must enable <b>pdo_mysql</b> extension on PHP.';
}

/*=============== Check for json extension ====================*/

if (!in_array('json', get_loaded_extensions()))
{
	$err[] = 'You must enable <b>json</b> extension on PHP.';
}

/*=============== Check if the file_put_contents() exists ====================*/

if (!function_exists('file_put_contents'))
{
	$err[] = 'You must enable <b>file_put_contents</b> function on your server.';
}

/*==========================================*/

/*
if (!extension_loaded('mcrypt'))
{
	$err = 'mcript is not loaded';
}
*/

/*=============== Check if application,uploads folders are writable ========*/
//define('DS','\\');
//$path = "..\\";

$temp 	= array();
$temp[] = 'tmps';
$temp[] = '../uploads';
$temp[] = '../application';

foreach ($temp as $dir)
{
	if (!file_exists($dir))
	{
		$err[] = 'the folder <b>"'.basename($dir).'"</b> not found.';
		continue;
	}

	if (!is_writable($dir))
	{
		$err[] = 'this folder <b>"'.basename($dir).'"</b> must be writable.';
	}
}

/*=============== Check if config file and database file are exists ============*/
//define('DS','\\');
//$path = "";

$temp 	= array();
$temp[] = 'tmps/db.tmp.sql';
$temp[] = 'tmps/config.tmp.php';
$temp[] = 'tmps/database.tmp.php';
$temp[] = 'tmps/tmp.htaccess';
$temp[] = '../application/config/config.php';
$temp[] = '../application/config/database.php';
$temp[] = '../.htaccess';

foreach ($temp as $file)
{
	if (!file_exists($file))
	{
		$err[] = 'the file <b>"'.basename($file).'"</b> not found.';
		continue;
	}

	if (!is_writable($file))
	{
		$err[] = 'this file <b>"'.basename($file).'"</b> must be writable.';
	}
}

/*=============== Check fopen function exists ============*/

if (!function_exists('fopen'))
{
	$err[] = 'the <b>"fopen"</b> function isn\'t exists, you must enable it.';
}









if (count($err) > 0)
{
	echo '<pre>';
	foreach ($err as $e)
	{
		echo "- ".$e."<br>";
	}
	echo '</pre>';
	exit();
}

/*
echo __DIR__.'<br>';
echo '<pre>';
//print_r(apache_get_modules());
//echo apache_get_version();
echo '</pre>';
*/
?>
