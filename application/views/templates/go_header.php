<!DOCTYPE html>
<html lang="ar">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="<?php if (isset($meta['keywords'])){echo $meta['keywords'];} ?>">
    <meta name="description" content="<?php if (isset($meta['description'])){echo $meta['description'];} ?>">

    <!-- for social network -->
    <meta type="og:title" content="<?php echo $title; ?>" >
    <meta type="og:description" content="<?php if (isset($meta['description'])){echo $meta['description'];} ?>" >
    <meta type='og:image' content="<?php echo base_url(); ?>img/logo.png" >

    <!-- show favicon -->
    <?php
    echo get_icon();
    ?>

    <!-- Load jQuery library -->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/plugin.js"></script>

    <!-- fonts -->
    <link href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/font-awesome/font-awesome.min.css" rel="stylesheet"> 

    <!-- Load the style of the site -->
    <link href="<?php echo base_url(); ?>css/style.css?v=1.0" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/go-style.css" rel="stylesheet">

    <!-- for RTL theme -->
    <?php if (config_item('validLang')['isRTL']){ ?>
    <link href="<?php echo base_url(); ?>css/bootstrap/css/bootstrap-rtl.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-rtl.css" rel="stylesheet">
    <?php } ?>

    <!-- Head codes like google analytics -->
    <?php
    if (get_config_item('go_head_code') != '')
    {
    	echo get_config_item('go_head_code');
    }
    ?>
</head>
<body>
    <header>
        <nav class="navbar navbar-default navbar-static-top">
          <div class="container-fluid container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <a class="navbar-brand <?php if (config_item("show_logo") == 1){echo 'site-logo-img';} ?>" href="<?php echo base_url(); ?>"><?php echo get_logo(); ?></a>
                <!--Btn will be shown on mobile -->
                <!--
                 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </header>
    <section>
    
