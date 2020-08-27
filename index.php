<?php
	session_start();
	require 'confg/confg.php';



	function getcats(){
		global $con;

		$get_cats = "SELECT * FROM categories";
		$run_cats = mysqli_query($con, $get_cats);
		while ($row_cats=mysqli_fetch_array($run_cats) ){
			
			$cat_id = $row_cats['cat-id'];
			$cat_title = $row_cats['cat-title'];
			echo "<li class='btn-block'><a href='index.php?cat=$cat_id' class='dots'>$cat_title</a></li>";

		}
	}

	function getpro(){

		if (!isset($_GET['cat'])) {
			global $con;
			$get_pro =  "SELECT * FROM product ORDER BY RAND() LIMIT 0,6";
			$run_pro = mysqli_query($con, $get_pro);

			while ($row_pro=mysqli_fetch_array($run_pro) ){
				$pro_title = $row_pro['product_title'];
				$pro_id = $row_pro['product_id'];

				$pro_price = $row_pro['product_price'];
				$pro_image = $row_pro['product_image'];
				echo "
					<div class='col-md-4 text-center' style='padding:0;'>
			            <div class='card'>
			            	<div class='card-head text-center text-white' style='padding:20px; border:1px solid black; background-color:black;'>
			            		<b>$pro_title</b>
			            	</div>
			            	<div class='card-body text-white'>
			            		<img class='card-img-top' alt='Some laptops' src='admin/admin_images/$pro_image' width='120' height='120'>
				          	</div>$$pro_price
			             	<div class='card-footer text-center text-white'>
			             		
			             		<a href='details.php?pro_id=$pro_id' class='card-link'><span><i class='fas fa-clipboard-list'></i></span></a>
			             		<a href='index.php?add_cart=$pro_id'><span><i class='fa fa-cart-plus'></i></span></a>
			             	</div>
			            </div>
			        </div>
				";
			}	
		}	
	}
	function getIp(){
		$ip = $_SERVER['REMOTE_ADDR'];

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		return $ip;
	}
	function total_items(){
		if (isset($_GET['add_cart'])) {
			global $con;
			$ip = getIp();
			$get_items = "SELECT * FROM `carts` WHERE `ipadd` = '$ip'";
			$run_items = mysqli_query($con, $get_items);
			$count_items = mysqli_num_rows($run_items);
			echo $count_items;
		}else{
			global $con;
			$ip = getIp();
			$get_items = "SELECT * FROM `carts` WHERE `ipadd` = '$ip'";
			$run_items = mysqli_query($con, $get_items);
			$count_items = mysqli_num_rows($run_items);
			echo $count_items;
		}
	}
	function total_price(){
		$total = 0;

		global $con;
		$ip = getIp();
		$sel_price = "SELECT * FROM carts where ipadd = '$ip'";

		$run_price = mysqli_query($con, $sel_price);
		while ($p_price=mysqli_fetch_array($run_price)) {
			$pro_id = $p_price['pid'];
			$pro_price = "SELECT * FROM product WHERE product_id='$pro_id'";
			$run_pro_price = mysqli_query($con, $pro_price);
			while ($pp_price=mysqli_fetch_array($run_pro_price)) {
				$product_price = array($pp_price['product_price']);
				$values = array_sum($product_price);
				$total +=$values;
			}
		}
		echo "$".$total;
	}
	function getcatpro(){

		if (isset($_GET['cat'])) {
			global $con;
			$cat_id = $_GET['cat'];
			$get_cat_pro =  "SELECT * FROM product WHERE product_cat = '$cat_id'";
			$run_cat_pro = mysqli_query($con, $get_cat_pro);

			$count_cat = mysqli_num_rows($run_cat_pro);
			if ($count_cat==0) {
				echo "<h1>No Products Available Here!!</h1>";
			}
			while ($row_cat_pro=mysqli_fetch_array($run_cat_pro) ){
				$pro_title = $row_cat_pro['product_title'];
				$pro_id = $row_cat_pro['product_id'];

				$pro_price = $row_cat_pro['product_price'];
				$pro_image = $row_cat_pro['product_image'];
				echo "
					<div class='col-md-4 text-center' style='padding:0;'>
			            <div class='card'>
			            	<div class='card-head text-center text-white' style='padding:20px; border:1px solid black; background-color:black;'>
			            		$pro_title
			            	</div>
			            	<div class='card-body text-center text-white'>
			            		<img class='card-img-top' alt='Some laptops' src='admin/admin_images/$pro_image' width='120' height='120'>
				          	</div>$$pro_price
			             	<div class='card-footer text-center text-white'>
			             		
			             		<a href='details.php?pro_id=$pro_id' class='card-link'><span><i class='fas fa-clipboard-list'></i></span></a>
			             		<a href='index.php?pro_id=$pro_id'><span><i class='fa fa-cart-plus'></i></span></a>
			             	</div>
			            </div>
			        </div>
				";
			}	
		}	
	}
		function cart(){
		if (isset($_GET['add_cart'])) {
			global $con;

			$ip = getIp();
			$pro_id = $_GET['add_cart'];

			$check_pro = "SELECT * FROM `carts` WHERE `pid` = '$pro_id' AND `ipadd` = '$ip'";

			$run_check = mysqli_query($con, $check_pro);

			if (mysqli_num_rows($run_check)>0) {
				echo "";
			}else{
				$insert_pro= "INSERT INTO `carts` (`pid`, `ipadd`) VALUES ('$pro_id', '$ip') ";
				$insert_check= mysqli_query($con, $insert_pro);
				if ($insert_check) {
					echo "ok";
					#echo "<script>window.open('index.php','_self')</script>";
				}else{
					echo "bitch";
				}
			}
		}else{
			echo "eva";
		}
	}
	function cartinsert(){
		if(isset($_GET["add_cart"])){
			global $con;
			$ip = getIp();
			$pro_id = $_GET['add_cart'];

			$sql = "SELECT * FROM carts WHERE pid = '$pro_id' AND ipadd = '$ip'";
			$run_query = mysqli_query($con,$sql);
			$count = mysqli_num_rows($run_query);
			if($count > 0){
				echo "
					<script>alert ('Product is already added into the cart Continue Shopping..')</script>
				";
			}else {
				$sql = "INSERT INTO `carts`
				(`pid`, `ipadd`,`qty`) 
				VALUES ('$pro_id','$ip','1')";
				if(mysqli_query($con,$sql)){

					echo "<script>window.open('index.php','_self')</script>";
				}
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
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js" ></script>
    <script type="text/javascript" src="js/bootstrap.min.js" ></script>
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<title></title>
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
			src:url(Moon 2.0 Regular 400.ttf);
		}
	</style>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-12">
					<h2 class="my-md-3 site-title" style="font-family: damn;"> <a class="navbar-brand" href="index.php"><img src="logo_size.jpg" width="180" height="30"></a></h2>
				</div>
				<div class="col-md-4 col-12 text-center text-white" style="padding: 20px;">
					<span>
						<?php 
			    			if (!isset($_SESSION['username'])) {
			    				echo "<h3><em><b>WELCOME GUEST</b></em></h3>";
			    			}
			    		?>
		    		</span>
				</div>
				<div class="col-md-4 col-12 text-right">
					<p class="my-md-4">
						<?php 
			    			if (!isset($_SESSION['username'])) {
			    				echo "<a class='opt' href='checkout.php'>Login</a>|<a class='opt' href='reg.php'>Sign Up</a>";

			    			}else{
			    				$name = $_SESSION['username'];
			    				echo 
			    					"<nav class='navbar navbar-expand-lg navbar-dark'>
				    					
				    					<div class='navbar-collapse'>
				        					<ul class='navbar-nav ml-auto mb-2'>
				        						<li class='nav-item dropdown'>
										        	<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
										            	HI, $name <i class='fa fa-gear'></i>
										            </a>
										            <div class='dropdown-menu text-dark'>
											            <a class='dropdown-item' href='out.php'>Logout</a>
										            </div>
					        					</li>
					        				</ul>
					        			</div>
					        		</nav>"
				        		;
			    			}
			    		?>	
		    		</p>
				</div>
			</div>	
		</div>
		<div class="container-fluid p-0">
			<nav class="navbar  navbar-expand-lg navbar-light bg-light sticky-top">
			    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			   		<span class="navbar-toggler-icon"></span>
			    </button>

			    <div class="collapse navbar-collapse" id="navbarSupportedContent">
			        <ul class="navbar-nav">
				        <li class="nav-item active">
				        	<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				        </li>
				        <li class="nav-item">
				       		<a class="nav-link" href="my_account.php">About Us</a>
				        </li>
				        <li class="nav-item ">
				        	<a class="nav-link" href="all_products.php">All Products</a>
				        </li>		        
			        </ul>
			        <form method="GET" class="form my-2 my-lg-0" action="results.php" enctype="multipart/form-data">
			    		<div class="search-box">
							<input type="text" class="search-text" name="user_query" placeholder="Type to search">
		    				<button type="submit" class="search-btn" name="search"><i class="fas fa-search"></i></button>
			    		</div>
			    	</form>
			    </div>
			    <div class="navbar-nav">
			    	<li class="nav-item border rounded-circle mx-2 basket-icon">
			    		<a href="cart.php"><i class="fas fa-shopping-basket p-2"><span class="badge"><?php total_items(); ?></span></i></a>
			    	</li>
			    </div>
			</nav>
		</div>
	</header>
	<div class="main">
		<div class="container-fluid">
			<div class="site-slider">
				<div class="slider-1">
					<div><img src="image/3 (2).jpg" style="width: 100%;height: 66.4%;" class="img-fluid" alt="Banner-1"/></div>
					<div><img src="image/3 (26).jpg" style="width: 100%;height: 66.4%;" class="img-fluid" alt="Banner-2"/></div>
					<div><img src="image/3 (5).jpg" style="width: 100%;height: 66.4%;" class="img-fluid" alt="Banner-3"/></div>
					<div><img src="image/3 (23).jpg" style="width: 100%;height: 66.4%;" class="img-fluid" alt="Banner-4"/></div>
					<div><img src="image/3 (24).jpg" style="width: 100%;height: 66.4%;" class="img-fluid" alt="Banner-5"/></div>
				</div>
				<div class="slider-btn">
					<span class="prev position-top"><i class="fas fa-chevron-left"></i></span>
					<span class="next position-top right-0"><i class="fas fa-chevron-right"></i></span>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="site-slider-2 px-md-4">
				<div class="slider-2 text-center">
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/1 (24).jpg" style="width: 100%;height: 100%;" alt="product 1">
						<span class="border site-btn btn-span">GAMEPADS</span>
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/1 (18).jpg" style="width: 100%;height: 100%;" alt="product 2">
						<span class="border site-btn btn-span">HEADPHONES</span>
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/3 (3).jpg" style="width: 100%;height: 100%;" alt="product 3">
						<span class="border site-btn btn-span">GPU</span>
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/3 (13).jpg" style="width: 100%;height: 100%;" alt="product 4">
						<span class="border site-btn btn-span">LAPTOP</span>
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/iphone.png" style="width: 100%;height: 100%;" alt="product 5">
						<span class="border site-btn btn-span">PHONES</span>
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/1 (24).jpg" style="width: 100%;height: 100%;" alt="product 6">
						<span class="border site-btn btn-span">GAMEPADS</span>
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/1 (18).jpg" style="width: 100%;height: 100%;" alt="product 7">
						<span class="border site-btn btn-span">HEADPHONES</span>
					</div>
				</div>
				<div class="slider-btn">
					<span class="prev position-top"><i class="fas fa-chevron-left"></i></span>
					<span class="next position-top right-0"><i class="fas fa-chevron-right"></i></span>
				</div>
			</div>
		</div><br><br>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2 text-left"  style="padding: 0 20px;">
					<div class="nav nav-pills nav-stacked" id="cats" data-aos="fade-left" data-aos-anchor="#example-anchor" data-aos-offset="500" data-aos-duration="500">
						<li style="background-color: black; width: 100%; margin-bottom: 10px;"><a href="#" style="text-decoration: none;color: white;"><h4>Categories</h4></a></li>
						<?php getcats(); ?><br><br>

						<video controls width="100%">
							<source src="video/gun.mp4" type="video/mp4" style="height: 200px; margin-top: 50px;" >
						</video>

					</div>
				</div>
				<div class="col-md-10 text-center" style="padding: 0 30px;" id="product">
					<div class="row" data-aos="fade-left" >
						<?php getpro(); ?>
						<?php cartinsert(); ?>
						<?php getcatpro(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="site-slider-2 px-md-4">
				<div class="slider-2 text-center" data-aos="fade-down"data-aos-easing="linear" data-aos-duration="1500">
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/burgerking.png" style="width: 100%;height: 100%;" alt="product 1">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/numark.png" style="width: 100%;height: 100%;" alt="product 2">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="admin/image/apple--eps--vector-logo.png" style="width: 100%;height: 100%;" alt="product 3">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/sony.png" style="width: 100%;height: 100%;" alt="product 4">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="admin/image/amazon-logo-vector.png" style="width: 100%;height: 100%;" alt="product 5">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="image/logo.png" style="width: 100%;height: 100%;" alt="product 1">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="admin/image/xiaomi-logo.png" style="width: 100%;height: 100%;" alt="product 2">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="admin/image/cnn_vector_free_logo.jpg" style="width: 100%;height: 100%;" alt="product 2">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="admin/image/hp-logo-vector-download.jpg" style="width: 100%;height: 100%;" alt="product 2">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="admin/image/cartoon_network_vector_free_logo.jpg" style="width: 100%;height: 100%;" alt="product 2">
					</div>
					<div class="col-md-2 col-sm-12 product pt-md-5 pt-4">
						<img src="admin/image/microsoft-xbox--eps--vector-logo.png" style="width: 100%;height: 100%;" alt="product 2">
					</div>
				</div><br><br>
				<div class="slider-btn">
					<span class="prev position-top"><i class="fas fa-chevron-left"></i></span>
					<span class="next position-top right-0"><i class="fas fa-chevron-right"></i></span>
				</div>
			</div>
		</div>
	</div>
	<footer class="container-fluid text-white" style="margin-top: 30px; background-color: black; padding:30px;font-family: damn;font-size: 10px;" data-aos="zoom-in-left">
		<div class="row">
			<div class="col">
				<h2 style="text-shadow: 3px solid red;"><bold>Evans is an Aspiring Web Developer...</bold></h2>
				<h4 style="color:grey;">No Pain, No Gain</h4><br><br>
				<h5><bold>CODED AND DESIGNED BY <img src="logo_size.jpg" width="180" height="30"></bold></h5>
			</div>
			<div class="col" data-aos="fade-left" style="font-family: damn2;">
				<div class="row" >
					<div class="col">
						<section>
							<ul>
								<h5><a href="#">Learn More</a> </h5>
								<h6><a href="#">How it works</a> </h6>
								<h6><a href="#">Meeting Tools</a> </h6>
								<h6><a href="#">Live Streaming</a> </h6>
								<h6><a href="#">Contact Methods</a> </h6>
								<h6><a href="#">Support</a> </h6>
							</ul>
						</section>
					</div>
					<div class="col">
						<section>
							<ul >
								<h5><a href="#"> About Us</a></h5>
								<h6><a href="#"> Team</a></h6>
								<h6><a href="#"> Features</a></h6>
								<h6><a href="#"> Privacy Policy</a></h6>
								<h6><a href="#"> Terms and Condition</a></h6>
							</ul>
						</section>
					</div>
					<div class="col">
						<section>
							<ul>
								<h5> <a href="#"> Support</a></h5>
								<h6><a href="#"> FAQ</a></h6>
								<h6><a href="#"> Contact Us</a></h6>
								<h6><a href="#"> Live Chat</a></h6>
								<h6><a href="#">Phone Call</a> </h6>
							</ul>
						</section>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid text-center text-white">
			<div class="row">
				<div class="col">
					<i class="fab fa-amazon" style="font-size:30px; color:white; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fab fa-app-store-ios" style="font-size:30px; color:white; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fab fa-whatsapp" style="font-size:30px; color:white; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fab fa-facebook" style="font-size:30px; color:blue; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fab fa-git-square" style="font-size:30px; color:green; padding: 10px; text-shadow:2px 2px 4px #000000;"></i><br>
					<i class="fab fa-500px"></i> JohnnyEvans Copyright<br>2019
				</div>
			</div>
		</div>
	</footer>
	
	<script type="text/javascript" src="js/main.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<script type="text/javascript">
	  AOS.init();
	</script>
	
</body>
</html>
