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


function get_default_countries()
{
	return [
		['name' => "Afganistan", 'code' => "af"],
		['name' => "Albania", 'code' => "al"],
		['name' => "Algeria", 'code' => "dz"],
		['name' => "American Samoa", 'code' => "as"],
		['name' => "Andorra", 'code' => "ad"],
		['name' => "Angola", 'code' => "ao"],
		['name' => "Anguilla", 'code' => "ai"],
		['name' => "Antarctica", 'code' => "aq"],
		['name' => "Antigua and Barbuda", 'code' => "ag"],
		['name' => "Argentina", 'code' => "ar"],
		['name' => "Armenia", 'code' => "am"],
		['name' => "Aruba", 'code' => "aw"],
		['name' => "Australia", 'code' => "au"],
		['name' => "Austria", 'code' => "at"],
		['name' => "Åland Islands", 'code' => "ax"],
		['name' => "Azerbaijan", 'code' => "az"],
		['name' => "Bahamas", 'code' => "bs"],
		['name' => "Bahrain", 'code' => "bh"],
		['name' => "Bangladesh", 'code' => "bd"],
		['name' => "Barbados", 'code' => "bb"],
		['name' => "Belarus", 'code' => "by"],
		['name' => "Belgium", 'code' => "be"],
		['name' => "Belize", 'code' => "bz"],
		['name' => "Benin", 'code' => "bj"],
		['name' => "Bermuda", 'code' => "bm"],
		['name' => "Bhutan", 'code' => "bt"],
		['name' => "Bolivia", 'code' => "bo"],
		['name' => "Bosnia and Herzegowina", 'code' => "ba"],
		['name' => "Botswana", 'code' => "bw"],
		['name' => "Bouvet Island", 'code' => "bv"],
		['name' => "Brazil", 'code' => "br"],
		['name' => "British Indian Ocean Territory", 'code' => "io"],
		['name' => "Brunei Darussalam", 'code' => "bn"],
		['name' => "Bulgaria", 'code' => "bg"],
		['name' => "Burkina Faso", 'code' => "bf"],
		['name' => "Burundi", 'code' => "bi"],
		['name' => "Cambodia", 'code' => "kh"],
		['name' => "Cameroon", 'code' => "cm"],
		['name' => "Canada", 'code' => "ca"],
		['name' => "Cape Verde", 'code' => "cv"],
		['name' => "Cayman Islands", 'code' => "ky"],
		['name' => "Central African Republic", 'code' => "cf"],
		['name' => "Chad", 'code' => "td"],
		['name' => "Chile", 'code' => "cl"],
		['name' => "China", 'code' => "cn"],
		['name' => "Christmas Island", 'code' => "cx"],
		['name' => "Cocos (Keeling) Islands", 'code' => "cc"],
		['name' => "Colombia", 'code' => "co"],
		['name' => "Comoros", 'code' => "km"],
		['name' => "Congo", 'code' => "cg"],
		['name' => "Congo, the Democratic Republic of the", 'code' => "cd"],
		['name' => "Cook Islands", 'code' => "ck"],
		['name' => "Costa Rica", 'code' => "cr"],
		['name' => "Cote d'Ivoire", 'code' => "ci"],
		['name' => "Curaçao", 'code' => "cw"],
		['name' => "Croatia (Hrvatska)", 'code' => "hr"],
		['name' => "Cuba", 'code' => "cu"],
		['name' => "Cyprus", 'code' => "cy"],
		['name' => "Czech Republic", 'code' => "cz"],
		['name' => "Denmark", 'code' => "dk"],
		['name' => "Djibouti", 'code' => "dj"],
		['name' => "Dominica", 'code' => "dm"],
		['name' => "Dominican Republic", 'code' => "do"],
		['name' => "East Timor", 'code' => "tp"],
		['name' => "Ecuador", 'code' => "ec"],
		['name' => "Egypt", 'code' => "eg"],
		['name' => "El Salvador", 'code' => "sv"],
		['name' => "Equatorial Guinea", 'code' => "gq"],
		['name' => "Eritrea", 'code' => "er"],
		['name' => "Estonia", 'code' => "ee"],
		['name' => "Ethiopia", 'code' => "et"],
		['name' => "Falkland Islands (Malvinas)", 'code' => "fk"],
		['name' => "Faroe Islands", 'code' => "fo"],
		['name' => "Fiji", 'code' => "fj"],
		['name' => "Finland", 'code' => "fi"],
		['name' => "France", 'code' => "fr"],
		['name' => "France, Metropolitan", 'code' => "fx"],
		['name' => "French Guiana", 'code' => "gf"],
		['name' => "French Polynesia", 'code' => "pf"],
		['name' => "French Southern Territories", 'code' => "tf"],
		['name' => "Gabon", 'code' => "ga"],
		['name' => "Gambia", 'code' => "gm"],
		['name' => "Georgia", 'code' => "ge"],
		['name' => "Germany", 'code' => "de"],
		['name' => "Ghana", 'code' => "gh"],
		['name' => "Gibraltar", 'code' => "gi"],
		['name' => "Greece", 'code' => "gr"],
		['name' => "Greenland", 'code' => "gl"],
		['name' => "Grenada", 'code' => "gd"],
		['name' => "Guadeloupe", 'code' => "gp"],
		['name' => "Guam", 'code' => "gu"],
		['name' => "Guatemala", 'code' => "gt"],
		['name' => "Guinea", 'code' => "gn"],
		['name' => "Guinea-Bissau", 'code' => "gw"],
		['name' => "Guyana", 'code' => "gy"],
		['name' => "Haiti", 'code' => "ht"],
		['name' => "Heard and Mc Donald Islands", 'code' => "hm"],
		['name' => "Holy See (Vatican City State)", 'code' => "va"],
		['name' => "Honduras", 'code' => "hn"],
		['name' => "Hong Kong", 'code' => "hk"],
		['name' => "Hungary", 'code' => "hu"],
		['name' => "Iceland", 'code' => "is"],
		['name' => "Isle of Man", 'code' => "im"],
		['name' => "India", 'code' => "in"],
		['name' => "Indonesia", 'code' => "id"],
		['name' => "Iran (Islamic Republic of)", 'code' => "ir"],
		['name' => "Iraq", 'code' => "iq"],
		['name' => "Ireland", 'code' => "ie"],
		['name' => "Israel", 'code' => "il"],
		['name' => "Italy", 'code' => "it"],
		['name' => "Jamaica", 'code' => "jm"],
		['name' => "Japan", 'code' => "jp"],
		['name' => "Jordan", 'code' => "jo"],
		['name' => "Kazakhstan", 'code' => "kz"],
		['name' => "Kenya", 'code' => "ke"],
		['name' => "Kiribati", 'code' => "ki"],
		['name' => "Korea, Democratic People's Republic of", 'code' => "kp"],
		['name' => "Korea, Republic of", 'code' => "kr"],
		['name' => "Kuwait", 'code' => "kw"],
		['name' => "Kyrgyzstan", 'code' => "kg"],
		['name' => "Lao People's Democratic Republic", 'code' => "la"],
		['name' => "Latvia", 'code' => "lv"],
		['name' => "Lebanon", 'code' => "lb"],
		['name' => "Lesotho", 'code' => "ls"],
		['name' => "Liberia", 'code' => "lr"],
		['name' => "Libyan Arab Jamahiriya", 'code' => "ly"],
		['name' => "Liechtenstein", 'code' => "li"],
		['name' => "Lithuania", 'code' => "lt"],
		['name' => "Luxembourg", 'code' => "lu"],
		['name' => "Macau", 'code' => "mo"],
		['name' => "Macedonia, The Former Yugoslav Republic of", 'code' => "mk"],
		['name' => "Madagascar", 'code' => "mg"],
		['name' => "Malawi", 'code' => "mw"],
		['name' => "Malaysia", 'code' => "my"],
		['name' => "Maldives", 'code' => "mv"],
		['name' => "Mali", 'code' => "ml"],
		['name' => "Malta", 'code' => "mt"],
		['name' => "Marshall Islands", 'code' => "mh"],
		['name' => "Martinique", 'code' => "mq"],
		['name' => "Mauritania", 'code' => "mr"],
		['name' => "Mauritius", 'code' => "mu"],
		['name' => "Mayotte", 'code' => "yt"],
		['name' => "Mexico", 'code' => "mx"],
		['name' => "Micronesia, Federated States of", 'code' => "fm"],
		['name' => "Moldova, Republic of", 'code' => "md"],
		['name' => "Monaco", 'code' => "mc"],
		['name' => "Montenegro", 'code' => "me"],
		['name' => "Mongolia", 'code' => "mn"],
		['name' => "Montserrat", 'code' => "ms"],
		['name' => "Morocco", 'code' => "ma"],
		['name' => "Mozambique", 'code' => "mz"],
		['name' => "Myanmar", 'code' => "mm"],
		['name' => "Namibia", 'code' => "na"],
		['name' => "Nauru", 'code' => "nr"],
		['name' => "Nepal", 'code' => "np"],
		['name' => "Netherlands", 'code' => "nl"],
		['name' => "Netherlands Antilles", 'code' => "an"],
		['name' => "New Caledonia", 'code' => "nc"],
		['name' => "New Zealand", 'code' => "nz"],
		['name' => "Nicaragua", 'code' => "ni"],
		['name' => "Niger", 'code' => "ne"],
		['name' => "Nigeria", 'code' => "ng"],
		['name' => "Niue", 'code' => "nu"],
		['name' => "Norfolk Island", 'code' => "nf"],
		['name' => "Northern Mariana Islands", 'code' => "mp"],
		['name' => "Norway", 'code' => "no"],
		['name' => "Oman", 'code' => "om"],
		['name' => "Pakistan", 'code' => "pk"],
		['name' => "Palau", 'code' => "pw"],
		['name' => "Panama", 'code' => "pa"],
		['name' => "Papua New Guinea", 'code' => "pg"],
		['name' => "Paraguay", 'code' => "py"],
		['name' => "Peru", 'code' => "pe"],
		['name' => "Philippines", 'code' => "ph"],
		['name' => "Pitcairn", 'code' => "pn"],
		['name' => "Poland", 'code' => "pl"],
		['name' => "Portugal", 'code' => "pt"],
		['name' => "Puerto Rico", 'code' => "pr"],
		['name' => "Palestine", 'code' => "ps"],
		['name' => "Qatar", 'code' => "qa"],
		['name' => "Reunion", 'code' => "re"],
		['name' => "Romania", 'code' => "ro"],
		['name' => "Republic of Serbia", 'code' => "rs"],
		['name' => "Russian Federation", 'code' => "ru"],
		['name' => "Rwanda", 'code' => "rw"],
		['name' => "Saint Kitts and Nevis", 'code' => "kn"],
		['name' => "Saint LUCIA", 'code' => "lc"],
		['name' => "Saint Vincent and the Grenadines", 'code' => "vc"],
		['name' => "Samoa", 'code' => "ws"],
		['name' => "San Marino", 'code' => "sm"],
		['name' => "Sao Tome and Principe", 'code' => "st"],
		['name' => "Saudi Arabia", 'code' => "sa"],
		['name' => "Senegal", 'code' => "sn"],
		['name' => "Seychelles", 'code' => "sc"],
		['name' => "Sierra Leone", 'code' => "sl"],
		['name' => "Singapore", 'code' => "sg"],
		['name' => "Slovakia (Slovak Republic)", 'code' => "sk"],
		['name' => "Slovenia", 'code' => "si"],
		['name' => "Solomon Islands", 'code' => "sb"],
		['name' => "Somalia", 'code' => "so"],
		['name' => "Sint Maarten", 'code' => "sx"],
		['name' => "South Africa", 'code' => "za"],
		['name' => "South Georgia and the South Sandwich Islands", 'code' => "gs"],
		['name' => "Spain", 'code' => "es"],
		['name' => "Sri Lanka", 'code' => "lk"],
		['name' => "St. Helena", 'code' => "sh"],
		['name' => "St. Pierre and Miquelon", 'code' => "pm"],
		['name' => "Sudan", 'code' => "sd"],
		['name' => "Suriname", 'code' => "sr"],
		['name' => "Svalbard and Jan Mayen Islands", 'code' => "sj"],
		['name' => "Swaziland", 'code' => "sz"],
		['name' => "Sweden", 'code' => "se"],
		['name' => "Switzerland", 'code' => "ch"],
		['name' => "Syrian Arab Republic", 'code' => "sy"],
		['name' => "Taiwan, Province of China", 'code' => "tw"],
		['name' => "Tajikistan", 'code' => "tj"],
		['name' => "Tanzania, United Republic of", 'code' => "tz"],
		['name' => "Thailand", 'code' => "th"],
		['name' => "Togo", 'code' => "tg"],
		['name' => "Tokelau", 'code' => "tk"],
		['name' => "Tonga", 'code' => "to"],
		['name' => "Trinidad and Tobago", 'code' => "tt"],
		['name' => "Tunisia", 'code' => "tn"],
		['name' => "Turkey", 'code' => "tr"],
		['name' => "Turkmenistan", 'code' => "tm"],
		['name' => "Turks and Caicos Islands", 'code' => "tc"],
		['name' => "Tuvalu", 'code' => "tv"],
		['name' => "Uganda", 'code' => "ug"],
		['name' => "Ukraine", 'code' => "ua"],
		['name' => "United Arab Emirates", 'code' => "ae"],
		['name' => "United Kingdom", 'code' => "gb"],
		['name' => "United States", 'code' => "us"],
		['name' => "United States Minor Outlying Islands", 'code' => "um"],
		['name' => "Uruguay", 'code' => "uy"],
		['name' => "Uzbekistan", 'code' => "uz"],
		['name' => "Vanuatu", 'code' => "vu"],
		['name' => "Venezuela", 'code' => "ve"],
		['name' => "Vietnam", 'code' => "vn"],
		['name' => "Virgin Islands (British)", 'code' => "vg"],
		['name' => "Virgin Islands (U.S.)", 'code' => "vi"],
		['name' => "Wallis and Futuna Islands", 'code' => "wf"],
		['name' => "Western Sahara", 'code' => "eh"],
		['name' => "Yemen", 'code' => "ye"],
		['name' => "Yugoslavia", 'code' => "yu"],
		['name' => "Zambia", 'code' => "zm"],
		['name' => "Zimbabwe", 'code' => "zw"],
		['name' => "Jersey", 'code' => "je"],
	];
}
