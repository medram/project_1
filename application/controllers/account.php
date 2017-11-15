<?php

class Account extends MY_controller
{
	public $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->data['page_path'] = strtolower(__CLASS__);
		$this->isUser();
		$this->isBanned();
		// just for debugging mode
		//$this->output->enable_profiler(true);
	}

	private function isBanned ()
	{
		if ($this->data['userdata']['account_status'] == 2) // 2 = banned
		{
			if (strtolower($this->uri->segment(2)) != 'banned')
			{
				redirect(base_url($this->data['page_path'].'/banned'));
			}
		}
	}

	private function isUser ()
	{
		$usertoken = $this->session->token;

		if ($usertoken == '')
		{
			$this->session->unset_userdata('token');
			redirect(base_url('login'));
		}
		else
		{
			// get the user data from users tabel
	        $q = $this->cms_model->select('users',array('user_token'=>$usertoken,'user_verified'=>1));
	        if ($q->num_rows() == 1)
	        {
	            $a = $q->result_array();
	            $this->data['userdata'] = $a[0];

	            // get the user data from usersmata tabel
				$sel = $this->cms_model->select('usersmeta',array('user_id'=>$a[0]['id']));
				$r = $sel->result_array();
				/*
				echo "<pre>";
				print_r($r);
				echo "</pre>";
				*/
				foreach ($r as $k => $row)
				{
					$this->data['userdata'][$row['user_option']] = $row['user_value'];	
				}
				/*
				echo "<pre dir='ltr'>";
				print_r($this->data['userdata']);
				echo "</pre>";
				*/
				$sel->free_result();
	        }
	        else
	        {
	        	$this->session->unset_userdata('token');
	        	redirect(base_url('login'));
	        }
	        $q->free_result();
		}
	}

	public function index ()
	{
		$this->data['title'] = "مرحبا بك ".$this->data['userdata']['username']." !";
		
		/*============================= get statistics data ============================*/
		$w_st['user_id'] = $this->data['userdata']['id'];
		$s_st = $this->cms_model->select('statistics',$w_st,array('id','DESC'));

		$this->data['s_st'] = $s_st;

		/*================ count all links and all views of all links ===================*/
		$w_l['user_id'] = $this->data['userdata']['id'];
		$s_l = $this->cms_model->select('links',$w_l);

		$all_linls_views = 0;
		
		if ($s_l->num_rows() > 0)
		{
			foreach ($s_l->result_array() as $row)
			{
				$all_linls_views = $all_linls_views + $row['views'];
			}
		}

		$this->data['all_linls_views'] = $all_linls_views;
		$this->data['all_links'] = $s_l->num_rows();
		$s_l->free_result();
		/*=============================*/

		$this->load->view("templates/header",$this->data);
		$this->data['sidebar'] = $this->load->view("templates/user_sidebar",$this->data,TRUE);
		$this->load->view("pages/user_account/dashboard",$this->data);
		$this->load->view("templates/footer",$this->data);

		$s_st->free_result();
	}

	public function dashboard ()
	{
		$this->index();
	}

	public function profile()
	{
		$this->data['title'] = "حسابي";
		

		$this->load->view("templates/header",$this->data);
		$this->data['sidebar'] = $this->load->view("templates/user_sidebar",$this->data,TRUE);
		$this->load->view("pages/user_account/profile",$this->data);
		$this->load->view("templates/footer",$this->data);
	}

	public function banned ()
	{
		if ($this->data['userdata']['account_status'] == 2) // 2 = banned
		{
			$this->data['title'] = "تم حظر حسابك !";
			

			$this->load->view("templates/header",$this->data);
			$this->data['sidebar'] = $this->load->view("templates/user_sidebar",$this->data,TRUE);
			$this->load->view("pages/user_account/Banned",$this->data);
			$this->load->view("templates/footer",$this->data);
		}
		else
		{
			redirect(base_url($this->data['page_path']));
		}
	}

	public function addlinks ()
	{
			$this->data['title'] = " إختصار روابط جديدة";
			

			$this->load->view("templates/header",$this->data);
			$this->data['sidebar'] = $this->load->view("templates/user_sidebar",$this->data,TRUE);
			$this->load->view("pages/user_account/addlinks",$this->data);
			$this->load->view("templates/footer",$this->data);
	}

	public function mylinks ($v='',$p='')
	{
		if ($this->input->get('s'))
		{
			$str = trim(strip_tags($this->input->get('s',TRUE)));
			$this->data['string'] = $str;
			$cols = array('title','slug');
			$string = '?s='.$str;
		}
		else
		{
			$string = '';
		}

		if ($v == '' or $p == '')
		{
			redirect(base_url($this->data['page_path'].'/mylinks/p/1'.$string));
		}
		
		$p = (intval($p) <= 0)? redirect(base_url($this->data['page_path'].'/mylinks/p/1')) : intval($p) ;
		$lenght = 15; // number of link per page
		$start = ceil(($p - 1) * $lenght);
		

		$w['user_id'] = $this->data['userdata']['id'];

		if (isset($str))
		{
			//$str,$table,$col,$where='',$orderBy='',$length='',$start=''
			$s2 = $this->cms_model->search($str, 'links', $cols, $w);
			$this->data['searchType'] = 'search';
		}
		else
		{
			$s2 = $this->cms_model->select('links',$w);
			$this->data['searchType'] = 'auto';
		}

		$total_items = $s2->num_rows();
		$this->data['total_items'] = $total_items;
		$this->data['num_per_page'] = $lenght;
		$all_pages = ceil($total_items / $lenght);
		$this->data['all_pages'] = $all_pages;
		$this->data['p'] = $p;		

		$this->data['no_result_of_search'] = 1;

		if ($total_items != 0)
		{
			$this->data['no_result_of_search'] = 0;

			if ($p > $all_pages)
			{
				redirect(base_url($this->data['page_path'].'/mylinks/p/1'.$string));
			}
			else
			{
				if (isset($str))
				{
					//$str,$table,$col,$where='',$orderBy='',$length='',$start=''
					$s = $this->cms_model->search($str,'links',$cols,$w,array('id','DESC'),$lenght,$start);			
				}
				else
				{
					$s = $this->cms_model->select('links',$w,array('id','DESC'),$lenght,$start);
				}
				
				$this->data['links'] = $s;
			}
		}

		$this->data['title'] = 'روابطي المختصرة';

		$this->load->view("templates/header",$this->data);
		$this->data['sidebar'] = $this->load->view("templates/user_sidebar",$this->data,TRUE);
		$this->load->view("pages/user_account/mylinks",$this->data);
		$this->load->view("templates/footer",$this->data);

		if (isset($s))
		{
			$s->free_result();
		}
		$s2->free_result();
	}

	public function settings ()
	{
		$this->data['title'] = 'إعدادات روابطي المختصرة';

		$this->load->view("templates/header",$this->data);
		$this->data['sidebar'] = $this->load->view("templates/user_sidebar",$this->data,TRUE);
		$this->load->view("pages/user_account/settings",$this->data);
		$this->load->view("templates/footer",$this->data);
	}

	public function ajax ($var="")
	{
		/*======================== Change data of user =============================*/
		if ($this->input->post('tab',TRUE) == 1)
		{
			$mess = $this->cms_model->userProfileUpdate();
			if ($mess[0] == 'ok')
			{
				$ok = $mess[1];
			}
			else
			{
				$err = $mess[1];
			}

		} // end if of update data of user
	
		/*======================== Change password of user =============================*/
		if ($this->input->post('tab',TRUE) == 2)
		{
			$old_pass 	= trim(strip_tags($this->input->post('old-pass',TRUE)));
			$new_pass 	= trim(strip_tags($this->input->post('new-pass',TRUE)));
			$conf_pass 	= trim(strip_tags($this->input->post('conf-new-pass',TRUE)));

			if (!recaptcha())
			{
				$err = "كود الكابتشا خاطئ ، أعد المحاولة.";
			}
			else if ($old_pass == '' or $new_pass == '' or $conf_pass == '')
			{
				$err = "إملأ جميع الخانات من فضلك.";
			}
			else if (!password_verify($old_pass,$this->data['userdata']['password']))
			{
				$err = "عذرا، <b>كلمة المرور الحالية</b> غير صحيحة.";
			}
			else if ($new_pass != $conf_pass)
			{
				$err = "عذرا، <b>كلمتا المرور</b> غير متطابقتان.";
			}
			else
			{
				$set['password'] = password_hash($new_pass,PASSWORD_DEFAULT);
				$where = array('user_token'=>$this->data['userdata']['user_token']);
				
				$up = $this->cms_model->update('users',$set,$where);

				if ($up)
				{
					$ok = "
					تم حفظ كلمة المرور الجديدة بنجاح.
					<script type='text/javascript'>
						$('input[name=old-pass]').val('');
						$('input[name=new-pass]').val('');
						$('input[name=conf-new-pass]').val('');
					</script>
					";
				}
				else
				{
					$err = "عذرا، لقد حدث خطأ، أعد المحاولة !";
				}
			}

			$script = "
				<script type='text/javascript'>
					$(document).ready(function (){
						// If recaptcha object exists, refresh it
						setTimeout(function (){
							grecaptcha.reset();
						},2000);
					});
				</script>
			";
			
			if (isset($err))
			{
				$err .= $script;
			}
			else
			{
				$ok .= $script;
			}
		} // end repass

		/*======================= Uplade profile image ===========================*/
		if ($this->input->post('tab') == 'img')
		{
	        $config['upload_path']          = './uploads/users/profile-images';
	        $config['allowed_types']        = 'gif|jpg|png';
	        $config['max_size']             = 1024*1; // 1 MB
	        $config['max_width']            = 1024;
	        $config['max_height']           = 1024;
	        $config['file_name']			= md5($this->data['userdata']['user_token']).".png";
	        $config['overwrite'] 			= TRUE;

	        $this->load->library('upload',$config);

			if (!$this->upload->do_upload('img'))
			{
				$err = $this->upload->display_errors();
			}
			else
			{
				/*
				echo "<pre dir='ltr'>";
				print_r($this->upload->data());
				echo "</pre>";
				*/
				$img_data = $this->upload->data();

			    $conf['image_library'] 	= 'gd2';
			    $conf['source_image'] 	= './uploads/users/profile-images/'.$img_data['file_name'];
			    $conf['create_thumb'] 	= FALSE;
			    $conf['maintain_ratio'] = TRUE;
			    $conf['width']     		= 170;
			    $conf['height']   		= 170;
			    $conf['quality']		= 100;
			    //$conf['master_dim'] 	= ;

			    $this->load->library('image_lib',$conf);
			    //$this->image_lib->clear();
			    if (!$this->image_lib->resize())
			    {
			    	$err = $this->image_lib->display_errors();
			    }
			    else
			    {
			    	$ok = "تم التحميل بنجاح، أعد تحديث الصفحة إذا لم تظهر الصورة. ";
			    }
			}
		}

		/*======================== Add a new link =============================*/

		if ($this->input->post('action') == 'addLink')
		{
			$title 		= trim(strip_tags($this->input->post('title',TRUE)));
			$url 		= trim(strip_tags($this->input->post('url',TRUE)));
			$type 		= abs(intval($this->input->post('type',TRUE)));

			$newLinks = '';
			$ex  = explode("\n",$url);
			
			// if there are a one link
			if (count($ex) == 1 && $type == 0)
			{
				if (!recaptcha())
				{
					$err = "كود الكابتشا خاطئ ، أعد المحاولة.";
				}
				else if ($title == '')
				{
					$err = 'عذرا، أدخل عنوانا للرابط !';
				}
				else if (mb_strlen($title) > 100)
				{
					$err = 'عذرا، العنوان أطول من الازم !';
				}
				else if ($url == '')
				{
					$err = 'عذرا، أدخل الرابط المراد اختصاره';
				}
				else if (mb_strlen($url) > 500)
				{
					$err = 'عذرا، رابط الموقع طويل جدا !';
				}
				else if (!is_url($url))
				{
					$err = 'عذرا، الرابط غير صالح !';
				}
				else if (is_forbiden_url($url))
				{
					$err = 'عذرا، هذا الرابط محظور ، لا بمكنك اختصاره!';
				}
				else
				{
					$slug = get_slug();
					$newLinks = base_url().'go/'.$slug;

					$d['user_id'] 	= $this->data['userdata']['id'];
					$d['title'] 		= $title;
					$d['url'] 			= encode($url);
					$d['slug'] 			= $slug;
					$d['status'] 		= 1;
					$d['modified'] 		= time();
					$d['created'] 		= time();

					$insert = $this->cms_model->insert('links',$d);
					
					if ($insert)
					{
						$ok = "تم الإختصار بنجاح.";
					}
					else
					{
						$err = 'عذرا، لقد حدث خطأ غير متوقع، من فضلك أعد المحاولة !';
					}
				}
			}
			else if ($type == 1) // go to multi links
			{
				$url = $ex;
				$a = array();
				foreach ($url as $k => $link) {
					if ($link == "" or $link == " " or $link == "\n" or $link == "\r" 
						or $link == "\r\n" or $link == "\n\r")
					{
						continue;
					}
					else
					{
						$a[] = $link;
					}
				}

				$url = $a;
				if (!recaptcha())
				{
					$err = "كود الكابتشا خاطئ ، أعد المحاولة.";
				}
				else if ($title == '')
				{
					$err = 'عذرا، أدخل عنوانا للروابط !';
				}
				else if (mb_strlen($title) > 100)
				{
					$err = 'عذرا، العنوان أطول من الازم !';
				}
				else if (count($url) == 0)
				{
					$err = 'عذرا، أدخل الروابط المراد اختصارها !';
				}
				else
				{
					/*
					echo '<pre>';
					print_r($url);
					echo '</pre>';
					*/
					$err_link = '';
					$err_msg = '';

					foreach ($url as $k => $link)
					{
						if (!is_url($link))
						{
							$err_link = $k+1;
							$err_msg = "الرابط في السطر ".$err_link." غير صالح !";
							break;
						}
						else if (mb_strlen($link) > 500)
						{
							$err_msg = "الرابط في السطر ".($k+1)." طويل جدا , ضع رابطا أقصر منه !";
						}
						else if (is_forbiden_url($link))
						{
							$err_msg = 'الرابط في السطر '.($k+1).' محظور، لايمكنك اختصاره!';
							break;
						}
					}

					if ($err_msg != '')
					{
						$err = $err_msg;
					}
					else if (count($url) > 10)
					{
						$err = "لقد وضعت روابط كثيرة , عدد الروابط المسموح باختصارها دفعة واحدة هي 10 روابط !";
					}
					else
					{
						$newLinks = array();
						$a_errs = array();
						foreach ($url as $link)
						{
							$slug = get_slug();
							$newLinks[] = base_url().'go/'.$slug;

							$d['user_id'] 	= $this->data['userdata']['id'];
							$d['title'] 		= $title;
							$d['url'] 			= encode($link);
							$d['slug'] 			= $slug;
							$d['status'] 		= 1;
							$d['modified'] 		= time();
							$d['created'] 		= time();

							$insert = $this->cms_model->insert('links',$d);
							
							if ($insert)
							{
								$a_errs[] = 1;
							}
							else
							{
								$a_errs[] = 0;
							}
						} // end for loop	
					
						if (!in_array(0,$a_errs))
						{
							$ok = "تم اختصار روابطك بنجاح.";
						}
						else
						{
							$err = "عذرا، لقد حدث خطأ, أعد المحاولة من فضلك !";
						}

						// change the url array to string
						$newLinks = implode('\n',$newLinks);

					}
				}
			} // end else

			$script = "
				<script type='text/javascript'>
					$(document).ready(function (){
						// If recaptcha object exists, refresh it
						setTimeout(function (){
							grecaptcha.reset(recaptcha1);
							grecaptcha.reset(recaptcha2);
						},2000);
					});
				</script>
			";

			$script2 = "
				<script type='text/javascript'>
				$(document).ready(function (){
					$('#boxToAddLink').slideUp(function (){
						$('#urls textarea').html('".$newLinks."');
						$('#urls').slideDown();
					});
					$('#boxToAddLink input[type=text]').val('');
					$('#boxToAddLink textarea').val('');
				});
				</script>
			";

			if (isset($err))
			{
				$err .= $script;
			}
			else if (isset($ok))
			{
				$ok .= $script."<br>".$script2;
			}

		}

		/*======================== Delete link by user ===========================*/

		if ($this->input->post('deleteLink'))
		{
			$id = abs(intval($this->input->post('id',TRUE)));

			$w['id'] = $id;
			$w['user_id'] = $this->data['userdata']['id'];

			$del = $this->cms_model->delete('links',$w);
		
			if ($del)
			{
				echo "تم الحذف بنجـــاح";
			}
			else
			{
				echo "عذرا، لقد حدث خطأ، أعد المحاولة من فضلك !";
			}
		}

		/*======================== update User Settings =========================*/

		if ($this->input->post('update-Settings'))
		{
			$pub 		= strip_tags($this->input->post('user_pub',TRUE));
			$channel 	= $this->input->post('user_channel',TRUE);
			$count 		= abs(intval($this->input->post('user_countdown',TRUE)));
			$url 		= trim(strip_tags($this->input->post('user_url',TRUE)));
			$user_id 	= $this->data['userdata']['id'];

			if ($pub == '')
			{
				$err = 'أدخل كود pub من فضلك.';
			}
			else if (!preg_match("/^(pub-){1}([0-9]{16})$/",$pub))
			{
				$err = 'كود pub غير صالح !';
			}
			else if ($channel != '' && !is_numeric($channel))
			{
				$err = 'عذرا، يجب أن تكون قيمة كود channel قيمة رقمية !';
			}
			else if (mb_strlen($channel) > 10)
			{
				$err = 'عذرا، كود channel غير صالح !';
			}
			else if ($count < 10 or $count > 60)
			{
				$err = 'عذرا، قيمة العد التنازلي غير مسموح بها !';
			}
			else if ($url != '' && !filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED))
			{
				$err = 'عذرا، رابط موقعك الإلكتروني غير صالح !';
			}
			else
			{
				$a = array();
				$a['user_pub']		= $pub;
				$a['user_channel']	= $channel;
				$a['countdown'] 	= $count;
				$a['user_url'] 		= $url;
				foreach ($a as $k => $v)
				{
					$w2['user_id'] = $user_id;
					$w2['user_option'] = $k;
					$del = $this->cms_model->delete('usersmeta',$w2);
					
					$da['user_id'] = $user_id;
					$da['user_option'] = $k;
					$da['user_value'] = $v;
					$insert = $this->cms_model->insert('usersmeta',$da);
				}
				
				if ($del && $insert)
				{
					$ok = 'تم حفظ البيانات بنجاح !';
				}
				else
				{
					$err = 'عذرا، لقد حدث خطأ، أعد المحاولة من فضلك !';
				}
			}
		}

		/*==================== block the user his account ========================*/

		if ($this->input->post('blockAccount'))
		{
			$pass = trim(strip_tags($this->input->post('pass',TRUE)));

			$w['user_token'] = $this->data['userdata']['user_token'];
			$w['user_status'] = 0;
			$s_user = $this->cms_model->select('users',$w);

			if ($s_user->num_rows() == 1)
			{
				$row = $s_user->row_array();

				if (password_verify($pass,$row['password']))
				{
					$set['account_status'] = 1; // inactive account
					$where['user_token'] = $row['user_token'];
					$up = $this->cms_model->update('users',$set,$where);

					/*
					$w['user_token'] = $row['user_token'];
					$w['account_blocked_by_user'] = 1;
					$del = $this->cms_model->delete('usersmeta',$w);

					$da['user_token'] = $row['user_token'];
					$da['account_blocked_by_user'] = 1;
					$insert = $this->cms_model->insert('usersmeta',$da);
					*/
					if ($up)
					{
						$script = "
						<script>
						setTimeout(function (){
							window.location.href='".base_url('logout')."';
						},5000);
						</script>
						";
						$ok = 'تم حذف حسابك بنجـــاح، جار تسجيل خروجك ...'.$script;
					}
					else
					{
						$err = 'عذرا، لقد حدث خطأ، أعد المحاولة من فضلك !';
					}
				}
				else
				{
					$err = 'عذرا، كلمة المرور خاطئة !';
				}
			}
			else
			{
				$err = 'ههههههههه لم يحدت شيء!';
			}

			$s_user->free_result();

			if (isset($err) && $err != '')
			{
				$err .= "
				<script>
					$('#deleteAccountByUser').fadeIn();
				</script>
				";
			}
		}

		/*======================== Echo the messages =============================*/

		if (isset($err) && $err != '')
		{
			echo "<div class='alert alert-warning'>".$err."</div>";
		}
		else if (isset($ok) && $ok != '')
		{
			echo "<div class='alert alert-success'><i class='fa fa-lg fa-check'></i> ".$ok."</div>";
		}

	} // end ajax function
}


?>