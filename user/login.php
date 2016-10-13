<?php 
require_once '../inc/header.php';
$msgresult = "";
if (isset($_POST['uname']) and isset($_POST['password'])){
		$uname = htmlspecialchars($_POST['uname']);
		$email = htmlspecialchars($_POST['uname']);
		$password = htmlspecialchars($_POST['password']);
		if($data->login($uname,$email,$password)){
			 if(isset($_GET['location'])) {
                redirect(0);
            } else {
			redirect(0);

            }
		}else{
			$msgresult = "Invalid Login Credentials";
		}
}
?>


    <!-- Page Content -->	
	<div class="row">
		<div class="col-lg-4"></div>
		<div class="col-lg-4">
			<div class="col-sm-4"></div>
			<div class="col-sm-8">
				<h1 style="text-align:center;" class="text-uppercase">Login</h1>
				<h1 style="text-align:center;" class="text-uppercase offred"><?php echo $msgresult;?></h1>
			</div>
				<form action="" method="POST" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-4 control-label">Username : </label>
						<div class="col-sm-8">
							<input id="uname" type="text" name="uname" placeholder="username"  class="form-control" >
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
									<input class="btn btn-primary" type="submit" name="submit" value="Login" style="min-width:100%;" >
									<br><br>
									<center><a href="forgotpassword.php">Forgot Password? </a><a href="register.php">Not registered? </a></center>
								</div>
					 </div>	
					</form>
		</div>
		<div class="col-lg-4"></div>
	</div>

			<div class="clear"></div>
			<?php include '../inc/footer.php'; ?> 