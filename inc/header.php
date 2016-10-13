<?php 
	require 'global.php'; 
	if (!defined('SITE_TITLE')) {define('SITE_TITLE',$data->getSiteOption("site_name"));}
	if(!isset($_SESSION)) { session_start();}
	$uname = $_SESSION['uname'];
	$uid = $_SESSION['uid'];
	$isAdmin = $_SESSION['isAdmin'];
	$pageurl = getPageURL();
	if(isLoggedIn()){
	} else {	  
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo SITE_TITLE; ?></title>

	<link rel="stylesheet" href="<?php echo HOME; ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo HOME; ?>css/custom.css">
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
	<div class="container">
      <a class="navbar-brand" href="<?php echo HOME; ?>"><?php echo SITE_TITLE; ?></a>
      <ul class="nav navbar-nav pull-right ">
        <li class="nav-item">
          <a class="nav-link" href="#"><span style="color:#fff;"><?php echo stringtable("common","myacc"); ?></span></a>
        </li>
      </ul>
	  </div>
    </nav>   