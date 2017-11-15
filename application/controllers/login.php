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

		$this->data['title'] = "تسجيل الدخول";

		$this->load->view("templates/header",$this->data);
		$this->load->view("pages/login",$this->data);
		$this->load->view("templates/footer",$this->data);
	}

	public function forget_pass()
	{
        $this->data['title'] = "إستعادة حسابي";

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
                $this->data['forb'] = "<div class='alert alert-danger'><i class='fa fa-lg fa-clock-o'></i> عذرا، لقد انتهت مدة صلاحية هذا الرابط !</div>";
            }
        }

		$this->data['title'] = "إستعادة حسابي";

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
                    $err = "لقد تم تفعيل هذا الحساب مسبقا.";
                }
                else
                {
                    $set['user_verified'] = 1;
                    $up = $this->cms_model->update('users',$set,$where);

                    if ($up)
                    {
                        $ok = "تم تفعيل حسابك بنجاح، جار توجيهك ...";
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
                        $err = "عذرا، لقد حدث خطأ غير متوقع.";
                    }
                }
            }
            else
            {
                $err = "عذرا، هذا الرابط غير صالح !";
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

        $this->data['title'] = "تفعيل حسابك";

        $this->load->view("templates/header",$this->data);
        $this->load->view("pages/activation",$this->data);
        $this->load->view("templates/footer",$this->data);
    }

}

?>