<?php
	require 'confg/confg.php';

	
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
		<table align="center" width="700" border="2" style="background-color: #052963;color: white;">
			<tr align="center">
				<td colspan="8"><h2>INSERT NEW POST</h2></td>
			</tr>
			<tr>
				<td align="right">Product Title</td>
				<td><input type="text" size="50" name="product_title"></td>
			</tr>
			<tr>
				<td align="right">Product Category</td>
				<td>
					<select name="product_cat"> 
						<option>Select a  Category</option>
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
				<td><input type="file" name="product_image"></td>
			</tr>
			<tr>
				<td align="right">Product Price</td>
				<td><input type="text" name="product_price"></td>
			</tr>
			<tr>
				<td align="right">Product Description</td>
				<td><textarea name="product_desc" cols="20" rows="10"></textarea></td>
			</tr>
			<tr>
				<td align="right">Product Keywords</td>
				<td><input type="text" size="50" name="product_keyword"></td>
			</tr>
			<tr>
				<td colspan="8" align="center"><input type="submit" name="insert_now" value="INSERT"></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php

	if (isset($_POST['insert_now'])) {
		$product_title = $_POST['product_title'];
		$product_cat = $_POST['product_cat'];
		$product_price = $_POST['product_price'];
		$product_desc = $_POST['product_desc'];
		$product_keyword = $_POST['product_keyword'];
		$product_image = $_FILES['product_image']['name'];
		$product_image_tmp = $_FILES['product_image']['tmp_name'];

		move_uploaded_file($product_image_tmp, "admin_images/$product_image");

		$insert_product = "INSERT INTO  product(product_cat,product_title,product_price,product_desc,product_image,product_keyword) VALUES('$product_cat','$product_title','$product_price','$product_desc','$product_image','$product_keyword')";
		$insert_pro = mysqli_query($con, $insert_product);
		if ($insert_pro) {
			echo "<script>alert ('Product has been inserted')</script>";
			echo "<script>window.open ('index.php?view_product','_self')</script>";
		}else{
			echo "bad";
		}
	}
?>