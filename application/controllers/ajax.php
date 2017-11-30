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
			$a = array('رسالة عادية','الإبلاغ عن شيء ما','طلب استفسار','واجهت مشكلة بالموقع');

			$title 		= trim(strip_tags($this->input->post('title',TRUE)));
			$email 		= trim(strip_tags($this->input->post('email',TRUE)));
			$type 		= $a[abs(intval($this->input->post('type',TRUE)))];
			$content 	= trim(strip_tags($this->input->post('content',TRUE)));

			if (!recaptcha())
			{
				$err = 'عذرا، كود الكابتشا خاطئ !';
			}
			else if (empty($title) or empty($email) or empty($type) or empty($content))
			{
				$err = "عذرا، املأ جميع الخانات من فضلك !";
			}
			else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$err = "عذرا، البريد الإلكتروني غير صالح !";
			}
			else if (mb_strlen($title,'UTF-8') > 100)
			{
				$err = "عذرا، العنوان أطرل من للازم !";
			}
			else if (mb_strlen($content,'UTF-8') > 1000)
			{
				$err = "عذرا، محتوى الرسالة أطرل من اللازم !";
			}
			else
			{
				$this->load->library('user_agent');

				$ip 		= $this->input->ip_address();
				$agent 		= $this->input->user_agent();
				$platform 	= $this->agent->platform();
				$date 		= date(config_item('time_format'),time());
				$to 		= get_config_item('email_from');
				//$from 		= array($email,config_item('sitename').': '.$type);

				$consts = array(
						'TITLE' => $title,
						'DATE' => $date,
						'EMAIL' => $email,
						'PLATFORM' => $platform,
						'IP' => $ip,
						'TYPE' => $type,
						'CONTENT' => $content
					);

				$tpl = email_tpls_load_and_replace('contact', $consts, FALSE);

				// $to,$subject,$msg,$priority=3,$mailtype='html'
				if (sendEmail($to,$title,$tpl,null, 3, 'text'))
				{
					$ok = "تم الإرسال بنجــــاح.
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
					$err = "عذرا، لقد حدث خطأ غير متوقع، أحد المحاولة من فضلك !";
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

} // end class

?>