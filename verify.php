<?php
require_once 'inc/header.php'; 
$uname = "";
$time = 5;
$url= 'user/login.php';
if(isLoggedIn()) { redirect(0);}

if(isset($_GET['id']) && isset($_GET['code']) && isset($_GET['isfrom'])){
      $id = deCrypt(1,$_GET['id']);
      $code = $_GET['code'];      
      $email = $_GET['isfrom'];      
      $stmt = $data->runQuery("SELECT uid,uname,userActivated FROM users WHERE uid=:uid AND tokenCode=:code AND email = :email LIMIT 1");
      $stmt->execute(array(":uid"=>$id,":code"=>$code,":email"=>$email));
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
      if($stmt->rowCount() > 0)     {
            $uname = $row['uname'];
            $uid = $row['uid'];
            if($row['userActivated']== 0){
                 $stmt = $data->setActivated($row['uid']);
                 $url = "user/login.php";
                 $time = 30;                 
                 $msg = "<span class='text-uppercase'>Thank you <span class='offred text-uppercase'>$uname </span><br>your account is now activated</span>";
            } else{
                 $msg = "<span class='text-uppercase'>Hmm <span class='offred'>$uname</span>, your account is already activated</span>";
                 $url = "user/login.php";
                 $time = 5;
            }

      } else  {
            $msg = "<span class='text-uppercase'>No account found : <a href='register.php'>Signup here</a></span>";
            $url = "register.php";
            $time = 30;
      } 
}else {
    redirect(0);
}

?>
    <!-- Page Content --> 
  
  <div class="row box">
              <h2 class="text-center"><?php if(isset($msg)) { echo $msg; } ?></h2><br>
              <h3 class="text-center">This page will automatically redirect you back to login page in <span class=""><span id="countdown"><?php echo $time; ?></span> seconds</span>. Or click <a href="<?php echo HOME; ?>" class="bold">here</a> to go back now</h3>       
    </div>

      <div class="clear"></div>
      <script type="text/javascript">
          var timer = <?php echo $time; ?>,
          el = document.getElementById('countdown');
          (function t_minus() {
              'use strict';
              el.innerHTML = timer--;
              if (timer >= 0) {
                  setTimeout(function () {
                      t_minus();
                  }, 1000);
              } else {
                 window.location = "<?php echo HOME; ?>";
              }
          }());
                    </script>
      <?php include 'inc/footer.php'; ?>  