<?php
$database_host = "localhost";
$database_user = "#";
$database_pass = "#";
$database_name = "#";
try {
	$db = new PDO("mysql:host={$database_host};dbname={$database_name}",$database_user,$database_pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOexception $e) {
	echo $e->getMessage();
}
$data = new dbconnect($db);
 ?>