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
			echo "<li class='btn-block'><a class='dots' href='index.php?cat=$cat_id'>$cat_title</a></li>";

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
			            		$pro_title
			            	</div>
			            	<div class='card-body text-white'>
			            		<img class='card-img-top' alt='Some laptops' src='admin_images/$pro_image' width='120' height='120''>
				          	</div>$$pro_price
			             	<div class='card-footer text-center text-white' style='height:100%; border:1px solid black;  background-color:black;'>
			             		
			             		<a href='details.php?pro_id=$pro_id' class='card-link'><input type='button' name='BUY NOW' value='details'></a>
			             		<a href='index.php?add_cart=$pro_id'><button>Addtocart</button></a>
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
	function cart(){
		if (isset($_GET['add_cart'])) {
			global $con;

			$ip = getIp();
			$pro_id = $_GET['add_cart'];

			$check_pro = "SELECT * FROM carts WHERE ip_add='$ip'AND p_id='$pro_id'";

			$run_check = mysqli_query($con, $check_pro);

			if (mysqli_num_rows($run_check)>0) {
				echo "";
			}else{

				$insert_pro= "INSERT INTO carts(p_id,ip_add) VALUES('$pro_id','$ip')";
				mysqli_query($con, $insert_pro);
				echo "<script>window.open('index.php','_self')</script>";
			}
		}
	}
	function total_items(){
		if (isset($_GET['add_cart'])) {
			global $con;
			$ip = getIp();
			$get_items = "SELECT * FROM carts where ipadd = '$ip'";
			$run_items = mysqli_query($con, $get_items);
			$count_items = mysqli_num_rows($run_items);
			echo $count_items;
		}else{
			global $con;
			$ip = getIp();
			$get_items = "SELECT * FROM carts where ipadd = '$ip'";
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
				echo "<script>alert ('There is no Product in this category')</script>";
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
			            		<img class='card-img-top' alt='Some laptops' src='admin_images/$pro_image' width='120' height='120''>
				          	</div>$$pro_price
			             	<div class='card-footer text-center text-white' style='height:100%; border:1px solid black;  background-color:black;'>
			             		
			             		<a href='details.php?pro_id=$pro_id' class='card-link'><input type='button' name='BUY NOW' value='details'></a>
			             		<a href='index.php?pro_id=$pro_id' class='card-link'><input type='button' name='BUY NOW' value='Addtocart'></a>
			             	</div>
			            </div>
			        </div>
				";
			}	
		}	
	}
	//Remove Item From cart
	if (isset($_POST["removeItemFromCart"])) {
		$remove_id = $_POST["rid"];
		if (isset($_SESSION["uid"])) {
			$sql = "DELETE FROM carts WHERE pid='$remove_id' AND ipadd='$ip'";
		}
		if(mysqli_query($con,$sql)){
			echo "<div class='alert alert-danger'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is removed from cart</b>
					</div>";
			exit();
		}
	}


	//Update Item From cart
	if (isset($_POST["updateCartItem"])) {
		$update_id = $_POST["update_id"];
		$qty = $_POST["qty"];
		if (isset($_SESSION["uid"])) {
			$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND user_id = '$_SESSION[uid]'";
		}else{
			$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND ip_add = '$ip_add'";
		}
		if(mysqli_query($con,$sql)){
			echo "<div class='alert alert-info'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Product is updated</b>
					</div>";
			exit();
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
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js" ></script>
    <script type="text/javascript" src="js/bootstrap.min.js" ></script>
    
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
			src:url(DMoon 2.0 Regular 400.ttf);
		}
	</style>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-12">
					<h2 class="my-md-3 site-title"> <a class="navbar-brand" style="font-family: damn;" href="index.php"><img src="image/logo.png" width="30" height="30"><bold>JEVAN</bold></a></h2>
				</div>
				<div class="col-md-4 col-12 text-center text-white" style="padding: 20px;">
					<span>
						<span>
						<?php 
			    			if (!isset($_SESSION['username'])) {
			    				echo "<h3><em><b>WELCOME GUEST</b></em></h3>";
			    			}
			    		?>
		    		</span>
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
				        					<ul class='navbar-nav ml-auto'>
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
			    	<form method="GET" action="results.php" enctype="multipart/form-data">
			    		<div class="search-box">
							<input type="text" class="search-text" name="user_query" placeholder="Type to search">
		    				<button type="submit" class="search-btn" name="search"><i class="fas fa-search"></i></button>
			    		</div>
			    	</form>
			    </div>
			    <div class="navbar-nav">
			    	<li class="nav-item border rounded-circle mx-2 basket-icon">
			    		<a href="index.php"><i class="fas fa-shopping-basket p-2"><span class="badge"><?php total_items(); ?></span></i></a>
			    	</li>
			    </div>
			</nav>
		</div>
	</header>
	<div class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-10" style="padding: 0 30px;" id="product">
					<div class="row text-white" style="padding: 0 50px;">
						<div class="col mx-auto" style="padding: 20px 0; background-color: black;">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-2 col-xs-2"><b>Action</b></div>
									<div class="col-md-2 col-xs-2"><b>Product Image</b></div>
									<div class="col-md-2 col-xs-2"><b>Product Name</b></div>
									<div class="col-md-2 col-xs-2"><b>Quantity</b></div>
									<div class="col-md-2 col-xs-2"><b>Product Price</b></div>
									<div class="col-md-2 col-xs-2"><b>Price in $</b></div>
								</div>
								<div id="cart_checkout"></div>
								<?php 
									$total = 0;
									$ip = getIp();


									
									$sel_price = "SELECT * FROM carts where ipadd = '$ip'";

									$run_price = mysqli_query($con, $sel_price);
									while ($p_price=mysqli_fetch_array($run_price)) {
										$pro_id = $p_price['pid'];
										$pro_price = "SELECT * FROM product WHERE product_id='$pro_id'";
										$run_pro_price = mysqli_query($con, $pro_price);
										while ($pp_price=mysqli_fetch_array($run_pro_price)) {
											$product_price = array($pp_price['product_price']);
											$product_title = $pp_price['product_title'];
											$product_image = $pp_price['product_image'];
											@$single_price = $pp_price['product_price'];
											$qty = 1;
											$values = array_sum($product_price);
											$total += $values;								
								?>
								<div class="row">
									<div class="col-md-2">
										<div class="btn-group">
											<a href="#"  remove_id="'<?php echo $pro_id; ?>'" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
											<a href="#"  update_id="'<?php echo $pro_id; ?>'" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span></a>
										</div>
									</div>
									<div class="col-md-2"><img src="admin/admin_images/<?php echo $product_image; ?>" width="50" height="50"></div><br>
									<div class="col-md-2"><?php echo $product_title; ?></div>
									<div class="col-md-2"><input type='text' class='form-control' value='1' ></div>
									<div class="col-md-2"><input type='text' class='form-control' value='<?php echo $single_price; ?>' disabled></div>
									<div class="col-md-2"><input type='text' class='form-control' value='<?php echo $qty*$single_price; ?>' disabled></div>
								</div><?php } } ?>
								<div class="row">
									<div class="col-md-8"></div>
									<div class="col-md-4">
										<b>Total :<?php echo "$", $total; ?></b>
									</div>
								</div> 
							</div>
							<?php  ?>
							<?php
								if (isset($_POST['update_cart'])) {
									$qty = $_POST['qty'];
									$update_qty = "UPDATE carts SET qty='$qty'";
									$run_qty = mysqli_query($con, $update_qty);

									$_SESSION['qty'] = $qty;
									$total = $total*$qty;
								}
							?>
					
							<?php
					
								$ip = getIp();

								if (isset($_POST['remove_cart'])) {
									foreach ($_POST['remove'] as $remove_id) {
										$delete_product = "DELETE FROM carts WHERE pid='$remove_id' AND ipadd='$ip'";
										$run_delete = mysqli_query($con, $delete_product);
										if ($run_delete) {
											echo "<script>window.open ('cart.php','_self')</script>";
										}
									}
								}
								if (isset($_POST['continue'])) {
									echo "<script>window.open ('index.php','_self')</script>";
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="site-slider-2 px-md-4">
				<div class="slider-2 text-center">
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
	<footer class="container-fluid text-white" style="margin-top: 30px;font-family: damn; background-color: black; padding:30px;">
		<div class="row">
			<div class="col">
				<h2><bold>Evans is an Aspiring Web Developer...</bold></h2>
				<h4 style="color:grey;">No Pain, No Gain</h4><br><br>
				<h5><bold>CODED AND DESIGNED BY <img src="image/logo1.png" style=" width:30px; height:30px; padding: 0px 0px; margin: auto;  "> J-E</bold></h5>
			</div>
			<div class="col" data-aos="fade-left" style="font-family: damn2;">
				<div class="row">
					<div class="col">
						<section>
							<ul>
								<h5> <a href="#">Learn More</a> </h5>
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
							<ul>
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
					<i class="fa fa-amazon" style="font-size:30px; color:black; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fa fa-app-store-ios" style="font-size:30px; color:white; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fa fa-facebook" style="font-size:30px; color:blue; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fa fa-git-square" style="font-size:30px; color:green; padding: 10px; text-shadow:2px 2px 4px #000000;"></i>
					<i class="fas fa-chess-knight" style="font-size:30px; color:gold; padding: 10px; text-shadow:2px 2px 4px #000000;"></i><br>
					<i class="fa fa-500px"></i> JohnnyEvans Copyright<br>2019
				</div>
			</div>
		</div>
	</footer>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>