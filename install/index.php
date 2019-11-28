<?php
//ob_start();
//session_start();
//@date_default_timezone_set('Africa/Casablanca');
ini_set('display_errors', 0);
error_reporting(E_ALL);

/*==================== folder ====================*/
$ex = explode('/',$_SERVER['REQUEST_URI']);
$folder = '';
foreach ($ex as $f)
{
	if ($f != 'install')
	{
		$folder .= $f.'/';
	}
	else
	{
		break;
	}
}

$folder = trim($folder,'/');

if ($folder == '')
{
	$folder = '/';
}
else
{
	$folder = '/'.$folder.'/';
}

/*================================================*/
//echo phpinfo();
//$base_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$folder;
$base_url = "http://".$_SERVER['HTTP_HOST'].$folder;
$is_error = '';
/*
1 - test if the server is ready
2 - insert database data
3 - insert admin data
4 - update the config file & database file & .htaccess file
*/

require_once 'includes/functions.php';
/*================= 1 - test if the server is ready ==================*/
require_once 'includes/check_the_server.php';

/*================= 2 - Check Purchase Code =========================*/

$msg = array();

/*if (isset($_GET['step']) && $_GET['step'] == 1)
{
	if (isset($_SESSION['purchase_code']) && $_SESSION['purchase_code'] != '')
	{
		header("location: index.php?step=2");
		exit;
	}

	if (isset($_POST['submit']))
	{
		// check the license & redirect to step 2
		// else try again.
		$purchase_code 	= _addslashes(trim($_POST['code']));

		if ($purchase_code == '')
		{
			$msg[]['er'] = "Please enter your Envato Purchase Code.";
		}
		else
		{
			$res = verify_purchase($purchase_code);

			if ($res == false)
			{
				$msg[]['er'] = "Oops, the Purchase Code is invalid!";
			}
			else
			{
				// send the data to my server about the customer (BUT not now).
				$_SESSION['purchase_code'] = $purchase_code;
				//$_SESSION['username'] = $username;
				//$_SESSION['email'] = $email;
				header("location: index.php?step=2");
				exit;
			}
		}
	}
}*/


/*================= 3 - insert database data =========================*/

if (isset($_POST['submit']) && $_POST['submit'] == 'install')
{
	$sitename 		= trim(_addslashes(strip_tags($_POST['sitename'])));
	$support 		= trim(strtolower(_addslashes(strip_tags($_POST['support']))));
	$folder 		= $folder;
	$db_hostname 	= trim(_addslashes(strip_tags($_POST['db_hostname'])));
	$db_username 	= trim(_addslashes(strip_tags($_POST['db_username'])));
	$db_password 	= trim(_addslashes(strip_tags($_POST['db_password'])));
	$database 		= trim(_addslashes(strip_tags($_POST['db_name'])));
	$db_prefix 		= trim(strtolower(_addslashes(strip_tags($_POST['db_prefix']))));
	$admin_name 	= trim(_addslashes(strip_tags($_POST['admin_name'])));
	$admin_email 	= trim(strtolower(_addslashes(strip_tags($_POST['admin_email']))));
	$admin_pass 	= trim(_addslashes(strip_tags($_POST['admin_pass'])));

	$time 			= time();
	
	/*
	echo '<pre>';
	echo $sitename.'<br>';
	echo $support.'<br>';
	echo $folder.'<br>';
	echo $db_hostname.'<br>';
	echo $db_username.'<br>';
	echo $db_password.'<br>';
	echo $database.'<br>';
	echo $db_prefix.'<br>';
	echo $admin_name.'<br>';
	echo $admin_email.'<br>';
	echo $admin_pass.'<br>';
	echo '</pre>';
	*/
	
	if (empty($sitename) || empty($support) || empty($folder) || 
		empty($admin_name) || empty($admin_email) || empty($admin_pass) ||
		empty($db_hostname) || empty($db_username) || empty($db_password) || empty($database) || empty($db_prefix))
	{
		$msg[]['er'] = 'Oops!, Please fill the all fields.';
	}
	else if (!filter_var($support,FILTER_VALIDATE_EMAIL))
	{
		$msg[]['er'] = 'Oops!, the <b>support email</b> isn\'t valid.';
	}
	else if (!filter_var($admin_email,FILTER_VALIDATE_EMAIL))
	{
		$msg[]['er'] = 'Oops!, the <b>admin email</b> isn\'t valid.';
	}
	else
	{
		$db = @new mysqli($db_hostname,$db_username,$db_password);

		if ($db->connect_errno)
		{
			$msg[]['er'] = 'Oops!, the <b>database information</b> wasn\'t correct.';
		}
		else if (!$db->select_db($database))
		{
			$msg[]['er'] = 'Oops!, the <b>database</b> not found.';
		}
		else
		{
			$msg[]['ok'] = 'Connection to database has been done successfully.';

			@$db->set_charset('utf8');
			/*============== creations of the database tables ===============*/
			$lines = file('tmps/db.tmp.sql');

			$e = array();
			$tmp_line = '';

			foreach ($lines as $line)
			{
				$start = substr(trim($line), 0, 2);
				$end = substr(trim($line), -1, 1);

				if ($start == '--' || $start == ' ')
					continue;
				else
					$tmp_line .= $line;

				if ($end == ';')
				{
					$tmp_line = str_replace("{DBP}", $db_prefix, $tmp_line);
					// execute the SQL query
					if (! @$db->query($tmp_line))
					{
						echo $tmp_line."<br>";
						$e[] = 0;
						break;
					}						

					// clear tmp_line
					$tmp_line = '';
				}
			}

/*			$sqls = explode("{BR}",@file_get_contents('tmps/db.tmp.sql'));

			//echo "<pre>";
			foreach ($sqls as $sql)
			{
				$sql = str_replace("{DBP}",$db_prefix,$sql);
				$insert = @$db->query($sql);
				if (!$insert)
				{
					echo $sql."<br>";
					$e[] = 0;
					break;
				}
			}*/
			//echo "</pre>";

			if (count($e) > 0)
			{
				$msg[]['er'] = 'Oops!, Something went wrong ! <b>( Note:</b> You should to drop your old database tables first or change tables prefix in the field below! <b>)</b>';
			}
			else
			{
				/*===================== insert admin date & site data ====================*/
				$admin_pass 	= password_hash($admin_pass,PASSWORD_DEFAULT);
				$user_token 	= sha1(md5(time()));

				$in_admin = $db->query("INSERT INTO `".$db_prefix."users` 
					(id,username,email,password,gender,user_joined,user_status,user_token,user_verified,account_status) 
					VALUES (1,'$admin_name','$admin_email','$admin_pass',0,'$time',1,'$user_token','1',0)");

				$up['sitename'] = $sitename;
				$up['email_from'] = $support;

				foreach ($up as $k => $v)
				{
					$up_site = $db->query("UPDATE `".$db_prefix."settings` SET option_value='$v' WHERE option_name='$k'");	
				}

				if ($in_admin && $up_site)
				{
					$msg[]['ok'] = 'The database data has been installed successfully.';
				}
				else
				{
					$msg[]['er'] = 'Oops!, The database data hasn\'t been installed !';
				}

				/*========= update (edit) config file & .htaccess & database file =======*/

				$file1 	= 'tmps/tmp.htaccess';
				$content1 	= @file_get_contents($file1);
				$content1 	= @str_replace("%FOLDER%",($folder=='')?'/':$folder,$content1);
				$creat1 	= @file_put_contents('../.htaccess',$content1);
								
				$file2 	= 'tmps/config.tmp.php';
				$content2 	= @file_get_contents($file2);
				$content2 	= @str_replace("%FOLDER%",$folder,$content2);
				$content2 	= @str_replace("%ENC_KEY%", sha1(time()),$content2);
				$creat2 	= @file_put_contents('../application/config/config.php',$content2);

				$file3 	= 'tmps/database.tmp.php';
				$content3 	= @file_get_contents($file3);
				$content3 	= @str_replace("%DB_HOST%",$db_hostname,$content3);
				$content3 	= @str_replace("%DB_USERNAME%",$db_username,$content3);
				$content3 	= @str_replace("%DB_PASSWORD%",$db_password,$content3);
				$content3 	= @str_replace("%DB%",$database,$content3);
				$content3 	= @str_replace("%PREFIX%",$db_prefix,$content3);
				$creat3  	= @file_put_contents('../application/config/database.php',$content3);

				$file4 = 'tmps/index.tmp.php';
				$content4	= @file_get_contents($file4);
				$creat4		= @file_put_contents('../index.php', $content4);

				// send mail to admin.
				$message = "Hi {$admin_name}!\nYou can login to {$sitename} Dashboard by using this information:\nPath: {$base_url}\nEmail: {$admin_email}\nPassword: {$admin_pass}\n\nif you need any help please feel free to contact us.";

				@mail($admin_email, "{$sitename}: Dashboard Informations", $message);

				/*
				if ($creat1)
				{
					$msg[]['ok'] = 'The <b>.htaccess</b> file was created successfully.';
				}
				else
				{
					$msg[]['er'] = 'The <b>.htaccess</b> file wasn\'t created.';
				}

				if ($creat2)
				{
					$msg[]['ok'] = 'The <b>config.php</b> file was created successfully.';
				}
				else
				{
					$msg[]['er'] = 'The <b>config.php</b> file wasn\'t created.';
				}

				if ($creat3)
				{
					$msg[]['ok'] = 'The <b>database.php</b> file was created successfully.';
				}
				else
				{
					$msg[]['er'] = 'The <b>database.php</b> file wasn\'t created.';
				}
				*/

				if ($creat1 && $creat2 && $creat3)
				{
					$msg[]['ok'] = "The files <b>.htaccess , config.php and database.php</b> have been created successfully.";
					$is_error = 'no';
				}
				else
				{
					$msg[]['er'] = "The files <b>.htaccess , config.php and database.php</b> weren\'t created !";
				}
			}

			@$db->close();
		}

	}

}


$m = '';
if (count($msg) > 0)
{
	foreach ($msg as $k => $v)
	{
		if (isset($v['er']))
		{
			$m .= "<div class='alert alert-warning'><i class='glyphicon glyphicon-remove'></i> ".$v['er']."</div>";
			$is_error = 'yes';
		}
		else if (isset($v['ok']))
		{
			$m .= "<div class='alert alert-success'><i class='glyphicon glyphicon-ok'></i> ".$v['ok']."</div>";
		}
	}
}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8' >
		<title>install</title>
		
		<!-- css files -->
		<link type='text/css' rel='stylesheet' href='css/bootstrap/css/bootstrap.css' >

		<!-- js files -->
		<script type='text/javascript' src='js/jquery-1.12.3.min.js'></script>
		<script type='text/javascript' src='css/bootstrap/js/bootstrap.min.js'></script>

	</head>
	<body>
		<div class='container'>
			<br><br>
			<div class="col-md-12">
				<?php
				if (isset($m) && !empty($m) && $is_error == 'yes')
				{
					/*
					echo "<pre>";
					print_r($msg);
					echo "</pre>";
					*/
					echo $m;
				}
				?>
			</div>
			<div class='row text-center'>
				<br><br>
				<div class='col-lg-12 text-left'>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3>
								<i class='glyphicon glyphicon-save'></i> Welcome to the instalation page :
							</h3>
						</div>
						<div class="panel-body">
							<?php
							if ($is_error == '' || $is_error == 'yes')
							{
							?>
							<form action="" method='post'>
								<h2><i class='glyphicon glyphicon-cog'></i> Site information :</h2>
								<div class='form-group'>
									<label>Site name :</label>
									<?php
										//$sitename = ucfirst(str_ireplace("www.", "", $_SERVER['HTTP_HOST'])); ?>
									<input type='text' name='sitename' class='form-control'>
								</div>
								<div class='form-group'>
									<label>Support email :</label>
									<input type='text' name='support' class='form-control' >
								</div>
								<div class='form-group'>
									<label>path :</label>
									<input type='text' value="<?php echo $base_url; ?>" class='form-control' disabled="disabled" >
								</div>
								<hr>
								<h2><i class='glyphicon glyphicon-tasks'></i> Database information :</h2>
								<div class='form-group'>
									<label>Host name :</label>
									<input type='text' name='db_hostname' placeholder="localhost" class='form-control' >
								</div>
								<div class='form-group'>
									<label>Database username :</label>
									<input type='text' name='db_username' class='form-control' >
								</div>
								<div class='form-group'>
									<label>Database password :</label>
									<input type='password' name='db_password' class='form-control' >
								</div>
								<div class='form-group'>
									<label>Database name <small>(Note: Create an empty database then enter it's name in the field below)</small>:</label>
									<input type='text' name='db_name' class='form-control' >
								</div>
								<div class='form-group'>
									<label>Tables prifix :</label>
									<input type='text' name='db_prefix' value='MY_' class='form-control' >
								</div>
								<hr>
								<h2><i class='glyphicon glyphicon-user'></i> Admin information :</h2>
								<div class='form-group'>
									<label>Username :</label>
									<input type='text' name='admin_name' class='form-control' >
								</div>
								<div class='form-group'>
									<label>E-mail :</label>
									<input type='text' name='admin_email' class='form-control' >
								</div>
								<div class='form-group'>
									<label>Password :</label>
									<input type='text' name='admin_pass' class='form-control' >
								</div>
								<hr>
								<div class='form-group'>
									<input type='submit' name='submit' value='install' class='btn btn-primary' >
									<span>Note: the instalation takes from 10 to 20 seconds to complete.</span>
								</div>
							</form>
							<?php
							}
							else
							{
								echo "<div class='row'>
									<div class='col-lg-12'>
										<div class='alert alert-success'>
											Installed successfully !, thank you for your patience :D .
											<br>
											Your website is ready to use right NOW, you can manage it from the admin area, Enjoy :D .
										</div>
									</div>
								</div>";
								/*
								echo "
								<div class='row text-center'>
									<div class='col-lg-12'>
										<a class='btn btn-primary' href='".$base_url."home' target='_blank'>Go to the Home page</a>
									</div>
								</div>";
								*/
								echo "
								<div class='row text-center'>
									<div class='col-lg-12'>
										<a class='btn btn-warning btn-lg' href='".$base_url."adminpanel'>Go to the Admin area</a>
									</div>
								</div>";
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class='row text-center'>
				<div class='col-lg-12'>
					<copy>&copy; Powered by <a href="https://www.mr4web.com" target="_blank"><b>MR4Web.com</b></a></copy><br><br>
				</div>
			</div>
		</div>
	</body>
</html>