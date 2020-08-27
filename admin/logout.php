<?php
	session_start();

	require 'confg/confg.php';

	
	$none ="";
	
	if (isset($_POST['submit'])) {

		$username = mysqli_real_escape_string($con, $_POST['username']);
		$password = mysqli_real_escape_string($con, $_POST['pass']);

		
			$query = "SELECT user_id FROM admins WHERE username='$username' AND password = '$password'";	

			if ($query_run = mysqli_query($con, $query)) {
				$query_num_rows = mysqli_num_rows($query_run);
				if ($query_num_rows== 0) {

					$none= "<span class='btnb' style='text-align:center; background: linear-gradient(-90deg, red, yellow);' >Invalid password or username</span>";
				}elseif ($query_num_rows== 1) {
					$_SESSION['username'] = $username;
					echo "<script>window.open ('index.php?logged_in=YOU ARE LOGGED INTO ADMIN AREA!!','_self')</script>";;
				}
			}	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<title></title>
</head>
<body style=" min-height: 100vh; background-image: linear-gradient(120deg, #3498db, #8e44ad); ">
	<form method="POST" action="logout.php" style=" width: 360px; background: #f1f1f1; height: 480px; padding: 80px 40px; border-radius: 10px; position: absolute;left: 50%;top: 70%; transform: translate(-50%, -50%); ">
		<h1 style="text-align: center;color: red;"><?php echo @$_GET['not_admin']; ?></h1>
		<h1 style="text-align: center;color: red;"><?php echo @$_GET['logged_out']; ?></h1><br>
		<h1 style="text-align: center;">ADMIN LOGIN</h1>
		<div class="col">
	    	<input type="text" id="email" placeholder="USERNAME" name="username" required> 
	    	<span data_placeholder="Username"></span>
	    	
	    </div>
		<div class="col">
	    	<input type="password" class="form-control bg-dark text-white" placeholder="PASSWORD" name="pass" required>
	    	<span data_placeholder="Password"></span>
	    </div><?php echo $none ?><br>
			<input type="submit" name="submit" value="LOGIN" class="btn" style=" border: 1px solid white; ">	
		<div style="text-align: center;">
		<i class="fab fa-amazon" style="font-size:30px; color:black; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
		<i class="fab fa-app-store-ios" style="font-size:30px; color:white; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
		<i class="fab fa-facebook" style="font-size:30px; color:blue; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
		<i class="fab fa-git-square" style="font-size:30px; color:green; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
		<i class="fas fa-chess-knight" style="font-size:30px; color:gold; padding: 10px; text-shadow:2px 2px 4px #000000;"></i><br>
		<i class="fab fa-500px"></i> JohnnyEvans Copyright<br>2019		
		</div>
								
	</form>


	<script type="text/javascript">
		$(".col input").on("focus", function(){
			$(this).addClass("focus");
		});

		$(".col input").on("blur", function(){
			if ($(this).val()=="")
			$(this).removeClass("focus");
		});

	</script>
</body>
</html>