<?php

class Ajax extends MY_controller
{
	private $data = array();

	public function __construct ()
	{
		parent::__construct();
		$this->data['page_name'] = strtolower(__CLASS__);
	}

	public function index ()
	{
		/*======================== Contact us ============================*/
		if ($this->input->post('contact') == 1)
		{
			$a = array(
				langLine('notifAccount.contact.span.1', false),
				langLine('notifAccount.contact.span.2', false),
				langLine('notifAccount.contact.span.3', false),
				langLine('notifAccount.contact.span.4', false)
			);

			$title 		= trim(strip_tags($this->input->post('title',TRUE)));
			$email 		= trim(strip_tags($this->input->post('email',TRUE)));
			$type 		= $a[abs(intval($this->input->post('type',TRUE)))];
			$content 	= trim(strip_tags($this->input->post('content',TRUE)));

			if (!recaptcha())
			{
				$err = langLine('notifAccount.contact.span.5', false);
			}
			else if (empty($title) or empty($email) or empty($type) or empty($content))
			{
				$err = langLine('notifAccount.contact.span.6', false);
			}
			else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$err = langLine('notifAccount.contact.span.7', false);
			}
			else if (mb_strlen($title,'UTF-8') > 100)
			{
				$err = langLine('notifAccount.contact.span.8', false);
			}
			else if (mb_strlen($content,'UTF-8') > 1000)
			{
				$err = langLine('notifAccount.contact.span.9', false);
			}
			else
			{
				$this->load->library('user_agent');

				$ip 		= $this->input->ip_address();
				$agent 		= $this->input->user_agent();
				$platform 	= $this->agent->platform();
				$date 		= date(config_item('time_format'),time());
				$to 		= get_config_item('SMTP_User');
				$from 		= array($email,config_item('sitename').': '.$type);

				/*$content .= "
				<hr>
				<div dir='ltr'>
					<b>معلومات عن المرسل</b><br><br>
					date : ".$date."<br>
					ip : ".$ip."<br>
					email : ".$email."<br>
					platform : ".$platform."<br>
					
				</div>
				";
				*/

				$msg = langLine('notifAccount.contact.span.10', false, [$title, $type])."<br><br>";
				$msg .= $content;

				$msg .= "
					<br>--------------------------------------------------<br>".
					langLine('notifAccount.contact.span.11', false, [$date, $ip, $platform, $email]);

				// $to,$subject,$msg,$priority=3,$mailtype='html'
				if (sendEmail($to,$title,$msg,$from))
				{
					$ok = langLine('notifAccount.contact.span.12', false)."
						<script type='text/javascript'>
							$(document).ready(function(){
								setTimeout(function (){
									$('.adsBox').load('".base_url()."p/contact .adsBox');
									grecaptcha.reset();
								},2000);

								$('input[type=text]').val('');
								$('select').val('');
								$('textarea').val('');								
							});
						</script>
					";
				}
				else
				{
					$err = langLine('notifAccount.contact.span.13', false);
				}
			}

			if (isset($err))
			{
				$err .= "
					<script type='text/javascript'>
						$(document).ready(function(){
							setTimeout(function (){
								$('.adsBox').load('".base_url()."p/contact .adsBox');
								grecaptcha.reset();
							},2000);
						});
					</script>
				";
			}

		}

		//=================== show messages ===================

		if (isset($err) && $err != '')
		{
			echo "<div class='alert alert-danger'>".$err."</div>";
		}
		else if (isset($ok) && $ok != '')
		{
			echo "<div class='alert alert-success'>".$ok."</div>";
		}
	}

	public function jsAjaxStrings()
	{
		$path = APPPATH.'language/'.config_item('validLang')['name'].'/ajax_lang.php';

		if (file_exists($path))
		{
			$data = include_once($path);
			
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($data);
		}
	}

} // end class

?>