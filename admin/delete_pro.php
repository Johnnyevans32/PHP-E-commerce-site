<?php
	require 'confg/confg.php';
	if (isset($_GET['delete_pro'])) {
		$delete_id = $_GET['delete_pro'];
		$delete_pro = "DELETE FROM `product` WHERE product_id='$delete_id'";
		$run_del = mysqli_query($con, $delete_pro);
		if ($run_del) {
			echo "<script>alert ('Product has been deleted')</script>";
			echo "<script>window.open ('index.php?view_product','_self')</script>";
		}
	}


?>