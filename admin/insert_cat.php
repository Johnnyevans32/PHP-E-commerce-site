<?php
    if (!isset($_SESSION['username'])) {
        echo "<script>window.open ('logout.php?not_admin=You are not an Admin Officer!!','_self')</script>";
    }else{

?>
<form action="" method="POST" style="padding: 200px; background-color: #052963; border: 5px solid black; color: white">
	<b>INSERT NEW CATEGORY</b>
	<input type="text" name="new_cat" required>
	<input type="submit" name="add_cat" value="ADD CATEGORY">
</form>
<?php

	if (isset($_POST['add_cat'])) {
		$new_cat = $_POST['new_cat'];
		$insert_cat = "INSERT INTO `categories`(`cat-title`) VALUES('$new_cat')";

		$run_cat = mysqli_query($con, $insert_cat);
		if ($run_cat) {
			echo "<script>alert ('Category has been added')</script>";
			echo "<script>window.open ('index.php?view_cat','_self')</script>";
		}
	}
	

?>
<?php } ?>