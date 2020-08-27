<?php
	require 'confg/confg.php';
	if (isset($_GET['delete_cat'])) {
		$delete_id = $_GET['delete_cat'];
		$delete_cat = "DELETE FROM `categories` WHERE `cat-id`='$delete_id'";
		$run_del = mysqli_query($con, $delete_cat);
		if ($run_del) {
			echo "<script>alert ('category has been deleted')</script>";
			echo "<script>window.open ('index.php?view_cat','_self')</script>";
		}
	}


?>