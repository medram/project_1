<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );
@session_start();

class Go extends MY_controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->data['page_path'] = strtolower(__CLASS__);
	}

	public function index ($slug='')
	{
		$this->load->library('session');
		$slug = (preg_match("/^([a-zA-Z0-9_-]{1,50})$/",$slug))? trim(strip_tags($slug)) : '' ;

		$page = $this->uri->segment(1);

		//========================= Deny access to (link) page ===========================
		if ($page == 'go')
		{
			$userdata = [
				'done' 	=> true,
				'slug' 	=> $slug
			];

			//$this->session->set_userdata('go_page', $userdata);
			$_SESSION['go_page'] = $userdata;
		}
		
		$go_page = isset($_SESSION['go_page'])? $_SESSION['go_page'] : [];
		//$go_page = $this->session->has_userdata('go_page')? $this->session->userdata('go_page') : [];

		if ($page == 'link')
		{
			unset($_SESSION['go_page']);
			if (!$go_page['done'])
			{
				//$this->session->unset_userdata('go_page');
				redirect(base_url($this->data['page_path'].'/'.$slug));
			}
			else if ($go_page['done'] && $go_page['slug'] != $slug)
			{
				#$sent_slug = strip_tags($this->input->post('slug',TRUE));
				#$sent_slug = strip_tags($this->input->post('slug',TRUE));
				//$this->session->unset_userdata('go_page');
				//unset($_SESSION['go_page']);
				redirect(base_url($this->data['page_path'].'/'.$slug));
			}
		}
		





		if ($slug != '')
		{
			$w['slug'] = $slug;
			$s = $this->cms_model->select('links',$w);

			if ($s->num_rows() == 1)
			{
				$linkdata = $s->row_array();

				$this->load->library('user_agent');

				if ($this->agent->is_mobile())
				{
					$linkdata['is_mobile'] = 'yes';
				}
				else
				{
					$linkdata['is_mobile'] = 'no';
				}

				/*====================== get content of the page ======================*/

				$where['id'] = $linkdata['user_id'];
				$s_user = $this->cms_model->select('users',$where);

				//$s_user->row_array();

				foreach ($s_user->row_array() as $k => $v)
				{
					$linkdata[$k] = $v;
				}

				$w2['user_id'] = $linkdata['id'];
				$s2 = $this->cms_model->select('usersmeta',$w2);

				if ($s2->num_rows() > 0)
				{
					foreach ($s2->result_array() as $row)
					{
						$linkdata[$row['user_option']] = $row['user_value'];
					}
				}

				$linkdata['showReCaptcha'] = ($this->uri->segment(1) == 'link');

				$this->data['linkdata'] = $linkdata;
				$this->data['meta']['keywords'] = implode(",",explode(" ",$linkdata['title']));
				$this->data['meta']['description'] = $linkdata['title'];
				$this->data['title'] = $linkdata['title'];
			
				$s_user->free_result();
				$s2->free_result();

				/*==================== get some data for page ========================*/

				// $str,$table,$col,$where='',$orderBy='',$length='',$start=''
				$q = $this->cms_model->search($linkdata['title'],'links',array('title'),'',array('id','DESC'),10,0);

				$this->data['otherLinks'] = $q;

				/*==================== last Links Of User ============================*/

				$wh['user_id'] = $linkdata['user_id'];
				
				$q2 = $this->cms_model->select('links',$wh,array('id','DESC'),10,0);

				$this->data['lastLinksOfUser'] = $q2;

				/*======================== option when $t net exists ============================*/

				/*============= views of links ===========*/

				if ($linkdata['status'] == 1 && !isset($t)) // link active
				{
					$set3['views'] = $linkdata['views']+1;
				}
				else
				{
					$set3['admin_views'] = $linkdata['admin_views']+1;	
				}
				
				$w3['slug'] = $slug;
				$up1 = $this->cms_model->update('links',$set3,$w3);

				/*============= statistics link ===========*/


				
				if (get_config_item('just_show_users_ads') == 1)
				{
					$user_id = $linkdata['user_id'];
				}
				else if (get_config_item('just_show_admin_ads') == 1)
				{
					$user_id = "----";
				}
				else if ($linkdata['status'] == 1 && !isset($t)) // link active
				{
					$user_id = $linkdata['user_id'];
				}
				else // link banned or $t exists
				{
					$user_id = "----";
				}

				$date = date("Y-m-d",time());

				$w_st['user_id'] = $user_id;
				$w_st['date'] = $date;
				$s_st = $this->cms_model->select('statistics',$w_st);

				if ($s_st->num_rows() == 0)
				{
					// insert
					$d_st['user_id'] = $user_id;
					$d_st['date'] = $date;
					$d_st['views'] = 1;
					
					$in = $this->cms_model->insert('statistics',$d_st);
				}
				else
				{
					$row_st = $s_st->row_array();
					// update
					$set_st['views'] = $row_st['views']+1;
					$w_up_st['user_id'] = $user_id;
					$w_up_st['date'] = $date;
					$up = $this->cms_model->update('statistics',$set_st,$w_up_st);
				}

				$d_w['user_id'] = $user_id;
				$d_w['date <'] = date("Y-m-d",strtotime($date)-30*24*3600);
				$del = $this->cms_model->delete('statistics',$d_w);

				$s_st->free_result();

			}
			else
			{
				show_404();
			}
			
		}
		else
		{
			show_404();
		}

		$this->load->view('templates/go_header',$this->data);
		$this->load->view('pages/go',$this->data);
		$this->load->view('templates/footer',$this->data);

		$s->free_result();

	}

	public function ajax ()
	{
		if ($this->input->post('get_link') == 'yes')
		{
			if (!recaptcha())
			{
				$err = langLine('notifAccount.go.span.1', false);
			}
			else
			{
				$slug = trim(strip_tags($this->input->post('slug')));
				
				$w['slug'] = $slug;
				$s = $this->cms_model->select('links',$w);

				if ($s->num_rows() == 1)
				{
					$row = $s->row_array();

					$ok = "<a style='text-decoration: none;' href='".decode($row['url'])."' ><button class='btn btn-success btn-block' style='text-align: center;height: 70px;font-size: 20px;'><i class='fa fa-link'></i> ".langLine('notifAccount.go.span.2', false)."</button></a>";
				}
				else
				{
					$err = langLine('notifAccount.go.span.3', false);
				}

				$s->free_result();

			}
	
			$req = "
			<script>
			setTimeout(function (){
				grecaptcha.reset(recaptcha1);
			},1000);
			</script>
			";

			if (isset($err))
			{
				echo $err;
				echo $req;
			}
			else if (isset($ok))
			{
				echo $ok;
				echo $req;
				echo "
				<script>
				$('#getLink').slideUp(function (){
					$(this).html('');
				});
				</script>
				";
			}

		}
	}
}

?>