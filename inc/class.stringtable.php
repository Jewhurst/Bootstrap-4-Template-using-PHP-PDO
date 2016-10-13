<?php
define(LANG,"eng");


	global $lang;
	$lang = array (
	
		"site" => array(
			 //"title" 	=> array(LANG=>""),
		),
		"common" => array(
			  "myacc" 	=> array(LANG=>"MY ACCOUNT"),
			  "menu" 	=> array(LANG=>"Menu"),
			  "close" 	=> array(LANG=>"Close"),
			  "home" 	=> array(LANG=>"Home"),
		)
	);
	function stringtable($cat,$word,$language = LANG) {
		global $lang;
		$str = $lang[$cat][$word][$language];
		return $str;		
	}
	
	/*
	 echo $lang['common']['close'][LANG];
	 echo stringtable('common','home');
	*/
?>