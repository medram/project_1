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
				$err = langLine('notifAccount.register.span.1', false);
			}
			else if ($username == '' or $email == '' or $password == '' or $conf_pass == '')
			{
				$err = langLine('notifAccount.register.span.2', false);
			}
			else if (mb_strlen($username) > 50)
			{
				$err = langLine('notifAccount.register.span.3', false);
			}
			else if (mb_strlen($username) < 4)
			{
				$err = langLine('notifAccount.register.span.4', false);
			}
			else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$err = langLine('notifAccount.register.span.5', false);
			}
			else if ($this->cms_model->is_registered($email))
			{
				$err = langLine('notifAccount.register.span.6', false);
			}
			else if (mb_strlen($password) > 100) 
			{
				$err = langLine('notifAccount.register.span.7', false);
			}
			else if (mb_strlen($password) < 5)
			{
				$err = langLine('notifAccount.register.span.8', false);
			}
			else if ($password != $conf_pass)
			{
				$err = langLine('notifAccount.register.span.9', false);
			}
			else if ($agree != 1)
			{
				$err = langLine('notifAccount.register.span.10', false);
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
					$t = base_url('register/activation?u=').encode($token,TRUE);

					$to = $email;
					$sub = langLine('notifAccount.register.span.11', false, config_item('sitename'));
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
						$ok = langLine('notifAccount.register.span.12', false);
					}
					else
					{
						$err = langLine('notifAccount.register.span.13', false);
					}
				}
				else
				{
					$err = langLine('notifAccount.register.span.14', false);
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

		$data['title'] = langLine('notifAccount.register.span.15', false);

		$this->load->view("templates/header",$data);
		$this->load->view("pages/register",$data);
		$this->load->view("templates/footer",$data);
	}

}


?>

