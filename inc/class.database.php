<?php
/* THIS IS THE DATABASE THAT WE WILL USE TO MAKE CALLS TO THE DATABASE*/
class dbconnect {
	/*THIS IS THE INITIAL SETUP*/
    private $db; 
	/*
	THIS FUNCTION IS SO YOU CAN USE SINGLE CALLS OUTSIDE THE CLASS SECTION
	EXAMPLE: ON THE INDEX PAGE YOU WILL SEE AN EXAMPLE OF THE SAME EXACT CALL AS 
	BELOW BUT DONE ON THE FLY HARDCODED IN A PAGE	
	*/
    public function __construct()  {
          global $db;
          $this->db = $db;
    }    
	
	
	/*THESE ARE FUNCTIONS YOU CAN USE WITHIN YOUR SITE*/
	public function getSiteOption($optionName){
		try{		
			$stmt = $this->db->prepare("SELECT optionValue FROM site_options WHERE optionName = :optionName");
			$stmt->execute(array(':optionName'=>$optionName));
			$val=$stmt->fetch(PDO::FETCH_ASSOC);
			return $val['optionValue'];			
		} catch(PDOException $e) {
            echo $e->getMessage();
       } 
   }
      public function getUID($uname,$email){
          $stmt = $this->db->prepare("SELECT * from users WHERE uname = :uname AND email = :email");
          $stmt->execute(array(':uname'=>$uname, ':email'=>$email));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0) {
                $uid = $userRow['uid'];
                return $uid;
          }
   }
      public function runQuery($sql)  {
         $stmt = $this->db->prepare($sql);
         return $stmt;
   }   

   public function lasdID() {
         $stmt = $this->db->lastInsertId();
         return $stmt;
   }
	public function getRowCount($select,$table,$where,$column = ''){ 
		if($column == '') { $column = $select;}
		$stmt = $this->db->prepare('SELECT '.$select.' FROM '.$table.' WHERE '.$column.' = :where');
		$stmt->execute(array(':where' => $where));
		$rowCount = $stmt->rowCount();
		return $rowCount;
	}
   /****************SITE ACCOUNT FUNCTIONS*********************************************************/	
    public function register($uname,$email,$password,$code) {
       try {
           $new_password = password_hash($password, PASSWORD_DEFAULT);
		   $uslug = slug($uname);
           $stmt = $this->db->prepare("INSERT INTO users(uname,uslug,email,password,tokenCode) 
                                                       VALUES(:uname,:uslug, :email, :password, :tokenCode)");
           $stmt->bindparam(":uname", $uname);
           $stmt->bindparam(":uslug", $uslug);
           $stmt->bindparam(":email", $email);
           $stmt->bindparam(":password", $new_password);
           $stmt->bindparam(":tokenCode", $code);
           $stmt->execute(); 
           return $stmt; 
       }
       catch(PDOException $e) {
           echo $e->getMessage();
       }    
    }
   public function setActivated($uid){
        try { 
			$stmt = $this->db->prepare("UPDATE users SET userActivated = 1 WHERE uid = :uid");
			$stmt->bindparam(":uid", $uid);
			if($stmt->execute()){ return true;} else {return false;}
		  
		}
       catch(PDOException $e) {
           echo $e->getMessage();
       }   

   }
   public function isUserActivated($email){
	   try{
          $stmt = $this->db->prepare("SELECT userActivated from users WHERE email = :email");
          $stmt->bindparam(":email", $email);
          $stmt->execute();
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0) {
                $activated = $userRow['userActivated'];
                if($activated == 1) {
                  return true;
                } else {
                  return false;
                }
          } else {
            return false;
          }
		}
       catch(PDOException $e) {
           echo $e->getMessage();
       }  
   }
    public function login($uname,$email,$password) {
       try {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE uname=:uname OR email=:email");
          $stmt->execute(array(':uname'=>$uname, ':email'=>$email));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0) {
             if(password_verify($password, $userRow['password'])) {
                $_SESSION['uid'] = $userRow['uid'];
                $_SESSION['uname'] = $userRow['uname'];
                $_SESSION['isAdmin'] = $userRow['isAdmin'];
                $_SESSION['loggedin'] = true;
                $stmt = $this->db->prepare("UPDATE users SET isOnline = 1 WHERE uname=:uname AND uid=:uid");
                $stmt->execute(array(':uname'=>$_SESSION['uname'],':uid'=>$_SESSION['uid'])); 
                return true;
             } else {
                return false;
             }
          }
       }
       catch(PDOException $e) {
           echo $e->getMessage();
       }
   }
   public function resetPassword($pw,$confirmpw,$uid) {
       
             if($pw===$confirmpw){
                    $securepw = encrypt(1,$confirmpw);
                    $stmt = $this->db->prepare("UPDATE users SET password=:password WHERE uid=:uid");
                    $stmt->execute(array(":password"=>$securepw,":uid"=>$uid));
                    return true;
                 
             } else{
                    return false;                    
             }


   }
   public function logout(){        
		if(isset($uname) && isset($uid)) {
          $stmt = $this->db->prepare("UPDATE users SET isOnline = 0 WHERE uname=:uname AND uid=:uid");
          $stmt->execute(array(':uname'=>$uname,':uid'=>$uid));
        }
        if(isset($_SESSION['uname'])){ $uname = $_SESSION['uname']; unset($_SESSION['uname']); }
        if(isset($_SESSION['uid'])){$uid = $_SESSION['uid'];unset($_SESSION['uid']); }
        if(isset($_SESSION['loggedin'])){unset($_SESSION['loggedin']);}
        if(isset($_SESSION['lastactive'])){unset($_SESSION['lastactive']);}
        if(isset($_SESSION)){session_destroy();}

        return true;
   }
 
}
?>