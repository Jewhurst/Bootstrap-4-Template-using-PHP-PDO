<?php
require_once '../inc/header.php'; 

if(isLoggedIn() != "") {

	redirect(0,HOME);

}

$msg=""; 

// If the values are posted, insert them into the database.

if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['email'])){
			$email = htmlspecialchars($_POST['email']);
			//if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$uname = htmlspecialchars($_POST['uname']);
		    $password = htmlspecialchars($_POST['password']);
		    $code = enCrypt(2,$uname);
		    $code = enCrypt(0,$code);
		    try {
		         $stmt = $db->prepare("SELECT uname,email FROM users WHERE uname=:uname OR email=:email");
		         $stmt->execute(array(':uname'=>$uname, ':email'=>$email));
		         $row=$stmt->fetch(PDO::FETCH_ASSOC);	    

		         if($row['uname']==$uname) {
		            $msg = "NAME IS TAKEN";
		         }
		         else if($row['email']==$email) {
		            $msg= "EMAIL IN USE";
		         } else {
		            if($data->register($uname,$email,$password,$code)) {
		                //$data->redirect(0,'login.php');  
		                $id = $data->getUID($uname,$email);
		                $key = enCrypt(1,$id);
					   	$id = $key;
					   	$message = "     

					      Hello $uname,

					      <br /><br />

					      Welcome to the NOTYETKNOWN!<br/>

					      To complete your registration  please , just click following link<br/>

					      <br /><br />

					      <a href='http://jewhurst.org/test/yardsale/verify.php?id=$id&code=$code&isfrom=$email'><b>Activate</b></a>

					      <br /><br />

					      Thanks!";

					      
					   	$subject = "Confirm Registration";
					   	$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: <info@jewhurst.org>' . "\r\n";
						//$headers .= 'Cc: myboss@example.com' . "\r\n";
					   	if(mail($email,$subject,$message,$headers)) {
					   		echo '<script language="javascript">';
							echo 'alert("Check your email to activate your account")';
							echo '</script>';
							 redirect(0,'login.php');
					   		 //$msg = "<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Success!</strong>  We've sent an email to $email.  Please click on the confirmation link in the email to create your account. </div>";

					   	} else {
					   		$msg="Email failed to send";
					   		redirect(0,'register.php');
					   	}
					  	
		            }
		         }
			}
			catch(PDOException $e) {
			        echo $e->getMessage();
			}

	//}	else {



	//	$msg= "for fucks sake";

	//}
}
    ?>
<?php ?>

<div class="row">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
					<div class="col-sm-4"></div><div class="col-sm-8"><h1 class="text-uppercase text-center">Sign Up</h1></div>

					<div class="col-sm-4"></div><div class="col-sm-8"><h1 style="text-align:center;" class="text-uppercase offred"><?php echo $msg?></h1></div>



			<form action="" method="POST" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 control-label">Username : </label>
					<div class="col-sm-8">
						<input id="uname" type="text" name="uname" placeholder="username" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">E-Mail : </label>
					<div class="col-sm-8">
						<input id="password" type="email" name="email" placeholder="email" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Password : </label>
					<div class="col-sm-8">
						<input id="password" type="password" name="password" placeholder="password"  class="form-control" >
					</div>
					</div>
				<div class="form-group">
					<div class="col-sm-4"></div>
					<div class="col-sm-8">
						<input class="btn btn-danger" type="submit" name="submit" value="Register" style="min-width:100%;" ><br>
				<p>Already signed up? Then <a class="text-bold" href="login.php">Login</a>
					</div>
					</div><br><br>
				</form>
			</div>
			<div class="col-lg-4"></div>
</div>
<?php include '../inc/footer.php'; ?>