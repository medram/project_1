<?php

class Logout extends MY_controller
{
	public function index ()
	{
		/*==== delete login session =====*/
		$a = array('token','admin_token');
		$this->session->unset_userdata($a);

		/*==== delete login cookie =====*/
		delete_cookie(config_item('cookie_name'));

		redirect(base_url().'login');
	}
}


?>