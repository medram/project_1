<?php

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
		$slug = (preg_match("/^([a-zA-Z0-9_-]{1,50})$/",$slug))? trim(strip_tags($slug)) : '' ;

		if ($this->input->get('t'))
		{
			$t = intval($this->input->get('t',TRUE));
			
			if (abs(time() - $t) < 5*60)
			{
				$this->data['t'] = $t;
			}
			else
			{
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
				$err = 'عذرا، كود الكابتشا خاطأ، اعد المحاولة';
			}
			else
			{
				$slug = trim(strip_tags($this->input->post('slug')));
				
				$w['slug'] = $slug;
				$s = $this->cms_model->select('links',$w);

				if ($s->num_rows() == 1)
				{
					$row = $s->row_array();

					$ok = "<a dir='rtl' style='text-decoration: none;' href='".decode($row['url'])."' target='_blank' ><button class='btn btn-success btn-block' style='text-align: center;height: 70px;font-size: 20px;'><i class='fa fa-link'></i> إضغط هنا للذهاب للرابط</button></a>";
				}
				else
				{
					$err = 'عذرا، الرابط غير موجود !';
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