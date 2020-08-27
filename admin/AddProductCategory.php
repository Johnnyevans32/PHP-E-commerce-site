<?php
    require 'confg/confg.php';
    if (!isset($_SESSION['username'])) {
        echo "<script>window.open ('logout.php?not_admin=You are not an Admin Officer!!','_self')</script>";
    }else{

?>
<!DOCTYPE html>
<html>
<head>

    <title></title>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea'});</script>
</head>
<body>
        <table align="center" width="700" height="600" border="2" style="background-color: #052963;color: white;">
            <tr align="center">
                <td colspan="8"><h2>EDIT PRODUCTS</h2></td>
            </tr>
            <tr align="center" style="background-color:  #052963;">
                <th>S/N</th>
                <th>Title</th> 
                <th>Image</th> 
                <th>Price</th> 
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <tr>

                <?php
                    $get_pro = "SELECT * FROM product";
                    $run_pro = mysqli_query($con, $get_pro);
                    $i = 0;
                    while ($row_pro=mysqli_fetch_array($run_pro) ){
                        $pro_id = $row_pro['product_id'];
                        $product_title = $row_pro['product_title'];
                        $product_price = $row_pro['product_price'];
                        $product_image = $row_pro['product_image'];
                        $i++;
                ?>
                <td align="center"><?php echo $i; ?></td>
                <td align="center"><?php echo $product_title; ?></td>
                <td align="center"><img src="admin_images/<?php echo $product_image; ?>" width="50" height="50"></td>
                <td align="center">$<?php echo $product_price; ?></td>
                <td><a href="index.php?edit_pro=<?php echo $pro_id; ?>">Edit</a></td>
                <td><a href="delete_pro.php?delete_pro=<?php echo $pro_id; ?>">Delete</a></td>
            </tr>
        <?php } ?>
        </table>
</body>
</html>
<?php } ?>