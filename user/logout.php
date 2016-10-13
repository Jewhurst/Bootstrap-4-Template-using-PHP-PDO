<?php 
require('../inc/global.php');
$data->logout();
if(isLoggedIn()!=""){
	error_log("User is in fact logged in, lets try to log them out",0);
	if(isset($_GET['logout']) && $_GET['logout']=="true"){
		$data->logout();
		redirect(0,HOME);
	}
} else {
		userFlush();
		redirect(0,HOME);
		error_log("Somehow a user was logged in enough to not be logged in...",0);
}
redirect(0,HOME);
?>