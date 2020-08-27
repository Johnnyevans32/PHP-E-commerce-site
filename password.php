<?php
	session_start();
	require 'confg/confg.php';
	$none="";
	$non="";
	if (isset($_POST['submit'])) {
		
		if (!isset($_POST['secure'])) {
			$_SESSION['captcha_code'];
		}else{
			
			if ($_SESSION['captcha_code']==$_POST['secure']) {
				$username = mysqli_real_escape_string($con, $_POST['username']);
				$password = mysqli_real_escape_string($con, $_POST['pass']);

				
				$query = "SELECT id FROM data WHERE username='$username'";	

				if ($query_run = mysqli_query($con, $query)) {
					$query_num_rows = mysqli_num_rows($query_run);
					if ($query_num_rows==0) {
						$non = "<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<strong>Username does not exist!!</strong>
							</div>";
					}else{
						$Update= "UPDATE `data` SET `password`='$password' WHERE `username`='$username'";
						$Update_query = mysqli_query($con, $Update);
						if ($Update_query) {
							echo "<script>alert ('Congrats, Password Changed!!')</script>";
							echo "<script>window.open('checkout.php?login.php','_self')</script>";
						}else{

						}
					}
				}else {
					echo "<script>window.open('sad.html','_self')</script>";
				}
			}else{
				$none = "<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<strong>Invalid CAPTCHA Code!!</strong>
							</div>";
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
			<div class="color text-center" style="height: 600px; width: 100%; padding: 50px 10%;font-family: damn2; background-color: black; ">
				<form action="password.php" method="POST">
					<table style="color:white;width:100%;background-image: linear-gradient(-90deg, black, black);font-style:'Dosis-Regular.ttf'; padding: 0;text-align: center;" >
						<tr style="color:white;">
							<td><div class="cols"><h1>Change Your Password!!</h1></div></td>
						</tr>
						<tr>

							<td><input type="text" id="email" placeholder="YOUR USERNAME" name="username" style="color: white;border: 1px solid grey;width: 50%;outline: none;background: none;padding: 0 5px;height: 40px;margin-bottom: 10px;" required></td>
						</tr>
						<tr>

							<td><input type="password" placeholder="NEW PASSWORD" name="pass" style="font-size: 15px;color: white;border: 1px solid grey;width: 50%;outline: none;background: none;padding: 0 5px;height: 40px;margin-bottom: 10px;" required></td>
						</tr>
						<tr align="center">
							<td><img src="captcha.php" style="margin-bottom: 10px;"></td>
						</tr>
						<tr>
							<td><input type="text" name="secure" placeholder="ENTER THE CAPTCHA CODE!!" style="font-size: 15px;color: white;border: 1px solid grey;width: 50%;outline: none;background: none;padding: 0 5px;height: 40px;margin-bottom: 10px;"></td>
						</tr>
						<tr align="center">
						<td colspan="3"><input type="submit" name="submit" value="Update Password" class="btn" style=" display: block;width: 20%;height: 40px;border: 3px solid white;background:  linear-gradient(120deg, blue, black);background-size: 200%;margin-bottom: 10px;color: #fff;outline: none;cursor: pointer;transition: 0.5s;"></td>
						</tr><?php echo $none; ?><?php echo $non; ?>
						<tr>
							<td style="height: 50px;"><div class="ball"></div></td>
						</tr>
					</table>						
				</form>
			</div>
		</div>
	</div>
</body>
</html>