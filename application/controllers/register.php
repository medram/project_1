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
					$tpl_path = "activation"; // include template here and replace all constants

					$const = array(
							"TITLE" => $sub,
							"USERNAME" => $username,
							"ACTIVATION_URL" => $t
						);

					$tpl = email_tpls_load_and_replace($tpl_path, $const, TRUE);

					/*
					echo "<pre dir='ltr'>";
					echo htmlspecialchars($tpl);
					echo '</pre>';
					*/

					if (sendEmail($to, $sub, $tpl))
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

