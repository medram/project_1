<?php

$CI =& get_instance();

function recaptcha ()
{
	global $CI;

    if (get_config_item('recaptcha_status') == 1)
    {
        $secret = get_config_item('secret_key');
        $response = $CI->input->post('g-recaptcha-response',TRUE);
        $remoteip = $CI->input->ip_address();

        $r = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");

        $result = @json_decode($r);

        if (@$result->success == 1){return TRUE;}
        else{return FALSE;}
    }
    else
    {
        return TRUE;
    }

}

function is_url ($url)
{
    $pattren = "/^(https|http)?:\/\/([a-z0-9-.]+)\.([a-z0-9]+)(.*)$/i";

    return (boolean) preg_match($pattren,$url);
}

function get_domains($index = 0)
{
    $domains = explode("\r\n", get_config_item('packages_domains'));
    $default_url = base_url();

    /*
    echo '<pre>';
    print_r($domains);
    echo '</pre>';
    */

    if ($domains[0] == '')
    {
        return $default_url;
    }
    else if (isset($domains[$index]))
    {
        return preg_replace("/^(https|http)?:\/\/([a-zA-Z0-9-.]+)\/(.*)\//", "http://".$domains[$index]."/$3/", $default_url);
    }
    else
        return 'http://'.$domains[0].'/';
}

function encode($url, $url_safe = false) {
    return $url;
/*    global $CI;
    $CI->load->library('encryption');
    $ret = $CI->encryption->encrypt($url);

    if ($url_safe) {
        $ret = strtr($ret, array('+' => '.', '=' => '-', '/' => '~'));
    }

    return $ret;*/
}

function decode($url, $url_safe = false) {
    return $url;

/*    global $CI;
    $CI->load->library('encryption');
    
    if ($url_safe) {
        $url = strtr($url, array('.' => '+', '-' => '=', '~' => '/'));
    }
    return $CI->encryption->decrypt($url);*/
}

function is_forbiden_url($url)
{
    $url = preg_replace("/(https|http)?(:\/\/)(www.)?/i", '', $url);
    $bad_urls = explode("\r\n", get_config_item('bad_urls'));
    
//   echo $url.'<br>';
/*    echo '<pre>';
    print_r($bad_urls).'<br>';
    echo '</pre>';*/

    if (count($bad_urls) == 0 or $bad_urls[0] == '')
        return false;

    foreach ($bad_urls as $k => $u)
    {
        if (preg_match("/^(".$u.")/i", $url))
        {
            return true;
        }
    }
    return false;
}

function get_config_item($option_name)
{
    global $CI;
    static $config = array();

    if (isset($config[$option_name]))
    {
        return $config[$option_name];
    }

    $where = array('option_name' => $option_name);

    $s = $CI->cms_model->select('settings',$where);
    
    if ($s->num_rows() == 1)
    {
        $row = $s->result_array();
        $config[$option_name] = $row[0]['option_value'];
        return $row[0]['option_value'];
    }
    else
    {
        return '';
    }
}

function get_ad ($type='',$in_account=FALSE)
{
    $type = ($type == '')? 'ad_autosize' : $type ;

    if (config_item('ads_status') == 1)
    {
        if ((bool)$in_account)
        {
            if (config_item('ads_status_on_accounts') == 1)
            {
                return get_config_item($type);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return get_config_item($type);
        }
    }
    else
    {
        return '';
    }
}

function sendEmail($to, $subject, $msg, $from=array(), $priority=3, $mailtype='html')
{
    global $CI;
    $color = color();

    if ($mailtype == 'html'){
        $header = "
        <div dir ='rtl' style='
            font-family: tahoma,arial;
            font-size: 13px;
            background: #f9f9f9;
        '>

        <div style='
            background: ".$color.";
            color: #fff;
            font-size: 50px;
            height: 70px;
            border-bottom: 1px solid #eee;
            padding: 10px 5px;
            margin-bottom: 20px;

        '>
            ".get_logo()."
        </div>
        <!-- open div content -->
        <div style='padding: 5px 10px;'>
        ";

        $footer = "
            <br>--------------------------------------------------<br>
            للإستفسار يمكنكم التواصل معنا عبر الموقع ".base_url()."
        </div><!-- close div content -->
        <div style='
            color: #fff;
            border-top: 1px solid #eee;
            padding: 10px 5px;
            margin-top: 20px;
            background: ".$color.";
        '>
            <copy>&copy; ".config_item('sitename')."</copy>
        </div>
        </div>
        ";
    }
    else
    {
        $header = '';
        $footer = "\n--------------------------------------------------\nللإستفسار يمكنكم التواصل معنا عبر الموقع ".base_url();
    }

    $message = $header;
    $message .= $msg;
    $message .= $footer;

    if (get_config_item('email_method') == 'smtp')
    {
        $c['protocol']      = 'smtp';
        $c['smtp_host']     = get_config_item('SMTP_Host');
        $c['smtp_port']     = get_config_item('SMTP_Port');
        $c['smtp_user']     = get_config_item('SMTP_User');
        $c['smtp_pass']     = get_config_item('SMTP_Pass');
        $c['smtp_crypto']   = get_config_item('mail_encription'); // tls or ssl
    }

    $c['mailtype'] = $mailtype;
    $c['priority'] = $priority; // from 1 to 5 , 3 is normal
    $c['smtp_timeout']  = 10;
    //$c['newline'] = '\r\n';

    $CI->load->library('email',$c);
    //$CI->email->set_newline("\r\n");

    if(count($from) == 0)
    {
        $CI->email->from(get_config_item('email_from'), config_item('sitename'));
    }
    else
    {
        $CI->email->from($from[0],$from[1]);
    }

    $CI->email->to($to);
    $CI->email->subject($subject);
    $CI->email->message($message);

    return @$CI->email->send();
}


function pagination($all_items,$num_per_page,$url,$lg='en')
{
    global $CI;
    $CI->load->library('pagination');

    $lang = array();
    $lang['en']['next'] = '<span dir="rtl"><i class="fa fa-angle-right"></i> next</span>';
    $lang['ar']['next'] = '<span dir="ltr"><i class="fa fa-angle-left"></i> التالي<span>';
    $lang['en']['prev'] = '<span dir="ltr"><i class="fa fa-angle-left"></i> prev</span>';
    $lang['ar']['prev'] = '<span dir="rtl"><i class="fa fa-angle-right"></i> السابق</span>';
    $lang['en']['first'] = '<span dir="ltr">first</span>';
    $lang['ar']['first'] = '<span dir="ltr">الصفحة الأولى</span>';
    $lang['en']['last'] = '<span dir="ltr">last</span>';
    $lang['ar']['last'] = '<span dir="ltr">الصفحة الأخيرة</span>';
    //$lang[][] = ;

    //$config['uri_segment'] = 3;
    $config['base_url'] = $url;
    $config['total_rows'] = $all_items;
    $config['per_page'] = $num_per_page;
    $config['use_page_numbers'] = TRUE;
    $config['reuse_query_string'] = TRUE;
    $config['num_links'] = 2;
    //$config['page_query_string'] = TRUE;

    $config['full_tag_open'] = "<nav><ul class='pagination'>";
    $config['full_tag_close'] = "</ul></nav>";

    $config['num_tag_open'] = "<li>";
    $config['num_tag_close'] = "</li>";
    
    $config['cur_tag_open'] = "<li class='active'><a href='#'>";
    $config['cur_tag_close'] = "</a></li>";

    $config['next_link'] = $lang[$lg]['next'];
    $config['next_tag_open'] = "<li>";
    $config['next_tag_close'] = "</li>";

    $config['prev_link'] = $lang[$lg]['prev'];
    $config['prev_tag_open'] = "<li>";
    $config['prev_tag_close'] = "</li>";

    $config['last_link'] = $lang[$lg]['last'];
    $config['last_tag_open'] = "<li>";
    $config['last_tag_close'] = "</li>";

    $config['first_link'] = $lang[$lg]['first'];
    $config['first_tag_open'] = "<li>";
    $config['first_tag_close'] = "</li>";

    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}

function get_logo ($height=NULL)
{
    if (config_item('show_logo') == 1)
    {
        $height = ($height != NULL && is_int($height))? "style='height: ".$height."px;'": '' ;
        $s = "<img src='".base_url()."img/logo.png?v=".rand(1, 9999999)."' alt='".config_item('sitename')."' title='".config_item('sitename')."' ".$height." >";
    }
    else
    {
        $s = config_item('sitename');
    }
    return $s;
}

function get_icon ()
{
    return  "
            <link rel='apple-touch-icon' sizes='72x72' href='".base_url()."img/favicon.png?m=".uniqid()."'>
            <link rel='icon' type='image/png' sizes='32x32' href='".base_url()."img/favicon.png?m=".uniqid()."'>
        ";
}

function get_profile_img ($user_token)
{
    $path = "uploads/users/profile-images/".md5($user_token).".png";

    if (file_exists($path))
    {
        $src = base_url().$path.'?v='.rand(1, 99999);
    }
    else
    {
        $src = base_url()."/uploads/users/profile-images/default-boy.png";
    }

    return $src;
}

function delete_profile_img ($user_token)
{
    $path = "uploads/users/profile-images/".md5($user_token).".png";

    if (file_exists($path))
    {
        $u = (@unlink($path))? TRUE : FALSE ;
        return $u;
    }
    else
    {
        return false;
    }
}

function color()
{
    $color = array(
            "#E9573F","#F6BB42","#8CC152","#37BC9B","#48CFAD","#A0D468","#3BAFDA","#4FC1E9",
            "#4A89DC","#5D9CEC","#434A54","#656D78","#D770AD","#EC87C0","#967ADC","#AC92EC",
            "#DA4453","#ED5565","#FFCE54"
            );
    shuffle($color);
    return $color[0];
}

function get_country_menu ($name='',$class='',$select=0,$l='')
{
    $a = array('en','ar');
    if ($l != '' && in_array($l,$a))
    {
        $lang = $l;
    }
    else
    {
        $lang = 'ar'; // you can choose menu language from here : use 'en' or 'ar'        
    }
    $country = array();
    $country['ar'] = array(
        "اختر بلدك",
        "أفغانستان",
        "ألبانيا",
        "الجزائر",
        "أندورا",
        "أنغولا",
        "أنتيغوا وبربودا",
        "الأرجنتين",
        "أرمينيا",
        "أستراليا",
        "النمسا",
        "أذربيجان",
        "الباهاما",
        "البحرين",
        "بنغلاديش",
        "بربادوس",
        "روسيا البيضاء",
        "بلجيكا",
        "بليز",
        "بنين",
        "بوتان",
        "بوليفيا",
        "البوسنة والهرسك",
        "بوتسوانا",
        "البرازيل",
        "بروناي",
        "بلغاريا",
        "بوركينا فاسو",
        "بوروندي",
        "كمبوديا",
        "الكاميرون",
        "كندا",
        "الرأس الأخضر",
        "جمهورية افريقيا الوسطى",
        "تشاد",
        "شيلي",
        "الصين",
        "كولومبيا",
        "جزر القمر",
        "الكونغو (برازافيل)",
        "الكونغو",
        "كوستا ريكا",
        "كوت ديفوار",
        "كرواتيا",
        "كوبا",
        "قبرص",
        "جمهورية التشيك",
        "الدنمارك",
        "جيبوتي",
        "دومينيكا",
        "جمهورية الدومنيكان",
        "تيمور الشرقية (تيمور تيمورلنك)",
        "الاكوادور",
        "مصر",
        "السلفادور",
        "غينيا الإستوائية",
        "إريتريا",
        "استونيا",
        "أثيوبيا",
        "فيجي",
        "فنلندا",
        "فرنسا",
        "الغابون",
        "غامبيا",
        "جورجيا",
        "ألمانيا",
        "غانا",
        "اليونان",
        "غرينادا",
        "غواتيمالا",
        "غينيا",
        "غينيا بيساو",
        "غيانا",
        "هايتي",
        "هندوراس",
        "هنغاريا",
        "أيسلندا",
        "الهند",
        "أندونيسيا",
        "إيران",
        "العراق",
        "ايرلندا",
        "إيطاليا",
        "جامايكا",
        "اليابان",
        "الأردن",
        "كازاخستان",
        "كينيا",
        "كيريباس",
        "كوريا الشمالية",
        "كوريا، جنوب",
        "الكويت",
        "قيرغيزستان",
        "لاوس",
        "لاتفيا",
        "لبنان",
        "ليسوتو",
        "ليبيريا",
        "ليبيا",
        "ليختنشتاين",
        "ليتوانيا",
        "لوكسمبورغ",
        "مقدونيا",
        "مدغشقر",
        "ملاوي",
        "ماليزيا",
        "جزر المالديف",
        "مالي",
        "مالطا",
        "جزر مارشال",
        "موريتانيا",
        "موريشيوس",
        "المكسيك",
        "ميكرونيزيا",
        "مولدافيا",
        "موناكو",
        "منغوليا",
        "المغرب",
        "موزمبيق",
        "ميانمار",
        "ناميبيا",
        "ناورو",
        "نيبال",
        "هولندا",
        "نيوزيلاندا",
        "نيكاراغوا",
        "النيجر",
        "نيجيريا",
        "النرويج",
        "سلطنة عمان",
        "باكستان",
        "بالاو",
        "بنما",
        "بابوا غينيا الجديدة",
        "باراغواي",
        "بيرو",
        "الفلبين",
        "بولندا",
        "البرتغال",
        "قطر",
        "رومانيا",
        "روسيا",
        "رواندا",
        "سانت كيتس ونيفيس",
        "سانت لوسيا",
        "سانت فنسنت",
        "ساموا",
        "سان مارينو",
        "ساو تومي وبرينسيبي",
        "المملكة العربية السعودية",
        "السنغال",
        "صربيا والجبل الأسود",
        "سيشيل",
        "سيرا ليون",
        "سنغافورة",
        "سلوفاكيا",
        "سلوفينيا",
        "جزر سليمان",
        "الصومال",
        "جنوب أفريقيا",
        "إسبانيا",
        "سيريلانكا",
        "السودان",
        "سورينام",
        "سوازيلاند",
        "السويد",
        "سويسرا",
        "سوريا",
        "تايوان",
        "طاجيكستان",
        "تنزانيا",
        "تايلاند",
        "توغو",
        "تونغا",
        "ترينداد وتوباغو",
        "تونس",
        "ديك رومي",
        "تركمانستان",
        "توفالو",
        "أوغندا",
        "أوكرانيا",
        "الإمارات العربية المتحدة",
        "المملكة المتحدة",
        "الولايات المتحدة",
        "أوروغواي",
        "أوزبكستان",
        "فانواتو",
        "مدينة الفاتيكان",
        "فنزويلا",
        "فيتنام",
        "اليمن",
        "زامبيا",
        "زيمبابوي"
    );
    $country['en'] = array(
        "Choose your country",
        "Afghanistan",
        "Albania",
        "Algeria",
        "Andorra",
        "Angola",
        "Antigua and Barbuda",
        "Argentina",
        "Armenia",
        "Australia",
        "Austria",
        "Azerbaijan",
        "Bahamas",
        "Bahrain",
        "Bangladesh",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Bhutan",
        "Bolivia",
        "Bosnia and Herzegovina",
        "Botswana",
        "Brazil",
        "Brunei",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Cape Verde",
        "Central African Republic",
        "Chad",
        "Chile",
        "China",
        "colombia",
        "Comoros",
        "Congo (Brazzaville)",
        "Congo",
        "Costa Rica",
        "Cote d'Ivoire",
        "Croatia",
        "Cuba",
        "Cyprus",
        "Czech Republic",
        "Denmark",
        "Djibouti",
        "Dominica",
        "Dominican Republic",
        "East Timor (Timor Timur)",
        "Ecuador",
        "Egypt",
        "El Salvador",
        "Equatorial Guinea",
        "Eritrea",
        "Estonia",
        "Ethiopia",
        "Fiji",
        "Finland",
        "France",
        "Gabon",
        "Gambia, The",
        "Georgia",
        "Germany",
        "Ghana",
        "Greece",
        "Grenada",
        "Guatemala",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Haiti",
        "Honduras",
        "Hungary",
        "Iceland",
        "India",
        "Indonesia",
        "Iran",
        "Iraq",
        "Ireland",
        "Italy",
        "Jamaica",
        "Japan",
        "Jordan",
        "Kazakhstan",
        "Kenya",
        "Kiribati",
        "Korea, North",
        "Korea, South",
        "Kuwait",
        "Kyrgyzstan",
        "Laos",
        "Latvia",
        "Lebanon",
        "Lesotho",
        "Liberia",
        "Libya",
        "Liechtenstein",
        "Lithuania",
        "Luxembourg",
        "Macedonia",
        "Madagascar",
        "Malawi",
        "Malaysia",
        "Maldives",
        "Mali",
        "Malta",
        "Marshall Islands",
        "Mauritania",
        "Mauritius",
        "Mexico",
        "Micronesia",
        "Moldova",
        "Monaco",
        "Mongolia",
        "Morocco",
        "Mozambique",
        "Myanmar",
        "Namibia",
        "Nauru",
        "Nepal",
        "Netherlands",
        "New Zealand",
        "Nicaragua",
        "Niger",
        "Nigeria",
        "Norway",
        "Oman",
        "Pakistan",
        "Palau",
        "Panama",
        "Papua New Guinea",
        "Paraguay",
        "Peru",
        "Philippines",
        "Poland",
        "Portugal",
        "Qatar",
        "Romania",
        "Russia",
        "Rwanda",
        "Saint Kitts and Nevis",
        "Saint Lucia",
        "Saint Vincent",
        "Samoa",
        "San Marino",
        "Sao Tome and Principe",
        "Saudi Arabia",
        "Senegal",
        "Serbia and Montenegro",
        "Seychelles",
        "Sierra Leone",
        "Singapore",
        "Slovakia",
        "Slovenia",
        "Solomon Islands",
        "Somalia",
        "South Africa",
        "Spain",
        "Sri Lanka",
        "Sudan",
        "Suriname",
        "Swaziland",
        "Sweden",
        "Switzerland",
        "Syria",
        "Taiwan",
        "Tajikistan",
        "Tanzania",
        "Thailand",
        "Togo",
        "Tonga",
        "Trinidad and Tobago",
        "Tunisia",
        "Turkey",
        "Turkmenistan",
        "Tuvalu",
        "Uganda",
        "Ukraine",
        "United Arab Emirates",
        "United Kingdom",
        "United States",
        "Uruguay",
        "Uzbekistan",
        "Vanuatu",
        "Vatican City",
        "Venezuela",
        "Vietnam",
        "Yemen",
        "Zambia",
        "Zimbabwe"
    );

    $select = ($select == '')? 0 : $select ;
    $dir = ($lang == 'en')? 'ltr' : 'rtl' ;
    $s = "<div dir='".$dir."'><select ";
    
    if ($name != '')
    {
        $s .= "name='".$name."' ";
    }
    
    if ($class != '')
    {
        $s .= "class='".$class."' >";
    }
    
    foreach ($country[$lang] as $k => $v)
    {
        if ($select == $k)
        {
            $s .= "<option value='".$k."' selected >".$v."</option>";
        }
        else
        {
            $s .= "<option value='".$k."' >".$v."</option>";
        }
    }
    $s .= "</select></div>";
    return $s;
}

function get_timezone_menu ($name='',$class='',$select='')
{
    $timezones = array (
    '(GMT-11:00) Midway Island' => 'Pacific/Midway',
    '(GMT-11:00) Samoa' => 'Pacific/Samoa',
    '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
    '(GMT-09:00) Alaska' => 'US/Alaska',
    '(GMT-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
    '(GMT-08:00) Tijuana' => 'America/Tijuana',
    '(GMT-07:00) Arizona' => 'US/Arizona',
    '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
    '(GMT-07:00) La Paz' => 'America/Chihuahua',
    '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
    '(GMT-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
    '(GMT-06:00) Central America' => 'America/Managua',
    '(GMT-06:00) Central Time (US &amp; Canada)' => 'US/Central',
    '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
    '(GMT-06:00) Mexico City' => 'America/Mexico_City',
    '(GMT-06:00) Monterrey' => 'America/Monterrey',
    '(GMT-06:00) Saskatchewan' => 'Canada/Saskatchewan',
    '(GMT-05:00) Bogota' => 'America/Bogota',
    '(GMT-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
    '(GMT-05:00) Indiana (East)' => 'US/East-Indiana',
    '(GMT-05:00) Lima' => 'America/Lima',
    '(GMT-05:00) Quito' => 'America/Bogota',
    '(GMT-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
    '(GMT-04:30) Caracas' => 'America/Caracas',
    '(GMT-04:00) La Paz' => 'America/La_Paz',
    '(GMT-04:00) Santiago' => 'America/Santiago',
    '(GMT-03:30) Newfoundland' => 'Canada/Newfoundland',
    '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
    '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
    '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
    '(GMT-03:00) Greenland' => 'America/Godthab',
    '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
    '(GMT-01:00) Azores' => 'Atlantic/Azores',
    '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
    '(GMT+00:00) Casablanca' => 'Africa/Casablanca',
    '(GMT+00:00) Edinburgh' => 'Europe/London',
    '(GMT+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
    '(GMT+00:00) Lisbon' => 'Europe/Lisbon',
    '(GMT+00:00) London' => 'Europe/London',
    '(GMT+00:00) Monrovia' => 'Africa/Monrovia',
    '(GMT+00:00) UTC' => 'UTC',
    '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
    '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
    '(GMT+01:00) Berlin' => 'Europe/Berlin',
    '(GMT+01:00) Bern' => 'Europe/Berlin',
    '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
    '(GMT+01:00) Brussels' => 'Europe/Brussels',
    '(GMT+01:00) Budapest' => 'Europe/Budapest',
    '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
    '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
    '(GMT+01:00) Madrid' => 'Europe/Madrid',
    '(GMT+01:00) Paris' => 'Europe/Paris',
    '(GMT+01:00) Prague' => 'Europe/Prague',
    '(GMT+01:00) Rome' => 'Europe/Rome',
    '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
    '(GMT+01:00) Skopje' => 'Europe/Skopje',
    '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
    '(GMT+01:00) Vienna' => 'Europe/Vienna',
    '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
    '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
    '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
    '(GMT+02:00) Athens' => 'Europe/Athens',
    '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
    '(GMT+02:00) Cairo' => 'Africa/Cairo',
    '(GMT+02:00) Harare' => 'Africa/Harare',
    '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
    '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
    '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
    '(GMT+02:00) Kyiv' => 'Europe/Helsinki',
    '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
    '(GMT+02:00) Riga' => 'Europe/Riga',
    '(GMT+02:00) Sofia' => 'Europe/Sofia',
    '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
    '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
    '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
    '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
    '(GMT+03:00) Minsk' => 'Europe/Minsk',
    '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
    '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
    '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
    '(GMT+03:30) Tehran' => 'Asia/Tehran',
    '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
    '(GMT+04:00) Baku' => 'Asia/Baku',
    '(GMT+04:00) Moscow' => 'Europe/Moscow',
    '(GMT+04:00) Muscat' => 'Asia/Muscat',
    '(GMT+04:00) St. Petersburg' => 'Europe/Moscow',
    '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
    '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
    '(GMT+04:30) Kabul' => 'Asia/Kabul',
    '(GMT+05:00) Islamabad' => 'Asia/Karachi',
    '(GMT+05:00) Karachi' => 'Asia/Karachi',
    '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
    '(GMT+05:30) Chennai' => 'Asia/Calcutta',
    '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
    '(GMT+05:30) Mumbai' => 'Asia/Calcutta',
    '(GMT+05:30) New Delhi' => 'Asia/Calcutta',
    '(GMT+05:30) Sri Jayawardenepura' => 'Asia/Calcutta',
    '(GMT+05:45) Kathmandu' => 'Asia/Katmandu',
    '(GMT+06:00) Almaty' => 'Asia/Almaty',
    '(GMT+06:00) Astana' => 'Asia/Dhaka',
    '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
    '(GMT+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
    '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
    '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
    '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
    '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
    '(GMT+07:00) Novosibirsk' => 'Asia/Novosibirsk',
    '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
    '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
    '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
    '(GMT+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
    '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
    '(GMT+08:00) Perth' => 'Australia/Perth',
    '(GMT+08:00) Singapore' => 'Asia/Singapore',
    '(GMT+08:00) Taipei' => 'Asia/Taipei',
    '(GMT+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
    '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
    '(GMT+09:00) Irkutsk' => 'Asia/Irkutsk',
    '(GMT+09:00) Osaka' => 'Asia/Tokyo',
    '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
    '(GMT+09:00) Seoul' => 'Asia/Seoul',
    '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
    '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
    '(GMT+09:30) Darwin' => 'Australia/Darwin',
    '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
    '(GMT+10:00) Canberra' => 'Australia/Canberra',
    '(GMT+10:00) Guam' => 'Pacific/Guam',
    '(GMT+10:00) Hobart' => 'Australia/Hobart',
    '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
    '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
    '(GMT+10:00) Sydney' => 'Australia/Sydney',
    '(GMT+10:00) Yakutsk' => 'Asia/Yakutsk',
    '(GMT+11:00) Vladivostok' => 'Asia/Vladivostok',
    '(GMT+12:00) Auckland' => 'Pacific/Auckland',
    '(GMT+12:00) Fiji' => 'Pacific/Fiji',
    '(GMT+12:00) International Date Line West' => 'Pacific/Kwajalein',
    '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
    '(GMT+12:00) Magadan' => 'Asia/Magadan',
    '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
    '(GMT+12:00) New Caledonia' => 'Asia/Magadan',
    '(GMT+12:00) Solomon Is.' => 'Asia/Magadan',
    '(GMT+12:00) Wellington' => 'Pacific/Auckland',
    '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
    );
        
    $select = ($select == '')? 'Africa/Casablanca' : $select ;
    $s = "<select ";
    
    if ($name != '')
    {
        $s .= "name='".$name."' ";
    }
    
    if ($class != '')
    {
        $s .= "class='".$class."' >";
    }
    
    foreach ($timezones as $k => $v)
    {
        if ($select == $v)
        {
            $s .= "<option value='".$v."' selected >".$k."</option>";
        }
        else
        {
            $s .= "<option value='".$v."' >".$k."</option>";
        }
    }
    $s .= "</select>";
    return $s;
}


/*============================= private function for type of the website ======================================*/

function get_slug ()
{
    global $CI;

    $number = rand(1,6); // number of chars
    $str = "azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN-_0123456789";
    $slug = substr(str_shuffle($str),rand(0,9),$number);

    $w['slug'] = $slug;
    $s = $CI->cms_model->select('links',$w);

    if ($s->num_rows() > 1)
    {
        $s->free_result();
        get_slug();
    }
    else
    {
        $s->free_result();
        return $slug;
    }

}

// type must be like 300x250
function get_google_ad ($pub='',$channel='',$type='')
{
    global $CI;
    
    if (config_item('ads_status') == 0)
        return;
    
    if (get_config_item('just_show_users_ads') == 0)
    {
        if (get_config_item('just_show_admin_ads') == 1)
        {    
            // show admin ads
            $pub = get_config_item('admin_pub');
            $channel = get_config_item('admin_channel');
        }
        else if ($pub == '' or $CI->input->get('t'))
        {
            // show admin ads
            $pub = get_config_item('admin_pub');
            $channel = get_config_item('admin_channel');
        }
    }

 
    //echo $pub;
    $code = '';
    if ($type != '')
    {
        $a = explode("x",$type);
        $code = '
            <div class="boxAds">
            <script type="text/javascript">
                google_ad_client = "ca-'.$pub.'";
                google_ad_slot = "";
                google_ad_width = '.$a[0].';
                google_ad_height = '.$a[1].';
                ';
        if (!empty($channel))
        {
            $code .= "google_ad_channel = ".$channel.";";
        }
        
        $code .= '
            </script>
            <!-- ad name here -->
            <script type="text/javascript"
            src="//pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
            </div>
        ';
    }
    else
    {
        $code = '
            <div class="boxAds">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- auto -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-'.$pub.'"
                 data-ad-slot=""
                 data-ad-format="auto"
        ';

        if (!empty($channel))
        {
            $code .= 'data-ad-channel="'.$channel.'"';
        }

        $code .= '
            ></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            </div>
        ';
    }


    /*
    <script type="text/javascript">
        google_ad_client = "ca-pub-4598659940102140";
        google_ad_slot = "3807919719";
        google_ad_width = 728;
        google_ad_height = 90;
    </script>
    <!-- fff -->
    <script type="text/javascript"
    src="//pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>




    <script type="text/javascript">
        google_ad_client = "ca-pub-4598659940102140";
        google_ad_slot = "8017793317";
        google_ad_width = 728;
        google_ad_height = 90;
    </script>
    <!-- جديد 4 مي 2 -->
    <script type="text/javascript"
    src="//pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>

    =============== auto size ==================
    */

    return $code;

}



?>

