<?php
	require 'confg/confg.php';
	if (isset($_GET['delete_c'])) {
		$delete_id = $_GET['delete_c'];
		$delete_c = "DELETE FROM `data` WHERE id='$delete_id'";
		$run_del = mysqli_query($con, $delete_c);
		if ($run_del) {
			echo "<script>alert ('Customer has been deleted')</script>";
			echo "<script>window.open ('index.php?view_customers','_self')</script>";
		}
	}


?>