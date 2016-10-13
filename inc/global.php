<?php 
	/*REQUIRE FILES */
	require('class.stringtable.php');
	require('class.functions.php');
	require('class.database.php');
	require('connect.php');
	/* DEFINE TIMEZONE */
	date_default_timezone_set("America/New_York");
	/*SET HOME DIRECTORY, kinda*/
	$temphome = "test/yardsale/";
	$home = "http://".$_SERVER['SERVER_NAME']."/".$temphome;	
	define("HOME", $home);
	
?>