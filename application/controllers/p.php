<?php

class P extends MY_controller
{
	public $data = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function index ($slug='')
	{
		$slug = trim(strip_tags($slug));

		if (preg_match("/^([a-zA-Z0-9_-]+)$/",$slug))
		{
			$where['slug'] = $slug;
			$where['published']	= 1;
			$sel = $this->cms_model->select('pages',$where);

			if ($sel->num_rows() == 1)
			{
				$this->data['pagedata'] = $sel->row_array();
				$this->data['title'] = $this->data['pagedata']['title'];
				$this->data['meta']['description'] = htmlentities($this->data['pagedata']['description'],ENT_QUOTES);
				$this->data['meta']['keywords'] = htmlentities($this->data['pagedata']['keywords'],ENT_QUOTES);

				$page = 'templates/p'; // default page

				if ($slug == 'contact')
				{
					$page = 'pages/contact';
				}

				$this->load->view("templates/header",$this->data);
				$this->load->view($page,$this->data);
				$this->load->view("templates/footer",$this->data);
			}
			else
			{
				show_404();
			}

			$sel->free_result();
		}
		else
		{
			show_404();
		}
		
	}
}

?>