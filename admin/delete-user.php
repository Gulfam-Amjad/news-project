<?php
include "config.php";
// this code is to stop the normal users to access users.php by usingname in url diectly and redirect to post.php
if ($_SESSION['user_role'] == '0') { 
    header("location: {$hostname}/admin/post.php");
  }

$userid=$_GET['id'];
$sql="DELETE FROM user WHERE user_id='$userid'";

if (mysqli_query($conn, $sql)){
    header("location: http://localhost/news-site/admin/users.php");
}

?>