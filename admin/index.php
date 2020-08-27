<?php
session_start();
    require 'confg/confg.php';
    if (!isset($_SESSION['username'])) {
        echo "<script>window.open ('logout.php?not_admin=You are not an Admin Officer!!','_self')</script>";
    }else{

?>


<!DOCTYPE HTML>
<html>

<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }

    </script>
    <link href="css/index.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
</head>

<body style="background-color: black;">
    <header class="container text-center" style="height: 100px;padding: 30px; background-color: #052963;color: white;">
        <div class="row"> 
            <div class="col">
                <h2>WELCOME TO ADMIN AREA<i class="fas fa-lock"></i></h2>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-3" style="text-align: center;">
                <div class="sidebar-menu">
                    <header class="logo">
                        <a href="#" class="sidebar-icon"> <span  id="sidebar-icon" class="fas fa-home"></span> </a> <a href="#"> <span id="logo"> <h1>JEVAN</h1></span>  
                        </a>
                    </header>
                    <div style="border-top:1px solid rgba(69, 74, 84, 0.7);"></div>
                    <div class="down">
                        <a href="#"><img src="image/evans.jpg" width="30" height="30"></a>
                            <span class=" name-caret">
                                <?php 
                                    if (isset($_SESSION['username'])) {
                                        echo "<h3><em><b>WELCOME</b></em></h3>" .$_SESSION['username'];
                                    }
                                ?>
                            </span>
                        <p>Admin Officer</p>
                        <ul>
                            <a class="tooltips" href="out.php" style="text-align: right;">Log out</a>
                        </ul>
                    </div>
                    <div class="menu">
                        <ul id="menu">
                            <li><a href="index.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
                            <li id="menu-academico"><a href="#"><i class="fa fa-table"></i> <span> My Product</span> <span class="fa fa-angle-right" style="float: right"></span></a>
                                <ul id="menu-academico-sub">
                                    <li id="menu-academico-avaliacoes"><a href="index.php?insert_product"> Add Product</a></li>
                                    <li id="menu-academico-boletim"><a href="index.php?view_product">Edit Product</a></li>
                                    <li id="menu-academico-avaliacoes"><a href="index.php?insert_cat">Add Product Category</a></li>
                                    <li id="menu-academico-avaliacoes"><a href="index.php?view_cat">Edit Category</a></li>
                                    <li id="menu-academico-avaliacoes"><a href="index.php?view_customers">View Customers</a></li>
                                </ul>
                            </li>
                            <li id="menu-academico"><a href="#"><i class="fas fa-file"></i> <span>My Orders</span> <span class="fa fa-angle-right" style="float: right"></span></a>
                                <ul id="menu-academico-sub">
                                    <li id="menu-academico-avaliacoes"><a href="#">Pending Order</a></li>
                                    <li id="menu-academico-boletim"><a href="#">Complete Order</a></li>
                                    <li id="menu-academico-boletim"><a href="#">Cancel Order</a></li>
                                 
                                </ul>
                            </li>
                       </ul>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <h1 style="text-align: center;color: white;"><?php echo @$_GET['logged_in']; ?></h1>
                <?php
                    if (isset($_GET['insert_product'])) {
                        include 'insert.php';
                    }
                ?>
                <?php
                    if (isset($_GET['view_product'])) {
                        include 'AddProductCategory.php';
                    }
                ?>
                <?php
                    if (isset($_GET['edit_pro'])) {
                        include 'edit_pro.php';
                    }
                ?>
                <?php
                    if (isset($_GET['insert_cat'])) {
                        include 'insert_cat.php';
                    }
                ?>
                <?php
                    if (isset($_GET['view_cat'])) {
                        include 'view_cat.php';
                    }
                ?>
                <?php
                    if (isset($_GET['edit_cat'])) {
                        include 'edit_cat.php';
                    }
                ?>
                <?php
                    if (isset($_GET['view_customers'])) {
                        include 'view_customers.php';
                    }
                ?>
            </div>
        </div>
        
    </div>
    <script>
        var toggle = true;

        $(".sidebar-icon").click(function() {
            if (toggle) {
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $("#menu span").css({
                    "position": "absolute"
                });
            } else {
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                setTimeout(function() {
                    $("#menu span").css({
                        "position": "relative"
                    });
                }, 400);
            }

            toggle = !toggle;
        });

    </script>
    <link rel="stylesheet" href="css/vroom.css">
    <script type="text/javascript" src="js/vroom.js"></script>
    <script type="text/javascript" src="js/TweenLite.min.js"></script>s
    <script type="text/javascript" src="js/CSSPlugin.min.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
<?php } ?>