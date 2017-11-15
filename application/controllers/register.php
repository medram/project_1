<?php

class Register extends MY_Controller
{
	public function __construct ()
	{
		parent::__construct();
		$this->cms_model->if_login_redirect_to('account');
	}

	public function index ()
	{
		//$this->load->library('input');
		if ($this->input->post('submit'))
		{
			$username = trim(strip_tags($this->input->post("user",TRUE)));
			$email    = trim(strip_tags($this->input->post("email",TRUE)));
			$password = trim(strip_tags($this->input->post("pass",TRUE)));
			$conf_pass = trim(strip_tags($this->input->post("conf-pass",TRUE)));
			$agree 		= abs(intval($this->input->post('agree')));

			if (!recaptcha())
			{
				$err = "كود الكابتشا خاطئ ، أعد المحاولة.";
			}
			else if ($username == '' or $email == '' or $password == '' or $conf_pass == '')
			{
				$err = "من فضلك إملأ جميع الحقول بما يناسب.";
			}
			else if (mb_strlen($username) > 50)
			{
				$err = "<b>اسم المستخدم أطول من اللازم.</b>";
			}
			else if (mb_strlen($username) < 4)
			{
				$err = "<b>اسم المستخدم</b> أقصر من اللازم.";
			}
			else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$err = "عذرا، <b>البريد الإلكتروني</b> غير صالح.";
			}
			else if ($this->cms_model->is_registered($email))
			{
				$err = "عذرا، <b>البريد الإلكتروني</b> تم التسجيل به من قبل.";
			}
			else if (mb_strlen($password) > 100) 
			{
				$err = "عذرا،<b>كلمة المرور</b> أطول من اللازم.";
			}
			else if (mb_strlen($password) < 5)
			{
				$err = "عذرا،<b>كلمة المرور</b> أقصر من اللازم.";
			}
			else if ($password != $conf_pass)
			{
				$err = "عذرا، كلمتا المرور غير متطابقتان.";
			}
			else if ($agree != 1)
			{
				$err = "عذرا، عليك الموافقة على شروط الإستخدام";
			}
			else
			{
				$token = sha1(md5(time()));
				$data = array(
						'username'		=> $username,
						'email'			=> $email,
						'password'		=> password_hash($password,PASSWORD_DEFAULT),
						'user_joined'   => time(),
						'user_status'	=> '0',
						'user_token'	=> $token,
						'user_verified'	=> '0'
					);

				if ($this->cms_model->register($data))
				{
					// send email to activation
					$t = base_url('login/activation?u=').encode($token,TRUE);

					$to = $email;
					$sub = "تفعيل حسابك على ".config_item('sitename');
					$msg = "
					<div>
						مرحبا <b>".$username."</b><br>
						يسرنا تسجيلك بالموقع ".config_item('sitename')."،<br>
						عليك تفعيل حسابك قبل أن تتمكن من استخدامه :<br><br>
                        <div style='text-align: center; display: block; padding: 40px;'>
                        <a href='".$t."' style='text-decoration: none; text-shadow: 0px 0px 5px #000;'>
                        <span style='
                            font-size: 15px;
                            color: #fff;
                            background: ".color().";
                            border-radius: 5px;
                            padding: 20px;
                            margin: 10px;
                            text-shadow: 0px 0px 5px #000;
                            '>تفعيل</span></a>
                        </div>
						<br>
						<p><b>ملاحضة</b> : إذا واجهتك مشكلة أثناء تفعيل حسابك ، يمكنك التواصل معنا عن طريق الرد على هذه الرسالة أو من خلال الموقع <a href='".base_url()."'>".config_item('sitename')."</a></p>
					</div>
					";

					if (sendEmail($to,$sub,$msg))
					{
						$ok = "تم التسجيل بنجاح، لقد تم إرسال رسالة إلى بريدك الإلكتروني لتفعيل حسابك.";
					}
					else
					{
						$err = "عذرا، لقد حدث خطأ غير متوقع، أعد المحاولة من فضلك !";
					}
				}
				else
				{
					$err = "عذرا، لقد حدث خطأ، أعد المحاولة من فضلك";
				}
				
				//$err = $username.'<br>'.$email.'<br>'.$password.'<br>'.password_hash($password,PASSWORD_DEFAULT);
			}

			if (isset($err) && $err != "")
			{
				$data['user_name'] = $username;
				$data['user_email'] = $email;
				$data['msg'] = "<div class='alert alert-warning'><i class='fa fa-fw fa-lg fa-info-circle'></i> ".$err."</div>";
			}
			else
			{
				$data['msg'] = "<div class='alert alert-success'><i class='fa fa-fw fa-lg fa-check'></i> ".$ok."</div>";
			}

		}

		$data['title'] = "تسجيل حساب جديد";

		$this->load->view("templates/header",$data);
		$this->load->view("pages/register",$data);
		$this->load->view("templates/footer",$data);
	}

}


?>

