<?php

use MR4Web\Utils\Config;

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
        echo '<pre>'.$string.'</pre>';
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

function redirectToLicensePage()
{
    $CI = &get_instance();
    $deniedPages = [Config::get('license_page'), 'login'];
    
    if (!in_array($CI->uri->segment(2), $deniedPages))
    {
        header("location: ".config_item('base_url').$CI->uri->segment(1).'/'.Config::get('license_page'));
        exit;
    }
}

function MyCURL($URL, array $fields = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch, CURLOPT_NOBODY, false);

    if (count($fields))
    {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    }

    $res = json_decode(curl_exec($ch), true);
    //$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($res == false)
        $res = curl_error($ch);
    curl_close($ch);

    return $res;
}

?>