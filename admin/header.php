 <?php
include 'config.php';

// this code for stoping users to accessing the pages by using page names in url when they are not logedin
session_start();
if (!isset($_SESSION['username'])) {
    header("location: {$hostname}/admin/");
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>ADMIN Panel</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <!-- Custom stlylesheet -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <!-- HEADER -->
        <div id="header-admin">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row align-items-center">
            <!-- LOGO -->
            <div class="col-md-3">
                <a href="post.php"><img class="logo" src="images/news.jpg" alt="Logo"></a>
            </div>
            <!-- /LOGO -->
            
            <!-- Username and Logout -->
            <div class="col-md-9 text-right">
                <span class="welcome-text">Welcome, <strong class="h4 font-weight-bold"><?php echo $_SESSION['username']; ?></strong></span>
                <a href="logout.php" class="admin-logout btn btn-link">Logout</a>
            </div>
            <!-- /Username and Logout -->
        </div>
    </div>
</div>

        <!-- /HEADER -->
        <!-- Menu Bar -->
        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <ul class="admin-menu">
                            <li>
                                <a href="post.php">Post</a>
                            </li>
 <!-- this code is showing category and users only to admins not to normal users -->
                           <?php

                            if ($_SESSION['user_role'] == '1') { 
                                ?> 
                            <li>
                                <a href="category.php">Category</a>
                            </li>
                            <li>
                                <a href="users.php">Users</a>
                            </li>

                           <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Menu Bar -->
