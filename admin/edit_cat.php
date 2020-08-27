<?php
    if (!isset($_SESSION['username'])) {
        echo "<script>window.open ('logout.php?not_admin=You are not an Admin Officer!!','_self')</script>";
    }else{

?>
<?php
	if (isset($_GET['edit_cat'])) {
		$get_id = $_GET['edit_cat'];
		$get_cat = "SELECT * FROM categories WHERE `cat-id` ='$get_id'";
		$run_cat = mysqli_query($con, $get_cat);
		$i = 0;
		$row_cat=mysqli_fetch_array($run_cat);
		$cat_id = $row_cat['cat-id'];	
		$cat_title = $row_cat['cat-title'];


	}
	
?>
	<form action="" method="POST" enctype="multipart/form-data">
		<table align="center" width="700" border="2" style="background-color: #052963; color: white;">
			<tr align="center">
				<td colspan="8"><h2>EDIT/UPDATE CATEGORY</h2></td>
			</tr>
			<tr>
				<td align="right">Category Title</td>
				<td><input type="text" size="50" name="cat_title" value="<?php echo $cat_title; ?>"></td>
			</tr>
			<tr>
				<td colspan="8" align="center"><input type="submit" name="update_now" value="UPDATE"></td>
			</tr>
		</table>
	</form>

<?php

	if (isset($_POST['update_now'])) {
		$update_id = $cat_id;
		$cat_title = $_POST['cat_title'];

		$update_cats = "UPDATE `categories` SET `cat-title`='$cat_title' WHERE `cat-id`='$update_id'";
		$update_cat = mysqli_query($con, $update_cats);
		if ($update_cat) {
			echo "<script>alert ('Category has been updated')</script>";
			echo "<script>window.open ('index.php?view_cat','_self')</script>";
		}else{
			echo "bad";
		}
	}
?>
<?php } ?>