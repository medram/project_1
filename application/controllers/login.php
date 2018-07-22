<?php

class Login extends MY_controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->data['page_path'] = strtolower(__CLASS__);
		$this->cms_model->if_login_redirect_to('account');
	}

	public function index ()
	{
		$this->data['msg'] = $this->cms_model->login();

		$this->data['title'] = langLine('notifAccount.login.span.1', false);

		$this->load->view("templates/header",$this->data);
		$this->load->view("pages/login",$this->data);
		$this->load->view("templates/footer",$this->data);
	}

	public function forget_pass()
	{
        $this->data['title'] = langLine('notifAccount.login.span.2', false);

        $this->data['msg'] = $this->cms_model->forget_pass();

		$this->load->view("templates/header",$this->data);
		$this->load->view("pages/forget_pass",$this->data);
		$this->load->view("templates/footer",$this->data);
	}

	public function repass ()
	{
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
                $this->data['msg'] = $this->cms_model->repass($a[0]);
            }
            else
            {
                $this->data['forb'] = "<div class='alert alert-danger'><i class='fa fa-lg fa-clock-o'></i> ".langLine('notifAccount.login.span.3', false)."</div>";
            }
        }

		$this->data['title'] = langLine('notifAccount.login.span.4', false);

		$this->load->view("templates/header",$this->data);
		$this->load->view("pages/repass",$this->data);
		$this->load->view("templates/footer",$this->data);
	}

    public function activation ()
    {
        if ($this->input->get('u'))
        {
            $u = trim(strip_tags($this->input->get('u',TRUE)));
            $token = decode($u,TRUE);

            $where['user_token'] = $token;
            $s = $this->cms_model->select('users',$where);

            if ($s->num_rows() == 1)
            {
                $r = $s->row_array();
                if ($r['user_verified'] == 1)
                {
                    $err = langLine('notifAccount.login.span.5', false);
                }
                else
                {
                    $set['user_verified'] = 1;
                    $up = $this->cms_model->update('users',$set,$where);

                    if ($up)
                    {
                        $ok = langLine('notifAccount.login.span.6', false);
                        $ok .= "
                            <script type='text/javascript'>
                            setTimeout(function (){
                                window.location.href = '".base_url('login')."';
                            },6000);
                            </script>
                        ";
                    }
                    else
                    {
                        $err = langLine('notifAccount.login.span.7', false);
                    }
                }
            }
            else
            {
                $err = langLine('notifAccount.login.span.8', false);
            }
            $s->free_result();
        }
        else
        {
            show_404();
        }

        if (isset($err) && $err != "")
        {
            $this->data['msg'] = "<div class='alert alert-danger'><i class='fa fa-lg fa-exclamation-circle'></i> ".$err."</div>";
        }
        else if (isset($ok) && $ok != "")
        {
            $this->data['msg'] = "<div class='alert alert-success'><i class='fa fa-lg fa-check'></i> ".$ok."</div>";
        }

        $this->data['title'] = langLine('notifAccount.login.span.9', false);

        $this->load->view("templates/header",$this->data);
        $this->load->view("pages/activation",$this->data);
        $this->load->view("templates/footer",$this->data);
    }

}

?>