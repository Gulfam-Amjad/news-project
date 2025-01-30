<?php

include "config.php";
session_start();

// this code is for uploading the file 
if (isset($_FILES['fileToUpload'])) {
    $error=array();

$file_name=$_FILES['fileToUpload']['name'];
$file_size=$_FILES['fileToUpload']['size'];
$file_tmp=$_FILES['fileToUpload']['tmp_name'];
$file_type=$_FILES['fileToUpload']['type'];
$parts = explode(".", $file_name);
$file_ext = end($parts);
$extentions=array("jpeg", "png", "jpg");

if (in_array($file_ext, $extentions)=== false){
   $error[]="there is an error.You have to upload jpg,jpeg or the png file";
}
if ($file_size>2097152) {
   $error[]="there is an error.You have to upload file size equal or less than 2MB";
}

if (empty($error)) {
    move_uploaded_file($file_tmp, "upload/".$file_name);
    echo "file is successfully uploaded";
}else {
   print_r($error);
}

}
// this lower code things comes from the add-post.php when i click the sumit btn and form values are stored into GLOBLE POST and uses here

$title=mysqli_real_escape_string($conn,$_POST['post_title']);
$description=mysqli_real_escape_string($conn,$_POST['postdesc']);
$category=mysqli_real_escape_string($conn,$_POST['category']);
$date=date("d M, Y ");
$author= $_SESSION['user_id'];
// the form stored data is pushed into post database here
$sql = "INSERT INTO post (title, description, category, post_date, author, post_img)
        VALUES ('{$title}', '{$description}', '{$category}', '{$date}', {$author}, '{$file_name}');";
$sql .="UPDATE category SET post = post + 1 WHERE category_name = '{$category}'";

// Execute first query: Insert the post 
if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
}
else {
    echo '<div class="alert alert-danger">Failed to insert post: ' . mysqli_error($conn) . '</div>';
}
?>