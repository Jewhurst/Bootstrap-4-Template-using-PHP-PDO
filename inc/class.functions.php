<?php
/*IMPORTANT SLUG FUNCTION*/
	function slug($text){ 
			$slug=strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
			return $slug;
	}
/*TRUNCATE TEXT TO X CHARS*/ 
	function truncate($string,$length=150,$append="&hellip;") {
	  $string = trim($string);

	  if(strlen($string) > $length) {
		$string = wordwrap($string, $length);
		$string = explode("\n", $string, 2);
		$string = $string[0] . $append;
	  }

	  return $string;
	}
/*CHECKS IF USER IS LOGGED IN*/
   function isLoggedIn() {
      if(isset($_SESSION['uname']) && isset($_SESSION['loggedin']) && isset($_SESSION['uid'])){
         return true;
      }
          
   }	
	/*GET CURRENT PAGE URL*/	
	function getPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}
	
	/*REDIRECT CODE*/
      function redirect($mode = 0, $url = HOME) {

        switch ($mode) {
          case 1:
          ?> 
              <script type="text/javascript">
                  window.location.href = "<?php echo $url; ?>"
               </script>
          <?php 
            break;

          default:
          ?> 
              <script type="text/javascript">
                  window.location.href = <?php echo HOME; ?>
               </script>
          <?php 
            break;
        }
    
   }
   
   /*ENCRYPT FUNCTION - WORKS WITH DECRYPT*/   	
	function enCrypt($mode,$val) {
          
          switch ($mode) {
            //base64 encoding
            case 0:
                $hashed_val = password_hash($val,PASSWORD_DEFAULT);
                return $hashed_val;
              break;
            //php5.5 default hashing
            case 1:
                  $key_val = base64_encode($val);
                  return $key_val;
              break;
            //md5 encoding 
            case 2:
                $ret_val = md5($val);
                return $ret_val;
              break;
            
            default:
                $hashed_val = password_hash($val,PASSWORD_DEFAULT);
                return $hashed_val;
              break;
          }

          
   }
/*DECRYPT FUNCTION - WORKS WIH ENCRYPT*/   
   function deCrypt($mode,$val,$hashed_val = ''){
          
          switch ($mode) {
            case 0:
                if(password_verify($val,$hashed_val)){ 
                       return true;
                }
              break;
            case 1:
                $key = base64_decode($val);
                return $key;
              break;
            
            default:
                if(password_verify($val,$hashed_val)){ 
                       return true;
                }
              break;
          }

   }
   function file_newname($path, $filename){
    if ($pos = strrpos($filename, '.')) {
           $name = substr($filename, 0, $pos);
           $ext = substr($filename, $pos);
    } else {
           $name = $filename;
		   $ext = "";
    }

    $newpath = $path.'/'.$filename;
    $newname = $filename;
    $counter = 0;
    while (file_exists($newpath)) {
           $newname = $name .'_'. $counter . $ext;
           $newpath = $path.'/'.$newname;
           $counter++;
     }

    return $newname;
}
?>