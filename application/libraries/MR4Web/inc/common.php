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

function logger($string)
{
    if (DEBUG_SHOW_OPERATIONS)
        echo $string;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');

    return $ipaddress;
}

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


?>