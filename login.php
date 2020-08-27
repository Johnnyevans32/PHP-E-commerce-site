<?php
	
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

				
				$query = "SELECT id FROM data WHERE username='$username' AND password = '$password'";	

				if ($query_run = mysqli_query($con, $query)) {
					$query_num_rows = mysqli_num_rows($query_run);
					if ($query_num_rows== 0) {
						$non = "<div class='alert alert-danger alert-dismissible fade show'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								<strong>Invalid Username/Password!!</strong>
							</div>";
					}
					$ip = getIp();
					$sel_cart = "SELECT * FROM carts WHERE ipadd='$ip'";
					$run_cart = mysqli_query($con, $sel_cart);
					$check_cart = mysqli_num_rows($run_cart);
					if ($query_num_rows>0 AND $check_cart==0) {
						$_SESSION['username'] = $username;
						echo "<script>alert ('login success!!')</script>";
						echo "<script>window.open('index.php','_self')</script>";
					}elseif ($query_num_rows>0 AND $check_cart>0) {
						$_SESSION['username'] = $username;
						echo "<script>alert ('login success!!')</script>";
						echo "<script>window.open('checkout.php','_self')</script>";
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
	<style type="text/css">
		div .cols{
			width: 20%;
			height: 100%;
			position: relative;
			animation-name: example;
			animation-duration: 10s;
			animation-iteration-count: infinite;
		}
		@keyframes example{
			0% {background-color: black;left: 0%;top: 0px;}
			25% {background-color: black;left: 80%;top: 0px;}
			50% {background-color: black;left: 0%;top: 0px;}
			75% {background-color: black;left: 80%;top: 0px;}
			100% {background-color: black;left: 0%;top: 0px;}
		}
		div .ball{
			width: 20px;
			height: 20px;
			border-radius: 10px;
			background-color: blue;
			position: relative;
			animation-name: examples;
			animation-duration: 10s;
			animation-iteration-count: infinite;
		}
		@keyframes examples{
			0% {background-color: blue;left: 0%;top: 0px;}
			25% {background-color: blue;left: 90%;top: 0px;}
			50% {background-color: blue;left: 0%;top: 0px;}
			75% {background-color: blue;left: 90%;top: 0px;}
			100% {background-color: blue;left: 0%;top: 0px;}
		}
	</style>
	<form method="POST" action="">
		<table style="color:white;width:100%;background-image: linear-gradient(-90deg, black, black);font-style:'Dosis-Regular.ttf'; padding: 0;text-align: center;" >
			<tr style="color:white;">
				<td><div class="cols"><h1>LOGIN</h1></div></td>
			</tr>
			<tr>

				<td><input type="text" id="email" placeholder="USERNAME" name="username" style="color: white;border: 1px solid grey;width: 50%;outline: none;background: none;padding: 0 5px;height: 40px;margin-bottom: 10px;" required></td>
			</tr>
			<tr>

				<td><input type="password" placeholder="PASSWORD" name="pass" style="font-size: 15px;color: white;border: 1px solid grey;width: 50%;outline: none;background: none;padding: 0 5px;height: 40px;margin-bottom: 10px;" required></td>
			</tr>
			<tr align="center">
				<td><img src="captcha.php" style="margin-bottom: 10px;"></td>
			</tr>
			<tr>
				<td><input type="text" name="secure" placeholder="ENTER THE CAPTCHA CODE!!" style="font-size: 15px;color: white;border: 1px solid grey;width: 50%;outline: none;background: none;padding: 0 5px;height: 40px;margin-bottom: 10px;"></td>
			</tr>
			<tr align="center">
			<td colspan="3"><input type="submit" name="submit" value="Login" class="btn" style=" display: block;width: 20%;height: 40px;border: 3px solid white;background:  linear-gradient(120deg, blue, black);background-size: 200%;margin-bottom: 10px;color: #fff;outline: none;cursor: pointer;transition: 0.5s;"></td>
			</tr><?php echo $none; ?><?php echo $non; ?>
			<tr align="center">
				<td colspan="3" style="color:white;margin-bottom: 10px;">Don't have an account <a href="reg.php">Sign Up</a></td>
			</tr><tr align="center">
				<td colspan="3" style="color:white;margin-bottom: 10px;"><a href="password.php">Forgot your password?</a></td>
			</tr>
			<tr>
				<td style="height: 50px;"><div class="ball"></div></td>
			</tr>
		</table>							
	</form>