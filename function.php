<?php


	function getcats(){
		global $con;

		$get_cats = "SELECT * FROM categories";
		$run_cats = mysqli_query($con, $get_cats);
		while ($row_cats=mysqli_fetch_array($run_cats) ){
			
			$cat_id = $row_cats['cat-id'];
			$cat_title = $row_cats['cat-title'];
			echo "<li class='btn-block'><a href='index.php?cat=$cat_id'>$cat_title</a></li>";

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
			            		<img class='card-img-top' alt='Some laptops' src='admin/admin_images/$pro_image' width='120' height='120''>
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
	function cart(){
		if (isset($_GET['add_cart'])) {
			global $con;

			$ip = getIp();
			$pro_id = $_GET['add_cart'];

			$check_pro = "SELECT * FROM carts WHERE ipadd='$ip'AND pid='$pro_id'";

			$run_check = mysqli_query($con, $check_pro);

			if (mysqli_num_rows($run_check)>0) {
				echo "";
			}else{

				$insert_pro= "INSERT INTO carts(pid,ipadd) VALUES('$pro_id','$ip')";
				mysqli_query($con, $insert_pro);
				echo "<script>window.open('index.php','_self')</script>";
			}
		}
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
			            		<img class='card-img-top' alt='Some laptops' src='admin/admin_images/$pro_image' width='120' height='120''>
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

?>