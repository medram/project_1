<?php

function get_tables($db_prefix='my_')
{
	$tables = [
		'contact',
		'languages',
		'links',
		'news',
		'online',
		'pages',
		'settings',
		'statistics',
		'updates',
		'users',
		'usersmeta',
	];

	// adding $db_prefix
	foreach($tables as $key => $table_name)
	{
		$tables[$key] = $db_prefix.$table_name;
	}

	return $tables;
}

function get_base_url($sub_folder)
{
	return get_url_schema()."://".$_SERVER['HTTP_HOST'].$sub_folder;
}

function get_url_schema()
{
	return isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] ? 'https' : 'http';
}

function get_sub_folder()
{
    $ex = explode('/',$_SERVER['REQUEST_URI']);
    $folder = '';
    foreach ($ex as $f)
    {
        if ($f != 'install')
        {
            $folder .= $f.'/';
        }
        else
        {
            break;
        }
    }

    $folder = trim($folder,'/');

    if ($folder == '')
    {
        $folder = '/';
    }
    else
    {
        $folder = '/'.$folder.'/';
    }
    return $folder;
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
