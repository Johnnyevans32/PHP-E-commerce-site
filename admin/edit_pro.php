<?php
    require 'confg/confg.php';
    if (!isset($_SESSION['username'])) {
        echo "<script>window.open ('logout.php?not_admin=You are not an Admin Officer!!','_self')</script>";
    }else{

?>
<?php
	if (isset($_GET['edit_pro'])) {
		$get_id = $_GET['edit_pro'];
		$get_pro = "SELECT * FROM product WHERE product_id ='$get_id'";
		$run_pro = mysqli_query($con, $get_pro);
		$i = 0;
		$row_pro=mysqli_fetch_array($run_pro);
		$pro_id = $row_pro['product_id'];	
		$product_title = $row_pro['product_title'];
		$product_cat = $row_pro['product_cat'];
		$product_price = $row_pro['product_price'];
		$product_desc = $row_pro['product_desc'];
		$product_keyword = $row_pro['product_keyword'];
		$product_image = $row_pro['product_image'];

		$get_cat = "SELECT * FROM categories WHERE `cat-id` = '$product_cat'";

		$run_cat = mysqli_query($con, $get_cat);

		$row_cat = mysqli_fetch_array($run_cat);
		$category_title = $row_cat['cat-title'];
	}
	
?>
<!DOCTYPE html>
<html>
<head>

	<title></title>
	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea'});</script>
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
		<table align="center" width="700" border="2" style="background-color: #052963; color: white;">
			<tr align="center">
				<td colspan="8"><h2>EDIT/UPDATE POST</h2></td>
			</tr>
			<tr>
				<td align="right">Product Title</td>
				<td><input type="text" size="50" name="product_title" value="<?php echo $product_title; ?>"></td>
			</tr>
			<tr>
				<td align="right">Product Category</td>
				<td>
					<select name="product_cat"> 
						<option><?php echo $category_title; ?></option>
						<?php
							$get_cats = "SELECT * FROM categories";
							$run_cats = mysqli_query($con, $get_cats);
							while ($row_cats=mysqli_fetch_array($run_cats) ){
								
								$cat_id = $row_cats['cat-id'];
								$cat_title = $row_cats['cat-title'];
								echo "<option value='$cat_id'>$cat_title</option>";

							} 
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">Product Image</td>
				<td><input type="file" name="product_image"><img src="image/<?php echo $product_image; ?>" width="50" height="50"></td>
			</tr>
			<tr>
				<td align="right">Product Price</td>
				<td><input type="text" name="product_price" value="<?php echo $product_price; ?>"></td>
			</tr>
			<tr>
				<td align="right">Product Description</td>
				<td><textarea name="product_desc" cols="20" rows="10"><?php echo $product_desc; ?></textarea></td>
			</tr>
			<tr>
				<td align="right">Product Keywords</td>
				<td><input type="text" size="50" name="product_keyword"  value="<?php echo $product_keyword; ?>"></td>
			</tr>
			<tr>
				<td colspan="8" align="center"><input type="submit" name="update_now" value="UPDATE"></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php

	if (isset($_POST['update_now'])) {
		$update_id = $pro_id;
		$product_title = $_POST['product_title'];
		$product_cat = $_POST['product_cat'];
		$product_price = $_POST['product_price'];
		$product_desc = $_POST['product_desc'];
		$product_keyword = $_POST['product_keyword'];
		$product_image = $_FILES['product_image']['name'];
		$product_image_tmp = $_FILES['product_image']['tmp_name'];

		move_uploaded_file($product_image_tmp, "admin_images/$product_image");





		$update_product = "UPDATE `product` SET product_cat='$product_cat',product_title='$product_title',product_price='$product_price',product_desc='$product_desc',product_image='$product_image',product_keyword='$product_keyword' WHERE product_id='$update_id'";
		$update_pro = mysqli_query($con, $update_product);
		if ($update_pro) {
			echo "<script>alert ('Product has been updated')</script>";
			echo "<script>window.open ('index.php?view_product','_self')</script>";
		}else{
			echo "bad";
		}
	}
?><?php } ?>