<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" dir="ltr">
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

    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,400;0,600;0,800;1,200;1,400;1,600;1,800&display=swap" rel="stylesheet">

    <!-- Load the style of the site -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
	<!-- recaptcha script -->
	<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>

</head>
<body>
<div class="container">
    <section>
