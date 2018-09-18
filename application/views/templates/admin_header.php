<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- show favicon -->
	<?php
	echo get_icon();
	?>

	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/bower_components/Ionicons/css/ionicons.min.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/bower_components/jvectormap/jquery-jvectormap.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		 folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/dist/css/skins/_all-skins.min.css">

	<!-- Custom CSS -->
	<link href="<?php echo base_url(); ?>css/sb-admin.css" rel="stylesheet">

	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

	<!-- Google Font -->
	<link rel="stylesheet"
		  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<!-- jQuery 3 -->
	<script src="<?php echo base_url('assets/AdminLTE-2.4.5'); ?>/bower_components/jquery/dist/jquery.min.js"></script>

	<!--  my plugins -->
	<script src="<?php echo base_url(); ?>js/plugin.js"></script>
	<script src="<?php echo base_url(); ?>js/cpanel.js?v=1.0"></script>


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

	<header class="main-header">

		<!-- Logo -->
		<a href="<?php echo base_url() ?>" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b><?php echo strtoupper(config_item('sitename')[0]); ?></b></span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><?php echo ucfirst(config_item('sitename')); ?></span>
		</a>

		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php echo get_profile_img($userdata['user_token']) ?>" class="user-image" alt="User Image">
							<span class="hidden-xs">Welcome <b><?php echo $userdata['username']; ?></b></span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header">
								<img src="<?php echo get_profile_img($userdata['user_token']) ?>" class="img-circle" alt="User Image">

								<p>Welcome <b><?php echo $userdata['username']; ?></b></p>
							</li>
							<!-- Menu Body -->
							<li class="user-body">
								<div class="row">
									<div class="col-xs-6 text-center">
										<a href="<?php echo base_url('account'); ?>" target="_blank" ><i class="fa fa-fw fa-user"></i> User area</a>
									</div>
									<div class="col-xs-6 text-center">
										<a href="<?php echo base_url().$page_path; ?>/settings"><i class="fa fa-fw fa-gear"></i> Settings</a>
									</div>
								</div>
							</li>
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="<?php echo base_url().$page_path; ?>/profile"><i class="fa fa-fw fa-user-secret"></i> Profile</a>
								</div>
								<div class="pull-right">
									<a href="<?php echo base_url(); ?>logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
				&nbsp;
				&nbsp;
			</div>

		</nav>
	</header>
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header">MAIN NAVIGATION</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/links"><i class="fa fa-link"></i> <span>Links</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/users"><i class="fa fa-users"></i> <span>Users</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/online"><i class="fa fa-wifi"></i> <span>Online visitors</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/pages"><i class="fa fa-file-text-o"></i> <span>Pages</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/profile"><i class="fa fa-user"></i> <span>My Profile</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/settings"><i class="fa fa-gear"></i> <span>Site settings</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/languages"><i class="fa fa-language"></i> <span>Languages</span></a>
				</li>
				<li>
					<a href="<?php echo base_url().$page_path; ?>/updates"><i class="fa fa-calendar"></i> <span>Updates & News <?php echo labelNotification() ?></span></a>
				</li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">