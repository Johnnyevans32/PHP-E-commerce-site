<?php
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
                <td colspan="8"><h2>VIEW CATEGORIES</h2></td>
            </tr>
            <tr align="center" style="background-color:  #052963;">
                <th>Category ID</th>
                <th>Category Title</th> 
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <tr>

                <?php
                    $get_cat = "SELECT * FROM categories";
                    $run_cat = mysqli_query($con, $get_cat);
                    $i = 0;
                    while ($row_cat=mysqli_fetch_array($run_cat) ){
                        $cat_id = $row_cat['cat-id'];
                        $cat_title = $row_cat['cat-title'];
                        $i++;
                ?>
                <td align="center"><?php echo $i; ?></td>
                <td align="center"><?php echo $cat_title; ?></td>
                <td><a href="index.php?edit_cat=<?php echo $cat_id; ?>">Edit</a></td>
                <td><a href="delete_cat.php?delete_cat=<?php echo $cat_id; ?>">Delete</a></td>
            </tr>
        <?php } ?>
        </table>
</body>
</html>
<?php } ?>
