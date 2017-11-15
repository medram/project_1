<!DOCTYPE html>
<html lang="ar">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <!-- show favicon -->
    <?php
    echo get_icon();
    ?>

    <!-- Load jQuery library -->
    <script src="<?php echo base_url(); ?>js/jquery-1.12.3.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/font-awesome/font-awesome.min.css" rel="stylesheet"> 
    <link href="<?php echo base_url(); ?>css/bootstrap/css/bootstrap-rtl.css" rel="stylesheet">

    <!-- Load the style of the site -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet"> 
	<!-- recaptcha script -->
	<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>



</head>
<body>
<div class="container">