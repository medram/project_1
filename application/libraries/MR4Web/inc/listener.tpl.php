<?php

class %CLASS_NAME% extends MY_controller
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
				//header("location: ".base_url());
				//exit;
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

		$err = 0;

		foreach ($data as $news)
		{
			array_shift($news);
			if (!$this->db->insert('news', $news))
			{
				$err = 1;
				break;
			}
		}

		if (!$err)
			$res['received'] = 1;
		
		header("Content-Type: application/json");
			echo json_encode($res);
	}

	private function software()
	{
		$action = $this->input->post('action', true);
		$data = json_decode($this->input->post('data', true), true);
		
		//file_put_contents(APPPATH."data.txt", $s);

		if ($action == 'delete_prev')
		{
			$this->db->truncate('updates');
		}
		
		$customData = array(
				'product_name' 			=> $data['product']['name'],
				'product_version' 		=> $data['product']['version'],
				'update_download_url' 	=> $data['updates']['download_url'],
				'features' 				=> json_encode($data['features']),
				'time' 					=> $data['product']['created']
			);

		header("Content-Type: application/json");

		if (!$this->db->insert('updates', $customData))
			echo json_encode(['received' => 0]);
		else
			echo json_encode(['received' => 1]);
	}
}

?>