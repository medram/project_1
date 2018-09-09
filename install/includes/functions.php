<?php

/*---------------- check the mess with files ----------------*/
/*if (getHash('index.php') != '77fcc661d4b8664237b467b46943c768')
{
	die("Please Don't mess with instalation files at the <b>'install'</b> folder!");
}*/

function getHash($path)
{
	if (file_exists($path))
	{
		$data = preg_replace('/([\s\t\n\r]*)/', '', file_get_contents($path));
		return hash('md5', $data);
	}

	return NULL;
}

function _addslashes ($str)
{
	if (get_magic_quotes_gpc())
	{
		return $str;
	}
	else
	{
		return addslashes($str);
	}
}


?>