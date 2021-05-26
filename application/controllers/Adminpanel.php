<?php

class Adminpanel extends MY_controller
{
	public $data = array();
	//public $userdata = array();

	public function __construct ()
	{
		parent::__construct();
		//$this->_conn = get_db();
		//$this->_db = $this->_conn->createQueryBuilder();
		$this->data['page_path'] = strtolower(__CLASS__); // you can change the name page from the url from here
		$this->isAdmin();
		// just for debugging mode
		//$this->output->enable_profiler(TRUE);
	}

	private function isAdmin()
	{
		$admintoken = $this->session->admin_token;

		if ($admintoken == '' && $this->uri->segment(2) != 'login')
		{
			$this->session->unset_userdata('admin_token');
			redirect(base_url($this->data['page_path'].'/login'));
		}
		else if ($admintoken != '' && $this->uri->segment(2) != 'login')
		{
			// get the admin data from users tabel
	        $q = $this->cms_model->select('users',array('user_status'=>1,'user_token'=>$admintoken,'user_verified'=>1));
	        if ($q->num_rows() == 1)
	        {
	            $a = $q->result_array();
	            $this->data['userdata'] = $a[0];

	            // get the admin data from usersmata tabel
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
				echo "<pre>";
				print_r($this->data['userdata']);
				echo "</pre>";
				*/
				$sel->free_result();
	        }
	        else
	        {
	        	$this->session->unset_userdata('admin_token');
	        	redirect(base_url($this->data['page_path'].'/login'));
	        }
	        $q->free_result();
		}
	}

	public function index ()
	{
		/*====================== get all users no verified =====================*/
		$w_users['user_verified'] = 0;
		$s_users = $this->cms_model->select('users',$w_users);
		$this->data['all_users_no_verified'] = $s_users->num_rows();

		/*====================== get all users verified ========================*/
		$w_users2['user_verified'] = 1;
		$s_users2 = $this->cms_model->select('users',$w_users2);
		$this->data['all_users_verified'] = $s_users2->num_rows();

		/*====================== get all views and links =======================*/
		$s_links = $this->cms_model->select('links');
		$this->data['all_links'] = $s_links->num_rows();

		$all_views_users = 0;
		$all_views_admin = 0;

		foreach ($s_links->result_array() as $row)
		{
			$all_views_users = $all_views_users + $row['views'];
			$all_views_admin = $all_views_admin + $row['admin_views'];
		}

		$this->data['all_views_users'] = $all_views_users;
		$this->data['all_views_admin'] = $all_views_admin;

		/*======================= get views per day ============================*/

		$day = date("Y-m-d",time());
		$this->data['views_this_day'] = 0;
		$this->data['views_this_day_admin'] = 0;
		$this->data['all_views_admin_30_day'] = 0;
		$this->data['all_views_users_30_day'] = 0;
		$a = array();

		for ($j=1; $j <= 2; $j++)
		{
			for ($i = 0; $i < 30; $i++)
			{
				$date = date("Y-m-d",strtotime($day)-($i*24*3600));

				if ($j == 2)
				{
					$w1['user_id'] = "----";
				}

				if ($j == 1)
				{
					$w1['user_id !='] = "----";
				}

				$w1['date'] = $date;
				$s1 = $this->cms_model->select('statistics',$w1);
				$w1 = array();

				$a[$i]['date'] = $date;
				/*
				echo "<pre dir='ltr'>$j<br>";
				print_r($this->db->last_query());
				echo "</pre>";
				*/

				if ($s1->num_rows() > 0)
				{
					$v = 0;
					foreach ($s1->result_array() as $row)
					{
						$v = $v + $row['views'];
					}

					$a[$i][] = $v;

					//============== count all views of admin and of user =================


					$all_vs = 0;

					foreach ($s1->result_array() as $row)
					{
						$all_vs = $all_vs + $row['views'];
					}

					if ($j == 2)
					{
						$this->data['all_views_admin_30_day'] = $this->data['all_views_admin_30_day'] + $all_vs;
					}
					else
					{
						$this->data['all_views_users_30_day'] = $this->data['all_views_users_30_day'] + $all_vs;
					}

					//==============


					if ($date == $day)
					{
						if ($j == 2)
						{
							$this->data['views_this_day_admin'] = $v;
						}
						else
						{
							$this->data['views_this_day'] = $v;
						}
					}
				}
				else
				{
					$a[$i][] = 0;
				}
			}
		} // end for loop

		sort($a);
		/*
		$a2 = array();
		for ($i = 30; $i > 0; $i--)
		{
			$a2[] = $a[$i-1];
		}
		*/
		/*
		echo "<pre dir='ltr'>";
		print_r($a);
		echo "</pre>";
		*/

		$d = "";
		// { x: '2006', y1: 100, y2: 90 },
		foreach ($a as $k => $v)
		{
			$separator = ($k == count($a)-1)? '' : ',';
			$d .= "{x: '".$v['date']."', y1: ".$v[1].", y2: ".$v[0]."}".$separator;
		}

		$this->data['all_d'] = $d;


		/*============================ get last links ==================================*/

		$s_lastLinks = $this->cms_model->select('links','',array('id','DESC'),15,0);

		if ($s_lastLinks->num_rows() > 0)
		{
			$linksData = $s_lastLinks->result_array();
			$s_user_by_link = NULL;
			static $users = array();

			foreach ($linksData as $k => $v)
			{
				if (!isset($users[$v['user_id']]))
				{
					$s_user_by_link = $this->cms_model->select('users', array('id' => $v['user_id']), 1, 0);
					$userInfo = $s_user_by_link->row_array();
					$users[$userInfo['id']] = $userInfo;
					$s_user_by_link->free_result();
				}
				else
					$userInfo = $users[$v['user_id']];

				$this->data['lastLinks'][] = array('link' => $v, 'userInfo' => $userInfo);
			}
		}

		/*============================ get last users ==================================*/

		$s_lastUsers = $this->cms_model->select('users','',array('id','DESC'),15,0);

		if ($s_lastUsers->num_rows() > 0)
		{
			$this->data['lastUsers'] = $s_lastUsers->result_array();
		}

		/*============================= online visitors ================================*/

		$s_online = $this->cms_model->select('online');
		$this->data['online'] = $s_online->num_rows();

		/*========================= get packages domains info ===========================*/

		$domains = explode("\r\n", get_config_item('packages_domains'));
		$domains_info = array();

		if (isset($domains[0]) && $domains[0] != '')
		{
			for ($i = 0; $i < count($domains); $i++)
			{
				$q = $this->cms_model->select('links', array('domain' => $i));
				$num = $q->num_rows();
				$domains_info[] = array('label' => $domains[$i], 'value' => $num);
				$q->free_result();
			}
		}
		else
		{
			$q = $this->cms_model->select('links');
			$num = $q->num_rows();
			$domains_info[] = array('label' => 'local domain', 'value' => $num);
			$q->free_result();
		}

		$this->data['domains_info'] = json_encode($domains_info);
		/*==============================================================*/

		$s_users->free_result();
		$s_users2->free_result();
		$s_links->free_result();
		//$s_st->free_result();
		$s1->free_result();
		$s_lastLinks->free_result();
		$s_lastUsers->free_result();
		$s_online->free_result();

		$this->data['title'] = 'Hello '.$this->data['userdata']['username'];

		$this->load->view('templates/admin_header',$this->data);
		$this->load->view('pages/admin/dashboard',$this->data);
		$this->load->view('templates/admin_footer',$this->data);
	}

	public function Dashboard ()
	{
		$this->index();
	}

	public function updates()
	{
		if (isset($_GET['check']) && $_GET['check'] == 'now')
		{
			// check manually from a MR4web server.
			$this->cms_model->update('settings', ['option_value' => '0'],['option_name' => 'last_update']);
			header("location: updates");
			exit();
		}

		$s = $this->cms_model->select('updates');
		if ($s->num_rows() == 1)
			$this->data['update'] = $s->row_array();
		else
			$this->data['update'] = "<b>ADLinker is Up To Date!</b>"; // No Update Available Right Now!

		$s2 = $this->cms_model->select('news', '', ['news_ID', 'DESC']);
		if ($s2->num_rows())
			$this->data['news'] = $s2->result_array();
		else
			$this->data['news'] = [];

		$s->free_result();
		$s2->free_result();

		// auto show notification "News" label
		$this->cms_model->update('settings', ['option_value' => '1'],['option_name' => 'viewed_news']);
		//-------------------

		$this->data['title'] = 'Updates & News';
		$this->load->view('templates/admin_header',$this->data);
		$this->load->view('pages/admin/updates', $this->data);
		$this->load->view('templates/admin_footer',$this->data);
	}

	public function license ()
	{
		$msg = '';
		$err = '';
		$this->data['showForm'] = 1;

		if (isset($_POST['license-go']))
		{
			$this->load->library('MR4Web', '', 'MR');

			$puchaseCode = strip_tags($this->input->post('license-code', true));
			$action = intval($this->input->post('license-action'));

			if ($puchaseCode == '')
			{
				$err = 'Please Enter a License Code (Purchase Code)!';
			}
			else if ($action == 0)
			{
				if ($puchaseCode != config_item('purchase_code') && config_item('purchase_code') != '')
					$this->MR->deactivate(config_item('purchase_code'));

				if ($this->MR->activate($puchaseCode))
				{

					$set['option_value'] = $puchaseCode;
					$where['option_name'] = 'purchase_code';

					$up = $this->cms_model->update('settings',$set,$where);
					if ($up)
					{
						$msg = $this->MR->getResMessage();
						if (!$this->MR->debugStatus())
						{
							$msg .= " Redirecting... <script>setTimeout(function (){
								window.location.href='dashboard';
							}, 7000);</script>";
						}
						$this->data['showForm'] = 0;
					}
				}
				else
					$err = $this->MR->getResMessage();
			}
			else
			{
				if ($this->MR->deactivate($puchaseCode))
				{
					$set['option_value'] = '';
					$where['option_name'] = 'purchase_code';

					$up = $this->cms_model->update('settings',$set,$where);
					if ($up)
						$msg = $this->MR->getResMessage();
				}
				else
					$err = $this->MR->getResMessage();
			}
		}

		if (isset($msg) && $msg != '')
			$this->data['msg'] = "<div class='alert alert-success'>{$msg}</div>";
		else if ($err != '')
			$this->data['msg'] = "<div class='alert alert-warning'>{$err}</div>";

		$this->data['title'] = 'License checker!';
		$this->load->view('templates/admin_header',$this->data);
		$this->load->view('pages/admin/license', $this->data);
		$this->load->view('templates/admin_footer',$this->data);
	}

	public function settings ()
	{
		$this->data['title'] = 'Site settings';
		$this->data['languages'] = $this->cms_model->select('languages')->result_array();

		$this->load->view('templates/admin_header',$this->data);
		$this->load->view('pages/admin/site_settings',$this->data);
		$this->load->view('templates/admin_footer',$this->data);
	}

	public function profile ()
	{
		$this->data['title'] = 'Profile';

		/*======================== Update admin profile ============================*/
		if ($this->input->post('edit-profile'))
		{
			$msg = "msg1";

			$username 		= trim(strip_tags($this->input->post('username',TRUE)));
			$email 			= trim(strip_tags($this->input->post('email',TRUE)));
			$birth_date 	= trim(strip_tags($this->input->post('date-birth',TRUE)));
			$sec_ques 		= trim(strip_tags($this->input->post('security-question',TRUE)));
			$ans_ques 		= trim(strip_tags($this->input->post('answer-question',TRUE)));

			if (empty($username) or empty($email))
			{
				$err = "please fill the all fields !";
			}
			else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$err = "Your email is not correct !";
			}
			else if (!preg_match("/^((0?[13578]|10|12)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[01]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))|(0?[2469]|11)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[0]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1})))$/m",$birth_date))
			{
				$err = "Your birth date is not correct!";
			}
			else
			{
				// update data of admin
				$admin_id = $this->data['userdata']['id'];
				$set['username'] = $username;
				$set['email'] = $email;
				$where = array('id'=>$admin_id,'user_status'=>1);
				/*
				echo "<pre>";
				print_r($this->data);
				echo "</pre>";
				*/
				$up = $this->cms_model->update('users',$set,$where);



				$a['birth_date'] = $birth_date;
				$a['sec_ques'] = $sec_ques;
				$a['ans_ques'] = $ans_ques;

				// delete all information from database by user_id
				foreach ($a as $k => $v) {

					$w['user_id'] = $admin_id;
					$w['user_option'] = $k;

					$del = $this->cms_model->delete('usersmeta',$w);
				}

				// insert all information to database
				$s = array();
				foreach ($a as $k => $v)
				{
					$d['user_id'] = $admin_id;
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
					$err = "Error, something was wrong !";
				}
				else
				{
					$ok = "Updated successfully";
				}

			}


		} // end if

		/*======================== Update password ============================*/
		if ($this->input->post('edit-pass'))
		{
			$msg = "msg2";

			$old_pass 	= trim(strip_tags($this->input->post('old-pass',TRUE)));
			$new_pass 	= trim(strip_tags($this->input->post('new-pass',TRUE)));
			$conf_pass 	= trim(strip_tags($this->input->post('conf-new-pass',TRUE)));

			if ($old_pass == '' or $new_pass == '' or $conf_pass == '')
			{
				$err = "Please insert all information !";
			}
			else if (!password_verify($old_pass,$this->data['userdata']['password']))
			{
				$err = "The <b>old password</b> isn't correct !";
			}
			else if ($new_pass != $conf_pass)
			{
				$err = "The two passwords aren't matched.";
			}
			else
			{
				$set['password'] = password_hash($new_pass,PASSWORD_DEFAULT);
				$where = array('user_token'=>$this->data['userdata']['user_token']);

				$up = $this->cms_model->update('users',$set,$where);

				if ($up)
				{
					$ok = "The password changed successfully.";
				}
				else
				{
					$err = "Error , something was wrong !!";
				}
			}

		} // end if

		if (isset($err) && $err != '')
		{
			$this->data[$msg] = "<div class='alert alert-warning'>".$err."</div>";
		}
		else if (isset($ok) && $ok != '')
		{
			$this->data[$msg] = "<div class='alert alert-success'>".$ok."</div>";
		}

		$this->load->view('templates/admin_header',$this->data);
		$this->load->view('pages/admin/profile',$this->data);
		$this->load->view('templates/admin_footer',$this->data);
	}

	public function login ($action='')
	{
		if ($this->session->admin_token != '')
		{
			redirect(base_url(config_item('admin_page_path')));
		}

		if ($action == "")
		{
			$this->data['title'] = 'Admin login page !';
			$page = "login";
			$this->data['msg'] = $this->cms_model->login('admin');
		}
		else if ($action == 'forget_pass')
		{
			$this->data['title'] = 'Recovery my account !';
			$page = "forget_pass";

			$this->data['msg'] = $this->cms_model->forget_pass('admin');
		}
		else if ($action == 'repass')
		{
			$this->data['title'] = 'Set a new password';
			$page = 'repass';

	        $t = ($this->input->get('t',TRUE) != '')? $this->input->get('t',TRUE) : $this->input->post('t',TRUE) ;
	        $code = trim(strip_tags($t));

	        if ($code == "")
	        {
	            show_404();
	        }
	        else
	        {
	            $this->data['t'] = $code;
	            $a = explode("--",decode($code,TRUE));
	            //print_r($a);

	            if (isset($a[1]) && (time() < $a[1] + get_config_item('restoration_time_account') * 3600))
	            {
	                $this->data['msg'] = $this->cms_model->repass($a[0],'admin');
	            }
	            else
	            {
	                $this->data['forb'] = "<div class='alert alert-danger'><i class='fa fa-lg fa-clock-o'></i> Sorry this link is not available anymore !</div>";
	            }
	        }

		}

		$this->load->view('templates/head_login_admin',$this->data);
		$this->load->view('pages/admin/'.$page,$this->data);
		$this->load->view('templates/footer',$this->data);

	}

	public function users ($var='',$page=1)
	{
		$this->data['title'] = "Users";

		$search = trim(strip_tags($this->input->get('q_user',TRUE)));
		$this->data['string'] = $search;

		$where = array('user_status !='=>1);

		$num = ($this->input->get('num') != '')? abs(intval($this->input->get('num'))) : 20 ; // number of users at one page

		$page = trim(intval($page));
		$start = ($page - 1) * $num;

		//$s2 = $this->cms_model->select('users',$where,array('id','desc'));
		$s2 = $this->cms_model->search($search,'users',array('username','email','user_token'),'');

		$total_users = $s2->num_rows();
		$this->data['total_users'] = $total_users;
		$this->data['page'] = $page;
		$this->data['all_pages'] = ceil($total_users / $num);

		if ($page <= 0 or $page > ceil($total_users / $num))
		{
			$this->data['ops'] = "Ops, No data found !";
		}
		else
		{
			//$s1 = $this->cms_model->select('users',$where,array('id','desc'),$num,$start);
			$s1 = $this->cms_model->search($search,'users',array('username','email','user_token'),'',array('id','desc'),$num,$start);

			//$num_rows = $s1->num_rows();
			$this->data['row'] = $s1->result_array();

			$url = base_url($this->data['page_path'])."/users/p/";
			$this->data['pagination'] = pagination($total_users,$num,$url);

			$s1->free_result();
		}
		$s2->free_result();

		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/users",$this->data);
		$this->load->view("templates/admin_footer",$this->data);

	}

	public function online ()
	{
		$s_online = $this->cms_model->select('online');
		$this->data['online'] = $s_online;

		$this->data['title'] = 'Online visitors';

		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/online",$this->data);
		$this->load->view("templates/admin_footer",$this->data);
	}

	public function u ($var='',$id='')
	{
		$id = intval($id);

		if ($var == '')
		{
			show_404();
		}
		else if ($var == "edit")
		{
			$this->data['title'] = "Edit My Profile";

			$w['id'] = $id;
			//$w['user_status !='] = 1;
			$sel = $this->cms_model->select('users',$w);

			if ($sel->num_rows() == 1)
			{
				$row = $sel->row_array();

				if ($row['user_status'] == 1)
				{
					$this->data['forb_msg'] = "Sorry, You can't edit admin data from here !";
				}
				else
				{
					$this->data['userInfo'] = $row;

					$sel = $this->cms_model->select('usersmeta',array('user_id'=>$row['id']));
					$r = $sel->result_array();

					foreach ($r as $k => $row)
					{
						$this->data['userInfo'][$row['user_option']] = $row['user_value'];
					}
				}
			}
			else
			{
				$this->data['forb_msg'] = "This user not found !";
			}
		}

		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/u",$this->data);
		$this->load->view("templates/admin_footer",$this->data);
	}

	public function languages($action = NULL)
	{
		if ($action == NULL)
		{
			$pagename = "Languages";
			$page = "languages";

			$r = $this->cms_model->select('languages');
			$this->data['result'] = $r->result_array();

		}
		else if ($action == 'add')
		{
			$pagename = "Add language";
			$page = 'add_lang';

			if ($this->input->post('add'))
			{
				$name = $this->input->post('name', true);
				$symbol = $this->input->post('symbol', true);
				$direction = intval($this->input->post('direction', true));

				if ($name == '' or $symbol == '')
				{
					$err = 'Please fill all the fields.';
				}
				else if (!preg_match("/^([a-zA-Z0-9_.\-]+)$/", $name))
				{
					$err = 'Oops, the language name is invalid, it\'s should be consists of these (a-z, A-Z, 0-9, -, _) characters';
				}
				else if (!preg_match("/^([a-zA-Z0-9_\-.]+)$/", $symbol))
				{
					$err = 'Oops, the language symbol is invalid, it\'s should be consists of these (a-z, A-Z, 0-9, -, _) characters';
				}
				else
				{
					$w = "name='{$name}' OR symbol='{$symbol}'";
					$s = $this->cms_model->select('languages', $w);

					if ($s->num_rows() > 0)
					{
						$err = 'Oops, this language is already used, please try another language.';
					}
					else
					{
						$langData['name'] = $name;
						$langData['symbol'] = $symbol;
						$langData['isRTL'] = $direction;

						$save = $this->cms_model->insert('languages', $langData);

						$name = strtolower($name);
						$languageFolder = str_ireplace('\\', '/', APPPATH."language/");
						mkdir($languageFolder.$name);

						if ($save && copyFolder($languageFolder.'tpls', $languageFolder.$name, true))
						{
							//$ok = 'Saved successfully.';
							header('location: '.base_url($this->data['page_path'].'/languages'));
							exit();
						}
						else
						{
							$err = 'Oops, Something wrong, please try again.';
						}
					}
				}
			}
		}
		else if ($action == 'edit')
		{
			$pagename = 'Edit language';
			$page = 'edit_lang';

			if ($this->input->post('edit'))
			{
				$symbol = $this->input->post('symbol', true);
				$direction = intval($this->input->post('direction', true));
				$status = intval($this->input->post('status', true));

				if ($symbol == '')
				{
					$err = 'Please fill all the fields.';
				}
				else if (!preg_match("/^([a-zA-Z0-9_\-.]+)$/", $symbol))
				{
					$err = 'Oops, the language symbol is invalid, it\'s should be consists of these (a-z, A-Z, 0-9, -, _) characters';
				}
				else
				{
					$w = "id=".intval($this->uri->segment(4));
					$s = $this->cms_model->select('languages', $w);
					$r = $s->row_array();

					$s2 = $this->cms_model->select('languages', ['symbol' => $symbol]);
					$s3 = $this->cms_model->select('languages', ['active' => 1]);


					if ($r['symbol'] != $symbol && $s2->num_rows() > 0)
					{
						$err = 'Oops, this language symbol is already used, please try to use another symbol.';
					}
					else if ($s3->num_rows() == 1 && $status == 0 && $r['active'] == 1)
					{
						$err = 'Oops, you can\'t disactivate the all languages from the website, you should at least to keep one language active.';
					}
					else
					{
						$langData['symbol'] = $symbol;
						$langData['isRTL'] = $direction;
						$langData['active'] = $status;
						$save = $this->cms_model->update('languages', $langData, ['id' => $r['id']]);

						if ($save)
						{
							//$ok = 'Saved successfully.';
							header('location: '.base_url($this->data['page_path'].'/languages'));
							exit();
						}
						else
						{
							$err = 'Oops, Something wrong, please try again.';
						}
					}
				}
			}

			$s = $this->cms_model->select('languages', ['id' => intval($this->uri->segment(4))]);

			if ($s->num_rows() == 0)
			{
				header('location: '.base_url($this->data['page_path'].'/languages'));
			}
			else
			{
				$this->data['result'] = $s->row_array();
			}
		}

		if (isset($err) && $err != '')
		{
			$this->data['msg'] = "<div class='alert alert-warning'><i class='fa fa-lg fa-info-circle'></i> ".$err."</div>";
		}
		else if (isset($ok) && $ok != '')
		{
			$this->data['msg'] = "<div class='alert alert-success'><i class='fa fa-lg fa-check'></i> ".$ok."</div>";
		}

		$this->data['title'] = $pagename;

		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/$page",$this->data);
		$this->load->view("templates/admin_footer",$this->data);
	}

	public function pages ($action="",$var="")
	{
		if ($action == '')
		{
			$pagename = 'Manage Pages';
			$page = 'pages_list';

			$select = $this->cms_model->select('pages');

			$this->data['pages'] = $select->result_array();

			$pageLangData = [];
			foreach ($this->data['pages'] as $row)
			{
				if ($row['lang_id'] == 0)
				{
					$pageLangData[] = 'All languages';
					continue;
				}

				$tmp_s = $this->cms_model->select('languages', ['id' => $row['lang_id']]);
				$pageLangData[] = $tmp_s->row_array()['name'];
				$tmp_s->free_result();
			}

			$this->data['pageLangData'] = $pageLangData;

			$select->free_result();
		}
		else if ($action == 'add')
		{
			$pagename = 'Add pages';
			$page = 'add_page';

			if ($this->input->post('add',TRUE))
			{
				$title 		= trim(strip_tags($this->input->post('title',TRUE)));
				$slug		= trim(strip_tags($this->input->post('slug',TRUE)));
				$lang_id	= intval($this->input->post('lang-id',TRUE));
				$keywords	= trim(strip_tags($this->input->post('keywords',TRUE)));
				$desc		= trim(strip_tags($this->input->post('desc',TRUE)));
				$published	= intval($this->input->post('published',TRUE));
				$header 	= intval($this->input->post('header',TRUE));
				$footer 	= intval($this->input->post('footer',TRUE));
				$content	= trim($this->input->post('content',TRUE));

				if ($title == '' or $slug == '')
				{
					$err = "Please add a <b>title</b> and a <b>slug</b> of a page.";
				}
				else if (!preg_match("/^([a-zA-Z0-9_-]+)$/",$slug))
				{
					$err = "the <b>slug</b> is not correct, it has a forbidden characters";
				}
				else
				{
					$where['slug']	= $slug;
					$where['lang_id'] = $lang_id;
					$s = $this->cms_model->select('pages',$where);

					if ($s->num_rows() == 1)
					{
						$err = "Oops, this <b>slug</b> is already used, please try another one.";
					}
					else
					{
						$d['title'] 		= $title;
						$d['slug'] 			= $slug;
						$d['lang_id'] 		= $lang_id;
						$d['keywords']		= $keywords;
						$d['description']	= $desc;
						$d['published'] 	= $published;
						$d['show_header']	= $header;
						$d['show_footer']	= $footer;
						$d['content'] 		= $content;
						$d['created']		= time();
						$d['modified']		= time();

						$insert = $this->cms_model->insert('pages',$d);

						if ($insert)
						{
							$s->free_result();
							header('location: '.base_url($this->data['page_path'].'/pages'));
							//$ok = "the page was added successfully";
							exit();
						}
					}

					$s->free_result();
				}

			}
		}
		else if ($action == 'edit')
		{
			$pagename = "Edit page";
			$page = "edit_pages";

			$id = intval($var);

			$w['id'] = $id;
			$s = $this->cms_model->select('pages',$w);

			if ($s->num_rows() == 1)
			{
				$this->data['pagedata'] = $s->row_array();
			}
			else
			{
				$err = "Page not Found!";
			}
			$s->free_result();
		}

		if (isset($err) && $err != '')
		{
			$this->data['msg'] = "<div class='alert alert-warning'><i class='fa fa-lg fa-info-circle'></i> ".$err."</div>";
		}
		else if (isset($ok) && $ok != '')
		{
			$this->data['msg'] = "<div class='alert alert-success'><i class='fa fa-lg fa-check'></i> ".$ok."</div>";
		}

		$this->data['title'] = $pagename;

		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/$page",$this->data);
		$this->load->view("templates/admin_footer",$this->data);
	}

	public function demo ($id='')
	{
		$id = intval($id);

		$w['id'] = $id;
		$sel = $this->cms_model->select('pages',$w);

		if ($sel->num_rows() == 1)
		{
			$row = $sel->row_array();
			$this->data['pagedata'] = $row;

			$this->data['title'] = $row['title'];
			$content = $this->data['pagedata']['content'];
			$this->data['page_content'] = do_filter('page_content', $content);

			$this->load->view("templates/header",$this->data);
			$this->load->view("pages/admin/page_demo",$this->data);
			$this->load->view("templates/footer",$this->data);
		}
		else
		{
			show_404();
		}

		$sel->free_result();
	}


	public function ajax ()
	{

		/*========================= Edit config (settings) of the website ===========================*/

		if ($this->input->post('tab'))
		{
			$a =  array();

			if ($this->input->post('tab') == 1)
			{
				$a['show_logo'] 			= intval($this->input->post('show_logo',TRUE));
				$a['sitename'] 				= trim(strip_tags($this->input->post('site_name',TRUE)));
				$a['keywords'] 				= trim(strip_tags($this->input->post('keywords',TRUE)));
				$a['description'] 			= trim(strip_tags($this->input->post('desc',TRUE)));
				$a['default_language'] 			= trim(intval($this->input->post('default_lang',TRUE)));
				$a['siteemail'] 			= trim(strip_tags($this->input->post('support-email',TRUE)));
				$a['siteclose'] 			= trim(intval($this->input->post('status_site',TRUE)));
				$a['shutdown_msg'] 			= $this->input->post('msg_closed_site',TRUE);
				$a['tracking_code'] 		= $this->input->post('analytics_code',FALSE);
				$a['go_head_code'] 			= $this->input->post('go_head_code',FALSE);
				$a['default_timezone'] 		= trim(strip_tags($this->input->post('default_timezone',TRUE)));
				$a['time_format'] 			= strip_tags($this->input->post('time_format',TRUE));

			}
			else if ($this->input->post('tab') == 2)
			{
				$a['registration_status'] 	= intval($this->input->post('registration_status',TRUE));
				$a['shutdown_msg_register'] = strip_tags($this->input->post('shutdown_msg_register',TRUE));
				$a['user_delete_account'] 	= intval($this->input->post('account_status',TRUE));
				$a['notes_delete_account'] 	= trim($this->input->post('notes_delete_account',TRUE));
			}
			else if ($this->input->post('tab') == 3)
			{
				$a['ad_728x90'] 			= $this->input->post('ad_728x90',FALSE);
				$a['ad_300x250'] 			= $this->input->post('ad_300x250',FALSE);
				$a['ad_300x600'] 			= $this->input->post('ad_300x600',FALSE);
				$a['ad_autosize'] 			= $this->input->post('ad_autosize',FALSE);
				$a['ads_status_on_accounts'] = abs(intval($this->input->post('ads_status_on_accounts',TRUE)));
				$a['ads_status'] 			= abs(intval($this->input->post('ads_status',TRUE)));
				$a['admin_pub'] 			= strip_tags($this->input->post('pub',TRUE));
				$a['admin_channel'] 		= trim(intval($this->input->post('channel',TRUE)));
				$a['countdown'] 			= trim(abs(intval($this->input->post('countdown',TRUE))));
				$a['just_show_admin_ads'] 	= abs(intval($this->input->post('just_show_admin_ads',TRUE)));
				$a['just_show_users_ads'] 	= abs(intval($this->input->post('just_show_users_ads',TRUE)));
			}
			else if ($this->input->post('tab') == 4)
			{
				$a['cookie_expire'] 		= (intval($this->input->post('expir_time',TRUE)) < 1)? 1*3600*24 : intval($this->input->post('expir_time',TRUE))*3600*24 ;
				$a['cookie_name'] 			= (preg_match("/^([a-zA-Z0-9_-])+$/",$this->input->post('cookie_name',TRUE)))? mb_substr($this->input->post('cookie_name',TRUE),0,50,'UTF-8') : "ABC" ;
				$a['restoration_time_account'] = (intval($this->input->post('rest_time',TRUE)) < 1)? 1 : intval($this->input->post('rest_time',TRUE)) ;
				$a['secret_key'] 			= trim(strip_tags($this->input->post('secret_key',TRUE)));
				$a['public_key'] 			= trim(strip_tags($this->input->post('public_key',TRUE)));
				$a['recaptcha_status'] 		= intval($this->input->post('recaptcha_status',TRUE));
			}
			else if ($this->input->post('tab') == 5)
			{
				$a['email_method'] 		= trim(strip_tags($this->input->post('email_method',TRUE)));
				$a['email_from'] 		= trim(strip_tags($this->input->post('email_from',TRUE)));
				$a['SMTP_Host'] 		= trim(strip_tags($this->input->post('SMTP_Host',TRUE)));
				$a['SMTP_Port'] 		= trim(strip_tags($this->input->post('SMTP_Port',TRUE)));
				$a['SMTP_User'] 		= trim(strip_tags($this->input->post('SMTP_User',TRUE)));
				$a['SMTP_Pass'] 		= trim(strip_tags($this->input->post('SMTP_Pass',TRUE)));
				$a['mail_encription'] 	= trim(strip_tags($this->input->post('mail_encription',TRUE)));
				$a['allow_SSL_Insecure_mode'] 	= intval($this->input->post('allow_SSL_Insecure_mode',TRUE));
			}
			else if ($this->input->post('tab') == 6)
			{
				$a['social_media_facebook'] 	= trim(strip_tags($this->input->post('social_media_facebook',TRUE)));
				$a['social_media_twitter'] 		= trim(strip_tags($this->input->post('social_media_twitter',TRUE)));
				$a['social_media_youtube'] 		= trim(strip_tags($this->input->post('social_media_youtube',TRUE)));
				$a['social_media_github'] 		= trim(strip_tags($this->input->post('social_media_github',TRUE)));
				$a['social_media_linkedin'] 	= trim(strip_tags($this->input->post('social_media_linkedin',TRUE)));
				$a['social_media_reddit'] 		= trim(strip_tags($this->input->post('social_media_reddit',TRUE)));
				$a['social_media_pinterest'] 	= trim(strip_tags($this->input->post('social_media_pinterest',TRUE)));
				$a['social_media_tumblr'] 		= trim(strip_tags($this->input->post('social_media_tumblr',TRUE)));
				$a['social_media_instagram'] 		= trim(strip_tags($this->input->post('social_media_instagram',TRUE)));
			}
			else if ($this->input->post('tab') == 10)
			{
				$a['showFakeNumbers'] 		= trim(abs(intval($this->input->post('showFakeNumbers',TRUE))));
				$a['fakeViews'] 			= trim(abs(intval($this->input->post('fakeViews',TRUE))));
				$a['fakeUsers'] 			= trim(abs(intval($this->input->post('fakeUsers',TRUE))));
				$a['fakeLinks'] 			= trim(abs(intval($this->input->post('fakeLinks',TRUE))));
				$a['bad_urls'] 				= trim(strip_tags($this->input->post('bad_urls',TRUE)));
				$a['packages_domains'] 		= trim(strip_tags($this->input->post('packages_domains',TRUE)));
			}



			$e = array();
			foreach ($a as $k => $v)
			{
				$set['option_name'] = $k;
				$set['option_value'] = $v;

				$where = array(
						'option_name' => $k
					);

				$up = $this->cms_model->update('settings',$set,$where);

				if ($up)
				{
					array_push($e,1);
				}
				else
				{
					array_push($e,0);
				}
			}


			if (!in_array(0,$e))
			{
				/*
				echo '<pre>';
				print_r($a);
				echo '</pre>';
				*/
				$ok = 'Saved successfully.';
			}
			else
			{
				$err = 'Error update !';
			}
		} // end post submit

		/*=================== show messages ===================*/

		if ($this->input->post('uploadImg'))
		{
			if ($this->input->post('type') == 'icon')
			{
				$file_name = "favicon.png";
				$addType = "|ico";
				$input_name = "icon";
				$height = 72;
				$width = 72;
			}
			else
			{
				$file_name = "logo.png";
				$addType = "";
				$input_name = "logo";
				$height = 100;
				$width = 0;
			}

	        $config['upload_path']          = './img/';
	        $config['allowed_types']        = 'gif|jpg|png'.$addType;
	        $config['max_size']             = 1024*1; // 1 MB
	        $config['max_width']            = 1024;
	        $config['max_height']           = 1024;
	        $config['file_name']			= $file_name;
	        $config['overwrite'] 			= TRUE;

	        $this->load->library('upload',$config);

			if (!$this->upload->do_upload($input_name))
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
			    $conf['source_image'] 	= './img/'.$img_data['file_name'];
			    $conf['create_thumb'] 	= FALSE;
			    $conf['maintain_ratio'] = TRUE;
			    $conf['height']   		= $height; // <==
			    $conf['width']     		= $width; // auto <==
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
			    	$ok = "The image has been uploaded successfully.";
			    }
			}
		}

		/*======================== Edit user data at cpanel ==========================*/

		if ($this->input->post('edit-profile'))
		{
			$userId = abs(intval($this->input->post('user_id',TRUE)));

			$where['id'] = $userId;
			$s = $this->cms_model->select('users',$where);

			if ($s->num_rows() == 1)
			{
				$row = $s->row_array();
				$old_email = $row['email'];
			}
			else
			{
				$err = "Oops, The user token is not correct!";
			}

			$s->free_result();

	        $username   = trim(strip_tags($this->input->post('username',TRUE)));
	        $email 		= trim(strip_tags($this->input->post('email',TRUE)));
	        $status 	= intval($this->input->post('status',TRUE));
	        $banned_msg = trim($this->input->post('banned_msg',TRUE));
	        $gender     = intval($this->input->post('gender',TRUE));
	        $country	= intval($this->input->post('country',TRUE));
	        $birth_day  = trim(strip_tags($this->input->post('birth-day',TRUE)));
	        $sec_ques   = trim(strip_tags($this->input->post('sec-que',TRUE)));
	        $ans_ques   = trim(strip_tags($this->input->post('ans-que',TRUE)));

	        $pub 		= strip_tags($this->input->post('pub',TRUE));
	        $channel 	= intval($this->input->post('channel',TRUE));

	        if ($username == '')
	        {
	            $err = "Oops, insert the <b>username</b>";
	        }
	        else if (mb_strlen($username) < 4)
	        {
	            $err = "Oops, the <b>username</b> is too short.";
	        }
	        else if (mb_strlen($username) > 50)
	        {
	            $err = "Oops, the <b>username</b> is too long.";
	        }
			else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
			{
				$err = "Oops, the <b>email</b> is not correct!";
			}
			else if ($this->cms_model->is_registered($email,array('email !='=>$old_email)))
			{
				$err = "Oops, this <b>email</b> is already used!";
			}
			/*
	        else if ($gender == '')
	        {
	            $err = "please, select the <b>gender</b> of user";
	        }
	        */
	        else if ($birth_day != '' && !preg_match("/^((0?[13578]|10|12)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[01]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))|(0?[2469]|11)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[0]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1})))$/m",$birth_day))
	        {
	            $err = "Oops, the <b>birth day</b> isn't correct !";
	        }
			else if ($pub != '' && !preg_match("/^(pub-)[0-9]{16}$/",$pub))
			{
				$err = "Oops, the <b>PUB</b> is not correct !";
			}
	        else
	        {
	            $user_id = $userId;

	            $set['username'] 		= $username;
	            $set['email']		 	= $email;
	            $set['gender']   		= $gender; // 1 = male ||| 2 = female
	           	$set['account_status']	= $status;

	            $w['id'] = $user_id;
	            $up = $this->cms_model->update('users',$set,$w);

	            $a['user_pub'] 		= $pub;
	            $a['user_channel'] 	= $channel;
	            $a['country'] 		= $country;
	            $a['birth_date'] 	= $birth_day;
	            $a['sec_ques'] 		= $sec_ques;
	            $a['ans_ques'] 		= $ans_ques;
	            $a['banned_msg'] 	= $banned_msg;

	            // delete all information from database by user_id
	            foreach ($a as $k => $v) {
	                $w = array();
	                $w['user_id'] = $user_id;
	                $w['user_option'] = $k;

	                $del = $this->cms_model->delete('usersmeta',$w);
	            }

	            // insert all information to database
	            $s = array();
	            foreach ($a as $k => $v)
	            {
	            	$d = array();
	                $d['user_id'] = $user_id;
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
	                $err = "Sorry, Something was wrong !";
	            }
	            else
	            {
	                $ok = "Saved successfully.";
	            }
	        }

		} // end of edit profile

		/*========================= Delete users ===========================*/

		if ($this->input->post('deleteUser') == 1)
		{
			$id = intval($this->input->post('id',TRUE));

			$where['id'] = $id;
			$s = $this->cms_model->select('users',$where);

			if ($s->num_rows() == 1)
			{
				$row = $s->row_array();

				if ($row['user_status'] == 1)
				{
					echo "Oops, You Can't delete the Admin";
				}
				else
				{
					$w['id'] = $id;
					$d = $this->cms_model->delete('users',$w);

					$wr['user_id'] = $row['id'];
					$d2 = $this->cms_model->delete('usersmeta',$wr);

					if ($d && $d2)
					{
						echo "Deleted successfully :)";
					}
					else
					{
						echo "Oops, Something was wrong!";
					}
				}
			}
			else
			{
				echo "Oops, The user not found (ID=".$id.") !";
			}

			$s->free_result();

		} // end of function

		/*================== Delete profile image =================*/

		if ($this->input->post('delete_image'))
		{
			$token = $this->input->post('token',TRUE);

			if (delete_profile_img($token))
			{
				echo "Deleted successfully.";
			}
			else
			{
				echo "Something was wrong !";
			}
		}

		/*================== Edit data page =================*/

		if ($this->input->post('edit-page'))
		{
			$title 		= trim(strip_tags($this->input->post('title',TRUE)));
			$slug		= trim(strip_tags($this->input->post('slug',TRUE)));
			$lang_id	= intval($this->input->post('lang-id',TRUE));
			$keywords 	= trim(strip_tags($this->input->post('keywords',TRUE)));
			$desc 		= trim(strip_tags($this->input->post('desc',TRUE)));
			$published 	= intval($this->input->post('published',TRUE));
			$header 	= intval($this->input->post('header',TRUE));
			$footer 	= intval($this->input->post('footer',TRUE));
			$content 	= trim($this->input->post('content',TRUE));
			$id 		= intval($this->input->post('id',TRUE));

			$where['id'] = $id;
			$s = $this->cms_model->select('pages',$where);

			if ($s->num_rows() == 1)
			{
				$row = $s->row_array();

				if ($row['uneditable'] == 1)
				{
					$slug = $row['slug'];
				}

				if ($title == '')
				{
					$err = "Please insert a <b>title</b> !";
				}
				if ($slug == '')
				{
					$err = "Please insert a <b>slug</b> !";
				}
				else if (!preg_match("/^([a-zA-Z0-9_-]+)$/",$slug))
				{
					$err = "the <b>slug</b> is not correct, it has a forbidden characters";
				}
				else
				{
					$wh['slug']	= $slug;
					$wh['lang_id'] = $lang_id;
					$s2 = $this->cms_model->select('pages',$wh);

					if ($row['lang_id'] != $lang_id && $s2->num_rows() > 0)
					{
						$err = "Oops, this <b>slug</b> is already used at this language that you choosed.";
					}
					else
					{
						$set['title'] 		= $title;
						$set['slug'] 		= $slug;
						$set['lang_id']		= $lang_id;
						$set['keywords'] 	= $keywords;
						$set['description'] = $desc;
						$set['published'] 	= $published;
						$set['show_header'] = $header;
						$set['show_footer'] = $footer;
						$set['content'] 	= $content;
						$set['modified']	= time();

						$w['id'] = $id;
						$update = $this->cms_model->update('pages',$set,$w);

						if ($update)
						{
							$ok = "Updated successfully.";
						}
						else
						{
							$err = "Something was wrong!";
						}
					}
					$s2->free_result();
				}
			}
			$s->free_result();
		}

		/*================== Delete page =================*/

		if ($this->input->post('deletePage'))
		{
			$id = intval($this->input->post('id',TRUE));

			$w['id'] = $id;
			$w['uneditable'] = 0;
			$del = $this->cms_model->delete('pages',$w);

			if ($del)
			{
				echo "Deleted successfully.";
			}
			else
			{
				echo "Oops, Something was wrong !";
			}
		}

		/*============= Delete save WithdrowRequest status ============*/

		if ($this->input->post('saveWithdrowRequestStatus'))
		{
			$id = intval($this->input->post('id', TRUE));
			$status = intval($this->input->post('status_id', TRUE));

			$updated = $this->db->set(['status' => $status])->where(['id' => $id])->update('withdraw_reqs');

			if ($updated)
			{
				echo "Status updated successfully.";
			}
			else
			{
				echo "Oops, Something was wrong !";
			}
		}

		/*================== Delete withdrawal request =================*/

		if ($this->input->post('deleteWithdrowRequest'))
		{
			$id = intval($this->input->post('id', TRUE));
			$del = $this->db->delete('withdraw_reqs', ['id' => $id]);

			if ($del)
			{
				echo "Deleted successfully.";
			}
			else
			{
				echo "Oops, Something was wrong !";
			}
		}

		/*================== Delete withdrawal method =================*/

		if ($this->input->post('deleteWithdrawalMethod'))
		{
			$id = intval($this->input->post('id', TRUE));
			$del = $this->db->delete('withdrawal_methods', ['id' => $id]);

			if ($del)
			{
				echo "Deleted successfully.";
			}
			else
			{
				echo "Oops, Something was wrong !";
			}
		}

		/*================== edit link data ==============*/

		if ($this->input->post('link_id'))
		{
			$slug 		= trim(strip_tags($this->input->post('slug')));
			$new_slug 	= trim(strip_tags($this->input->post('new_slug')));
			$link_id 	= abs(intval($this->input->post('link_id')));
			$title 		= trim(strip_tags($this->input->post('title')));
			$org_url 	= trim(strip_tags($this->input->post('origin_url')));
			$status 	= trim(strip_tags($this->input->post('status')));

			$w_s['slug'] = $new_slug;
			$s = $this->cms_model->select('links', $w_s);

			if ($new_slug != $slug && $s->num_rows() > 0)
			{
				$err = "Oops, the <b>slug</b> is already used !";
			}
			else
			{
				$set['title'] 	= $title;
				$set['url'] 	= encode($org_url);
				$set['slug'] 	= $new_slug;
				$set['status'] 	= $status;
				$set['modified']= time();

				$w['id'] = $link_id;

				$up = $this->cms_model->update('links', $set, $w);

				if ($up)
				{
					$ok = "Saved successfully.";
				}
				else
				{
					$err = "Oops, Something was wrong !";
				}
			}
		}

		/*================== delete links ==================*/

		if ($this->input->post('deleteLink') == 1)
		{
			$id = abs(intval($this->input->post('id')));

			$w['id'] = $id;
			$del = $this->cms_model->delete('links',$w);

			if ($del)
			{
				echo "Delete successfully.";
			}
			else
			{
				echo "Oops, Something was wrong !";
			}
		}

		/*================== delete language ==================*/

		if ($this->input->post('deleteLang') == 1)
		{
			$id = abs(intval($this->input->post('id')));

			$w['id'] = $id;
			$w['undeletable'] = 0;

			$s = $this->cms_model->select('languages',$w);
			$result = $s->row_array();


			$del = $this->cms_model->delete('languages',$w);

			if ($s->num_rows() && $del)
			{
				$path = APPPATH.'language/'.strtolower($result['name']);

				if (is_dir($path))
				{
					if (deleteFolder($path, true))
						echo "Deleted successfully.";
					else
						echo "Oops, Something is wrong !";
				}
				else
				{
					echo "Oops, Something is wrong !";
				}
			}
			else
			{
				echo "Oops, Something is wrong !";
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

	} // end ajax function


	public function links ($action='',$page='')
	{
		if($action == "" || $action == 'p')
		{
			if ($this->input->get())
			{
				$search = trim(strip_tags($this->input->get('search',TRUE)));
				$this->data['search'] = $search;
				$col = array('title','slug');
			}

			$links_per_page = 20;
			$page = intval($page);

			if (!isset($search))
			{
				$s = $this->cms_model->select('links','',array('id','DESC'));
			}
			else
			{
				// $str,$table,$col,$where='',$orderBy='',$length='',$start=''
				$s = $this->cms_model->search($search,'links',$col,'',array('id','DESC'));
			}


			$all_pages = ceil($s->num_rows() / $links_per_page);

			if ($page < 1 or $page > $all_pages)
			{
				$page = 1;
			}

			$start = ($page-1)*$links_per_page;

			if (!isset($search))
			{
				$s2 = $this->cms_model->select('links','',array('id','DESC'),$links_per_page,$start);
			}
			else
			{
				// $str,$table,$col,$where='',$orderBy='',$length='',$start=''
				$s2 = $this->cms_model->search($search,'links',$col,'',array('id','DESC'),$links_per_page,$start);
			}

			$this->data['links'] = $s2;


			// ===========================
			$this->data['all_items'] = $s->num_rows();
			$this->data['links_per_page'] = $links_per_page;
			$this->data['page'] = $page;
			$this->data['all_pages'] = $all_pages;


			$this->data['title'] = 'All links';

			$this->load->view("templates/admin_header",$this->data);
			$this->load->view("pages/admin/links",$this->data);
			$this->load->view("templates/admin_footer",$this->data);

			$s->free_result();
			$s2->free_result();
		}
		else if ($action == "edit")
		{
			$slug = trim(strip_tags($page));

			$w['slug'] = $slug;
			$s = $this->cms_model->select('links',$w);
			$this->data['s'] = $s;

			$row = $s->row_array();

			$w_user['id'] = $row['user_id'];
			$s_user = $this->cms_model->select('users',$w_user);

			$this->data['user_info'] = $s_user;

			$this->data['title'] = 'Edit link';

			$this->load->view("templates/admin_header",$this->data);
			$this->load->view("pages/admin/edit_link",$this->data);
			$this->load->view("templates/admin_footer",$this->data);

			$s->free_result();
			$s_user->free_result();
		}

	}

	public function publisher_rates($action='')
	{
		if ($this->input->post())
		{
			$posted_countries = $this->input->post('countries', true);
			$world_wide = (float)$this->input->post('world_wide', true);

			$this->db->set([
				'option_value' => $world_wide,
			])->where([
				'option_name' => 'world_wide',
			])->update('settings');

			//print_r($posted_countries);
			foreach($posted_countries as $country_id => $new_price)
			{
				$this->db->set(['price' => $new_price]);
				$this->db->where(['country_id' => $country_id]);
				$this->db->update('publisher_rates');

				set_message('Saved successfully.', 'success');
				redirect($this->data['page_path'].'/publisher_rates', 'refresh');
			}
		}

		$this->data['title'] = 'Publisher Rates';

		$countries = $this->db->select('*')->from('countries')->join('publisher_rates', 'countries.id = publisher_rates.country_id')->get()->result();
		$this->data['countries'] = $countries;
		$this->data['world_wide'] = (float)get_config_item('world_wide');

		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/publisher_rates",$this->data);
		$this->load->view("templates/admin_footer",$this->data);
	}


	public function withdrawal_methods($action='', $payment_method_id=0)
	{
		$this->data['payment_methods'] = [];
		$view_page = 'withdrawal_methods';
		$payment_method_id = intval($payment_method_id);

		if ($action == '')
		{
			$this->data['title'] = 'Withdrawal Methods';
			$this->data['withdrawal_methods'] = $this->db->select('*')->from('withdrawal_methods')->get()->result_object();
		}
		else if ($action == 'add')
		{
			$this->data['title'] = 'Add Withdrawal Method';
			$view_page = 'add_withdrawal_method';

			if ($this->input->post('add'))
			{
				$name = $this->input->post('name', true);
				$min_amount = $this->input->post('min_amount', true);
				$status = intval($this->input->post('status', true));
				$desc = $this->input->post('desc', true);

				$this->db->set([
					'name' => $name,
					'min_amount' => $min_amount,
					'status' => $status,
					'description' => $desc,
				])->insert('withdrawal_methods');

				set_message('Added successfully.', 'success');
				redirect("{$this->data['page_path']}/withdrawal_methods", 'refresh');
			}
		}
		else if ($action == 'edit')
		{
			$view_page = 'edit_withdrawal_method';
			$this->data['title'] = 'Edit Withdrawal Method';
			$withdrawal_methods = $this->db->select('*')->where(['id' => $payment_method_id])->get('withdrawal_methods');

			//print_r($withdrawal_methods->result_object());

			if ($this->input->post())
			{
				$name = $this->input->post('name', true);
				$min_amount = $this->input->post('min_amount', true);
				$status = intval($this->input->post('status', true));
				$desc = $this->input->post('desc', true);

				$this->db->set([
					'name' => $name,
					'min_amount' => $min_amount,
					'status' => $status,
					'description' => $desc,
				])->where([
					'id' => $payment_method_id
				])->update('withdrawal_methods');

				set_message('Updated successfully.', 'success');
				redirect("{$this->data['page_path']}/withdrawal_methods", 'refresh');
			}

			if ($withdrawal_methods->num_rows())
			{
				$this->data['method'] = $withdrawal_methods->result_object()[0];
			}
			else
			{
				set_message('Payment method not found.', 'warning');
				redirect("{$this->data['page_path']}/withdrawal_methods", 'refresh');
			}
		}

		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/{$view_page}",$this->data);
		$this->load->view("templates/admin_footer",$this->data);
	}

	public function withdrawal_reqs($action='', $withdraw_reqs=0)
	{
		$this->data['withdraw_reqs'] = [];
		$view_page = 'withdrawal_reqs';
		$withdraw_reqs = intval($withdraw_reqs);

		if ($action == '')
		{
			$this->data['title'] = 'Withdrawal Requests';
			$this->data['result'] = $this->db->select('*, withdraw_reqs.status AS status, withdrawal_methods.status AS withdrawal_method_status, withdraw_reqs.id AS id, withdraw_reqs.withdrawal_account as withdrawal_account')
									->from('withdraw_reqs')
									->join('users', 'users.id = withdraw_reqs.user_id')
									->join('withdrawal_methods', 'withdraw_reqs.withdrawal_method_id = withdrawal_methods.id')
									->get()
									->result_object();

		}
		else if ($action == 'edit')
		{
			$this->data['title'] = 'Edit Withdraw Request';
		}


		$this->load->view("templates/admin_header",$this->data);
		$this->load->view("pages/admin/{$view_page}",$this->data);
		$this->load->view("templates/admin_footer",$this->data);
	}
}


?>
