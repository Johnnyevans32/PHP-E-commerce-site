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
                <td colspan="8"><h2>View all Customer</h2></td>
            </tr>
            <tr align="center" style="background-color:  #052963;">
                <th>S/N</th>
                <th>Username</th> 
                <th>Name</th>
                <th>Password</th>
                <th>Delete</th>
            </tr>
            <tr>

                <?php
                    $get_c = "SELECT * FROM data";
                    $run_c = mysqli_query($con, $get_c);
                    $i = 0;
                    while ($row_c=mysqli_fetch_array($run_c) ){
                        $c_id = $row_c['id'];
                        $c_title = $row_c['username'];
                        $c_name = $row_c['name'];
                        $c_password = $row_c['password'];

                        $i++;
                ?>
                <td align="center"><?php echo $i; ?></td>
                <td align="center"><?php echo $c_title; ?></td>
                <td align="center"><?php echo $c_name; ?></td>
                <td align="center"><?php echo $c_password; ?></td>
                <td><a href="delete_c.php?delete_c=<?php echo $c_id; ?>">Delete</a></td>
            </tr>
        <?php } ?>
        </table>
</body>
</html>
<?php } ?>
