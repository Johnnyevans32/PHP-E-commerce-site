<?php 
	session_start();
	require 'confg/confg.php';
	$none ="";
	$non ="";
	function getIp(){
		$ip = $_SERVER['REMOTE_ADDR'];

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		return $ip;
	}
	if (isset($_POST['submit'])) {

		if (!isset($_POST['secure'])) {
			$_SESSION['captcha_code'];
		}else{

			if ($_SESSION['captcha_code']==$_POST['secure']) {
				$username = $_POST['username'];
				$password = $_POST['pass'];
				$name = $_POST['name'];
				

				if (!empty($username) AND !empty($password)	AND	!empty($name)){
					$s = "SELECT * FROM data WHERE username ='$username'";
					$result = mysqli_query($con, $s);
					if(mysqli_num_rows($result)==1)	{
						$non = "<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<strong>Username already exists</strong>
							</div>";
					}else{
						$reg = "INSERT INTO data(username, password, name) VALUES ('$username', '$password', '$name')";
						mysqli_query($con, $reg);
						$ip = getip();
						$sel_cart = "SELECT * FROM carts WHERE ipadd='$ip'";
						$run_cart = mysqli_query($con, $sel_cart);
						$check_cart = mysqli_num_rows($run_cart);
						if ($check_cart==0) {
							echo "<script>alert ('registration success!!')</script>";
							echo "<script>window.open('index.php','_self')</script>";
						}else{
							echo "<script>alert ('registration success!!')</script>";
							echo "<script>window.open('checkout.php?login.php','_self')</script>";
						}
						
					}
				}else {
					$none= "<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<strong>All fields are required.</strong>
							</div>"
					;
				}
			}else{
				echo "<script>alert ('Invalid Captcha Code!!')</script>";
				$_SESSION['captcha_code'];
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
       <link rel="stylesheet" type="text/css" href="css/fontawesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js" ></script>
    <script type="text/javascript" src="js/bootstrap.min.js" ></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<title>REG FORM</title>
</head>
<body>
	<style type="text/css">
		@font-face{
			font-family: damn;
			src:url(Anders.ttf);
		}
		@font-face{
			font-family: damn1;
			src:url(koliko.ttf);
		}
		@font-face{
			font-family: damn2;
			src:url(Genera-AltLight.ttf);
		}
		@font-face{
			font-family: damn3;
			src:url(Dosis-Regular.ttf);
		}
		@font-face{
			font-family: damn4;
			src:url(DMoon 2.0 Regular 400.ttf);
		}
	</style>
	<div class="main text-white text-center" style="height: 100%; width: 100%; ">
		<div class="row">
			<div class="col-sm-6" style="height: 600px; width: 100%; padding: 100px 30px;background-image:  linear-gradient(120deg, red, yellow); ">
				<div class="container" style="height:50px; ">
					<div class="row">
						<div class="col">
							<h2 class="my-md-3 site-title"> <a class="navbar-brand" style="font-family: damn;font-size: 50px;" href="index.php"><img src="image/logo.png" width="50" height="50"><bold>JEVAN</bold></a></h2>
						</div>
					</div>
				</div>
				<div class="container text-center" style="padding: 20px 0; font-family: damn2; ">
					<div class="row">
						<div class="col">
							<h3>Register to join my elite system for master class Ecommerce services</h3>
						</div>
					</div>
				</div>
				<div class="container text-center" >
					<div class="row">
						<div class="col">
							<i class="fab fa-amazon" style="font-size:30px; color:black; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
							<i class="fab fa-app-store-ios" style="font-size:30px; color:white; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
							<i class="fab fa-facebook" style="font-size:30px; color:blue; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
							<i class="fab fa-git-square" style="font-size:30px; color:green; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
							<i class="fas fa-chess-knight" style="font-size:30px; color:gold; padding: 10px; text-shadow:2px 2px 4px #000000;"></i><br>
							<h4 style="font-family: damn2;"><i class="fab fa-500px"></i>JohnnyEvans Copyright<br>2019</h4>
						</div>
					</div>
				</div>
			</div> 
			<div class="col-sm-6 text-center" style="height: 600px; width: 100%; padding: 50px 10%;font-family: damn2; background-color: red; ">
				<form action="reg.php" method="POST">
					<h3>REGISTER TODAY!!</h3>
					<label>
						USERNAME
					</label>
					<input type="text" class="btn btn-block btn-dark text-white" name="username">
					
					<label>
						PASSWORD
					</label>
					<input type="password"	 class="btn btn-block btn-dark text-white" name="pass">
					<label>
					<label>
						FULL NAME
					</label>
					<input type="text"  class="btn btn-block btn-dark text-white" name="name">
					
					<img src="captcha.php" style="margin-bottom: 10px;margin-top: 10px;">
					<input type="text" class= "btn btn-block btn-dark text-white"name="secure" placeholder="ENTER THE CAPTCHA CODE!!">
					<button  type="submit" class="button" name="submit"><span>Register</span></button>
					<?php echo $none?><?php echo $non ?>
				</form>
				<h5>Have an account already <a href="checkout.php?login.php">login</a></h5>
			</div>
		</div>
	</div>
</body>
</html>