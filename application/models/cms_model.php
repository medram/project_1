<?php

class cms_model extends MY_model
{
	// protected $CI =& get_instance();

    public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }

    public function onlineVisitors()
    {
        $this->load->library('user_agent');

        $ip = $this->input->ip_address();
        $agent = '';
        $platform = $this->agent->platform();
        $time = time();

        if ($this->agent->is_browser())
        {
                $agent = $this->agent->browser().' '.$this->agent->version();
        }
        elseif ($this->agent->is_robot())
        {
                $agent = $this->agent->robot();
        }
        elseif ($this->agent->is_mobile())
        {
                $agent = $this->agent->mobile();
        }
        else
        {
                $agent = 'Unidentified';
        }

        $w['ip'] = $ip;
        $s = $this->select('online',$w);

        if ($s->num_rows() > 0)
        {
            // update
            $set['agent']       = $agent;
            $set['platform']    = $platform;
            $set['time']        = $time;

            $w_up['ip']         = $ip;
            
            $up = $this->update('online',$set,$w_up);
        }
        else
        {
            // insert
            $d['ip']        = $ip;
            $d['agent']     = $agent;
            $d['platform']  = $platform;
            $d['time']      = $time;

            $in = $this->insert('online',$d);
        }

        // delete

        $munite = 5;
        $w_d['time <'] = time() - $munite*60;
        $del = $this->delete('online',$w_d);

    }

    public function getPages ($var)
    {
        $where['published'] = 1;
        if ($var == 'header')
        {
            $where['show_header'] = 1;
        }

        if ($var == 'footer')
        {
            $where['show_footer'] = 1;
        }
        return $this->select('pages',$where);
    }

    public function is_registered ($email,$a='')
    {
        //$this->db->where("email",$email);
        //$q = $this->db->get('users');
        $w['email'] = $email;

        if ($w != '' && is_array($a))
        {
            foreach ($a as $k => $v)
            {
                $w[$k] = $v;
            }
        }

        $q = $this->select('users',$w);
        if ($q->num_rows() == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

    }

    public function is_closed ()
    {
    	if (config_item('siteclose') == 1 
                && $this->uri->segment(1) != 'closed' 
                && $this->uri->segment(1) != config_item('admin_page_path') 
                && $this->uri->segment(1) != 'logout')
    	{
    		redirect(base_url().'closed');
    		return TRUE;
    	}
        else if (config_item('siteclose') == 0 && $this->uri->segment(1) == 'closed')
        {
            redirect(base_url());
            return false;
        }
    	else
    	{
    		return false;
    	}
    }

    public function login($type_login='users')
    {
        if ($this->input->post('submit'))
        {
            $email      = trim(strip_tags($this->input->post('email',TRUE)));
            $password   = trim(strip_tags($this->input->post('pass',TRUE)));
            $remember   = abs(intval($this->input->post('remember',TRUE)));

            if (!recaptcha())
            {
                $err = "كود الكابتشا خاطئ ، أعد المحاولة.";
            }
            else if ($email == '' or $password == '')
            {
                $err = "أدخل البريد الإلكتروني و كلمة المرور لتسجيل الدخول.";
            }
            else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $err = "عذرا، <b>البريد الإلكتروني</b> غير صالح.";
            }
            else if (mb_strlen($password) > 50 or mb_strlen($password) < 4)
            {
                $err = "عذرا، أخطأت بإدخال البريد الإلكتروني أو كلمة المرور.";
            }
            else if (!$this->is_login($email,$password))
            {
                $err = "عذرا، أخطأت بإدخال البريد الإلكتروني أو كلمة المرور.";
            }
            else
            {
                $w['email'] = $email;
                $w['user_verified'] = 1;

                $q = $this->select('users',$w);
                
                $r = $q->result_array();
                
                if ($r[0]['account_status'] == 1)
                {
                    $err = "عذرا، هذا الحساب معطل !";
                }
                else
                {
                    $this->last_login($r[0]['user_token'], $r[0]['id']);

                    $userdata = array();

                    // set user token automatically
                    $userdata['token'] = $r[0]['user_token'];

                    // is admin
                    if ($r[0]['user_status'] == 1 && $type_login == 'admin')
                    {
                        $userdata['admin_token'] = $r[0]['user_token'];
                    }

                    $this->session->set_userdata($userdata);

                    if ($remember == 1 && $type_login == 'users')
                    {
                        $this->load->library('encryption');
                        set_cookie(
                                config_item('cookie_name'),         // Cookie name
                                $this->encryption->encrypt($r[0]['user_token']),                // Cookie value
                                config_item('cookie_expire'),       // expire time
                                config_item('site_domain'),         // Cookie domain (usually: .yourdomain.com)
                                '/',                                // Cookie path
                                '',                                 // Cookie name prefix
                                config_item('use_cookie_on_https'), // securite (work only on  HTTPS)
                                config_item('hide_cookie_from_js')  // hide the cookie from JavaScript
                        );
                    }

                    if ($type_login == 'admin')
                    {
                        $goto = get_config_item('admin_page_path');
                    }
                    else
                    {
                        $goto = 'account';
                    }
                    
                    redirect(base_url($goto));  
                    //$data['session'] = $this->session->userdata();
                }
                $q->free_result();
            }

            if (isset($err))
            {
                return "<div class='alert alert-warning'>".$err."</div>";
            }
            /*
            else if (isset($ok))
            {
                return "<div class='alert alert-success'>".$ok."</div>";
            }
            */
        }

    } // end logn function

    public function if_login_redirect_to($to)
    {
        if ($this->session->userdata('token') != '')
        {
            redirect(base_url().$to);
            exit();
        }
    }

    public function last_login ($token, $userID)
    {
        $this->load->library('user_agent');

        $a = array();
        $a['ip']            = $this->input->ip_address();
        $a['browser']       = '';
        $a['platform']      = $this->agent->platform();
        $a['last_login']    = time();

        if ($this->agent->is_browser())
        {
                $agent = $this->agent->browser().' '.$this->agent->version();
        }
        elseif ($this->agent->is_robot())
        {
                $agent = $this->agent->robot();
        }
        elseif ($this->agent->is_mobile())
        {
                $agent = $this->agent->mobile();
        }
        else
        {
                $agent = 'undefined';
        }

        $a['browser'] = $agent;

        $w_del['user_id'] = $userID;
        $d['user_id'] = $userID;

        foreach ($a as $k => $v)
        {
            $w_del['user_option'] = $k;
            $del = $this->delete('usersmeta',$w_del);

            $d['user_option'] = $k;
            $d['user_value'] = $v;
            $in = $this->insert('usersmeta',$d);
        }

    }

    /*
    public function get_admin_data ($token)
    {
        $q = $this->select('users',array('user_status'=>1,'user_token'=>$token,'user_verified'=>1));
        if ($q->num_rows() == 1)
        {
            $a = $q->result_array();
            return $a[0];
        }
        else
        {
            return array();
        }
    }
    */

	public function register ($data = array())
	{
		if (is_array($data))
		{
			return $this->insert('users',$data);
		}
		else
		{
			return FALSE;
		}
	}

	public function is_login ($email,$pass)
	{
		$s = $this->select('users',array('email'=>$email,'user_verified'=>1));
		
		if ($s->num_rows() == 1)
		{
            $r = $s->result_array();
			 if (password_verify($pass,$r[0]['password']))
             {
                return true;
             }
             else
             {
                return FALSE;
             }
		}
		else
		{
			return false;
		}
	}

    public function test_login_using_cookie()
    {
        if (!isset($this->session->token) or $this->session->token == ""){

            $this->load->library('encryption');
            $cookie_token = get_cookie(config_item('cookie_name'));
            $cookie_token = $this->encryption->decrypt($cookie_token);
            
            if ($cookie_token != "")
            {
                $q = $this->select('users',array('user_token'=>$cookie_token,'user_verified'=>1));
                if ($q->num_rows() == 1)
                {
                    $r = $q->result_array();
                    
                    if ($r[0]['user_status'] == 1)
                    {
                        $d['admin_token'] = $r[0]['user_token'];
                    }
                    
                    $d['token'] = $r[0]['user_token'];    
                    
                    $this->session->set_userdata($d);
                }
            }
        }
    }

    public function forget_pass ($type='')
    {
        if ($this->input->post('submit'))
        {
            $email = trim(strip_tags($this->input->post('e-mail',TRUE)));

            if (!recaptcha())
            {
                $err = "كود الكابتشا خاطئ ، أعد المحاولة.";
            }
            else if ($email == '')
            {
                $err = "عذرا، أدخل البريد الإلكتروني الخاص بك.";
            }
            else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $err = "عذرا، البريد الإلكتروني غير صحيح.";
            }
            else
            {
                $w['email'] = $email;
                $w['user_verified'] = 1;
                if ($type == 'admin')
                {
                    $w['user_status'] = 1;
                }
                $sel = $this->cms_model->select('users',$w);
            
                if ($sel->num_rows() == 1)
                {
                    $row = $sel->row_array();
                    $code = encode($row['user_token']."--".time(),TRUE);

                    // send a msg to the email
                    
                    $to = $row['email'];
                    $subject = "استعادة كلمة المرور.";

                    $page = ($type == '')? 'login' : get_config_item('admin_page_path').'/login' ;

                    $t = base_url($page)."/repass?t=".$code;
                    
                    $msg_path = "forget_password";

                    $consts = array(
                            'URL_TIMEOUT' => get_config_item('restoration_time_account'),
                            'REST_PASSWORD_URL' => $t,
                            'USERNAME' => $row['username']
                        );

                    $template = email_tpls_load_and_replace($msg_path, $consts, TRUE);

                    /*
                    echo "<pre dir='ltr'>";
                    echo htmlspecialchars($template);
                    echo '</pre>';
                    */

                    if (sendEmail($to,$subject,$template))
                    {
                        $ok = "لقد تم الإرسال رسالة إلى بريدك الإلكتروني لاستعادة حسابك.";
                        $ok .= "
                        <script>
                        setTimeout(function (){
                            window.location.href = '".base_url($page)."';
                        },6000);
                        </script>
                        ";
                        //$this->data['showForm'] = 0;
                    }
                    else
                    {
                        $err = "عذرا، لقد حدث خطأ أعد المحاولة.";
                    }
                }
                else
                {
                    $err = "عذرا، البريد الإلكتروني غير مسجل لدينا.";
                }
            }

            if (isset($err) && $err != "")
            {
                return "<div class='alert alert-danger'><i class='fa fa-lg fa-exclamation-circle'></i> ".$err."</div>";
            }
            else if (isset($ok) && $ok != "")
            {
                return "<div class='alert alert-success'><i class='fa fa-lg fa-check'></i> ".$ok."</div>";
            }

        } // end if
    }

    public function repass ($token,$type='')
    {
        if ($this->input->post('submit'))
        {
            $newPass        = trim(strip_tags($this->input->post('new-pass',TRUE)));
            $confNewPass    = trim(strip_tags($this->input->post('conf-new-pass',TRUE)));

            if (!recaptcha())
            {
                $err = "كود الكابتشا خاطئ ، أعد المحاولة.";
            }
            else if ($newPass == "" or $confNewPass == "")
            {
                $err = "عذرا، املأ جميع الحقول.";
            }
            else if ($newPass != $confNewPass)
            {
                $err = "عذرا، كلمتا المرور غير متطابقتان.";
            }
            else if (mb_strlen($newPass) > 100) 
            {
                $err = "عذرا،<b>كلمة المرور</b> أطول من اللازم.";
            }
            else if (mb_strlen($newPass) < 5)
            {
                $err = "عذرا،<b>كلمة المرور</b> أقصر من اللازم.";
            }
            else
            {
                $set['password'] = password_hash($newPass,PASSWORD_DEFAULT);
                $w['user_token'] = $token;
                if ($type == 'admin')
                {
                    $w['user_status'] = 1;
                }
                $up = $this->cms_model->update('users',$set,$w);

                if ($up)
                {
                    $redirect = ($type == '')? 'login' : get_config_item('admin_page_path').'/login' ;

                    $ok = "تم حفظ كلمة المرور الجديدة بنجاح، جار توجيهك ...";
                    $ok .= "
                    <script type='text/javascript'>
                        setTimeout(function (){
                            window.location.href = '".base_url($redirect)."';
                        },6000);
                    </script>
                    ";
                }
                else
                {
                    $err = "عذرا، لقد حدث خطأ غير متوقع !";
                }
            }
        }


        if (isset($err) && $err != "")
        {
            return "<div class='alert alert-danger'><i class='fa fa-lg fa-exclamation-circle'></i> ".$err."</div>";
        }
        else if (isset($ok) && $ok != "")
        {
            return "<div class='alert alert-success'><i class='fa fa-lg fa-check'></i> ".$ok."</div>";
        }
    }

    public function userProfileUpdate ()
    {
        $username   = trim(strip_tags($this->input->post('username',TRUE)));
        $gender     = intval($this->input->post('gender',TRUE));
        $birth_day  = trim(strip_tags($this->input->post('birth-day',TRUE)));
        $country    = intval($this->input->post('country',TRUE));
        $sec_ques   = trim(strip_tags($this->input->post('sec-que',TRUE)));
        $ans_ques   = trim(strip_tags($this->input->post('ans-que',TRUE)));

        if ($username == '')
        {
            $err = "عذرا، أدخل اسم المستخدم.";
        }
        else if (mb_strlen($username) < 4)
        {
            $err = "عذرا، اسم المستخدم أقصر من اللازم.";
        }
        else if (mb_strlen($username) > 50)
        {
            $err = "عذرا، اسم المستخدم أطول من اللازم.";
        }
        else if ($gender == '')
        {
            $err = "عذرا، إختر نوعك ذكر أم أنتى";
        }
        else if ($country == 0)
        {
            $err = "عذرا، إختر دولتك.";
        }        
        else if (!preg_match("/^((0?[13578]|10|12)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[01]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))|(0?[2469]|11)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[0]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1})))$/m",$birth_day))
        {
            $err = "عذرا، تاريخ الإزدياد غير صالح !";
        }
        else
        {
            $userId = $this->data['userdata']['id'];

            $set['username'] = $username;
            $set['gender']   = $gender; // 1 = male ||| 2 = female
            $w['id'] = $userId;
            $up = $this->cms_model->update('users',$set,$w);


            $a['birth_date'] = $birth_day;
            $a['country']  = $country;
            $a['sec_ques'] = $sec_ques;
            $a['ans_ques'] = $ans_ques;

            // delete all information from database by user_id
            foreach ($a as $k => $v) {
                $w = array();
                $w['user_id'] = $userId;
                $w['user_option'] = $k;
                
                $del = $this->cms_model->delete('usersmeta', $w);
            }

            // insert all information to database
            $s = array();
            foreach ($a as $k => $v)
            {
                $d['user_id'] = $userId;
                $d['user_option'] = $k;
                $d['user_value'] = $v;

                $sel = $this->cms_model->insert('usersmeta',$d);
                if ($sel)
                {
                    array_push($s,1);
                }
                else
                {
                    array_push($s,0);   
                }
            }
            
            if (in_array(0,$s))
            {
                $err = "عذرا، لقد حدث خطأ، أعد المحاولة !";
            }
            else
            {
                $ok = "تم حفظ البيانات بنجاح.";
            }            
        } // end else

        if (isset($err) && $err != '')
        {
            return array('err',$err);
        }
        else if (isset($ok) && $ok != '')
        {
            return array('ok',$ok);
        }
    
    } // and userProfileUpdate function

    /*
    public function switchLanguage() {
        //$language = ($language != "") ? $language : config_item('default_language');
        
        $q = $this->select('settings',array('option_name'=>'default_language'));
        $row = $q->result_array();

        $a = array('en','ar');
        //$language = config_item('default_language');

        if (in_array($this->input->get('lang',TRUE),$a))
        {
            //echo '1';
            $language = trim(strip_tags($this->input->get('lang',TRUE)));
            set_cookie('site_lang',$language,config_item('cookie_expire'));
        }
        else if (get_cookie('site_lang') != '' && in_array(get_cookie('site_lang'),$a))
        {
            //echo '2';
            $language = trim(strip_tags(get_cookie('site_lang')));
        }
        else
        {
            redirect(base_url(uri_string().'?lang='.$row[0]['option_value']));
        }

        $this->lang->load($language,$language);
        //redirect(base_url().uri_string());
    }
    */


}


?>