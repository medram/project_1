<!DOCTYPE html>
<html lang="ar">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="<?php if (isset($meta['keywords'])){echo $meta['keywords'];} echo ",".config_item('keywords'); ?>">
    <meta name="description" content="<?php if (isset($meta['description'])){echo $meta['description'];}else{echo config_item('description');} ?>">

    <!-- for social network -->
    <meta type="og:title" content="<?php echo $title; ?>" >
    <meta type="og:description" content="<?php if (isset($meta['description'])){echo $meta['description'];}else{echo config_item('description');} ?>" >
    <meta type='og:image' content="<?php echo base_url(); ?>img/logo.png" >

    <!-- show favicon -->
    <?php
    echo get_icon();
    ?>

    <!-- Load jQuery library -->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.12.3.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.2.1.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugin.js"></script>

    <?php
    if ($this->uri->segment(1) == get_config_item('user_page_path'))
    {
    	echo "<script defer src='".base_url()."js/account.js?v=1.0' type='text/javascript'></script>";
    }
	?>

	<!-- fonts -->
	<link href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,400;0,600;0,800;1,200;1,400;1,600;1,800&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- <link href="<?php echo base_url(); ?>css/bootstrap4/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?php echo base_url(); ?>css/font-awesome/font-awesome.min.css" rel="stylesheet">

    <!-- Load the style of the site -->
    <link href="<?php echo base_url(); ?>css/style.css?v=1.0" rel="stylesheet">

	<!-- Flag icons -->
	<link rel="stylesheet" href="<?php echo base_url('vendor/components/flag-icon-css'); ?>/css/flag-icon.min.css" >

    <!-- for RTL theme -->
    <?php if (config_item('validLang')['isRTL']){ ?>
    <link href="<?php echo base_url(); ?>css/bootstrap/css/bootstrap-rtl.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-rtl.css" rel="stylesheet">
    <?php } ?>

    <?php
    if (get_config_item('tracking_code') != '')
    {
    	echo get_config_item('tracking_code');
    }
    ?>
</head>
<body>
	<span data-base-url="<?php echo base_url() ?>" style="display: none;"></span>
	<header>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container-fluid container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <a class="navbar-brand <?php if (config_item("show_logo") == 1){echo 'site-logo-img';} ?>" href="<?php echo base_url(); ?>"><?php echo get_logo(); ?></a>
		      	<!--Btn will be shown on mobile -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <?php
		        if (isset($userdata['user_token']))
		        {
		        	// nav of user
		        }
		        else
		        {


		        	$s = $this->cms_model->getPages('header');

					if ($s->num_rows() != 0)
					{
		        		echo "<li><a href='".base_url()."'>".langLine('theme.header.home', false)."</a></li>";
						foreach ($s->result_array() as $row)
						{
							echo "<li><a href='".base_url("p/".$row['slug'])."'>".ucfirst($row['title'])."</a></li>";
						}
					}

					$s->free_result();
		    	}
		        ?>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <?php
		        if (isset($userdata['user_token']))
		        {
		        	// nav left of user
		        ?>
		        <li class="dropdown">
		        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		        			<!--<i class='fa fa-fw fa-lg fa-user'></i>-->
		        			<img src='<?php echo get_profile_img($userdata['user_token']); ?>' class='pro-img img-circle ' width='35px' height='35px' >
		          			<b><?php echo $userdata['username'];?></b> <span class="caret"></span>
		          	</a>
		          <ul class="dropdown-menu">
		            <li><a href="<?php echo base_url($page_path); ?>/dashboard"><i class="fa fa-fw fa-dashboard"></i> <?php langLine('theme.header.dashboard') ?></a></li>
		            <li><a href="<?php echo base_url($page_path); ?>/profile"><i class="fa fa-fw fa-user"></i> <?php langLine('theme.header.profile') ?></a></li>
		            <li class='divider'></li>
		            <li><a href="<?php echo base_url(); ?>logout"><i class="fa fa-fw fa-sign-out"></i> <?php langLine('theme.header.logout') ?></a></li>
		          </ul>
		        </li>
		        <?php
		        }
		        else
		        {
		        ?>
	            <li><a href="<?php echo base_url(); ?>login" class="active-2"><i class="fa fa-fw fa-sign-in"></i> <?php langLine('theme.header.login'); ?></a></li>
	            <li class='divider'></li>
	            <li><a href="<?php echo base_url(); ?>register" class="active"><i class="fa fa-fw fa-user-plus"></i> <?php langLine('theme.header.register'); ?></a></li>
		        <?php
		    	}
		        ?>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	</header>
	<section>
		<?php
		if (isset($page_path) && $page_path == get_config_item('user_page_path'))
		{
		?>
		<div class='row'>
			<div class='col-lg-12'>
				<div style='text-align: center;'><?php echo get_ad('ad_728x90',TRUE); ?></div><br>
			</div>
		</div>
		<?php
		}
		?>
