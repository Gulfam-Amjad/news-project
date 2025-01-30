<?php

include 'config.php';

if (empty($_FILES['new-image']['name'])) {
   $file_name=$_POST['old_image'];
}
else {
    $error=array();

    $file_name=$_FILES['new-image']['name'];
    $file_size=$_FILES['new-image']['size'];
    $file_tmp=$_FILES['new-image']['tmp_name'];
    $file_type=$_FILES['new-image']['type'];
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


   echo $sql= "UPDATE post SET title='{$_POST["post_title"]}', description = '{$_POST["postdesc"]}', category='{$_POST["category"]}', post_img='{$file_name}'
   WHERE post_id='{$_POST["post_id"]}'";

   $result=mysqli_query($conn, $sql);
   if ($result) {
       header("Location: {$hostname}/admin/post.php");
   }
   else {
      echo "there is an query error";
   }
?>