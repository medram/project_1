<?php

if (isset($_POST['origin_url']) && $_POST['origin_url'] != '')
{
	header("Location: ".$_POST['origin_url']);
	exit();
}

//show();

function show()
{
	$data = array($_POST, $_GET);
	
	for ($i = 0; $i < count($data); $i++)
	{	
		if (isset($data[$i]) && count($data[$i]) > 0)
		{
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
		}
	}
}

?>