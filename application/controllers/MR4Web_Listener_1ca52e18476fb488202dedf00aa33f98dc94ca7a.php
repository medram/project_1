<?php

class MR4Web_Listener_1ca52e18476fb488202dedf00aa33f98dc94ca7a extends MY_controller
{
	private $data = array();

	public function __construct ()
	{
		parent::__construct();
		$this->data['page_path'] = strtolower(__CLASS__); // you can change the name page from the url from here 
	
		// just for debugging mode
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$update = strtolower($this->input->post('update', true));

		switch ($update)
		{
			case 'news':
				$this->news();
				break;
			case 'software':
				$this->software();
				break;
			default:
				header("location: ".base_url());
				exit;
		}
	}

	private function news()
	{
		$action = $this->input->post('action', true);
		$data = json_decode($this->input->post('data', true), true);
		//file_put_contents(APPPATH."data.txt", $this->input->post('data', true));
		$res['received'] = 0;

		if ($action == 'delete_prev')
			$this->db->truncate('news');

		if (count($data))
		{
			$err = 0;
			foreach ($data as $news)
			{
				$insert = [
					'title' 		=> $news['title'],
					'description' 	=> $news['description'],
					'image_URL'		=> $news['image_URL'],
					'news_URL'		=> $news['news_URL'],
					'created'		=> $news['created']
				];

				if (!$this->db->insert('news', $insert))
				{
					$err = 1;
					break;
				}
			}
	
			if (!$err)
			{
				// auto show notification "News" label
				$this->cms_model->update('settings', ['option_value' => '0'],['option_name' => 'viewed_news']);
				//-------------------
				$res['received'] = 1;
			}
		}
		else
			$res['received'] = 1;
		
		header("Content-Type: application/json");
		echo json_encode($res);
	}

	private function software()
	{
		$action = $this->input->post('action', true);
		$data = json_decode($this->input->post('data', true), true);
		$res = [];
		//file_put_contents(APPPATH."data.txt", $s);

		if ($action == 'delete_prev')
		{
			$this->db->truncate('updates');
		}
		
		if (count($data))
		{
			$customData = array(
					'product_name' 			=> $data['product']['name'],
					'product_version' 		=> $data['product']['version'],
					'update_download_url' 	=> $data['updates']['download_url'],
					'features' 				=> json_encode($data['features']),
					'time' 					=> $data['product']['created']
				);


			if (!$this->db->insert('updates', $customData))
				$res = ['received' => 0];
			else
				$res = ['received' => 1];
		}
		else
		{
			$res = ['received' => 1];
		}
	
		header("Content-Type: application/json");
		echo json_encode($res);
	}
}

?>