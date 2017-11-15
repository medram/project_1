<?php

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