<?php
include 'config.php';

$post_id= $_GET['id'];
$category= $_GET['catid'];

// this part of code is to delete the image from the upload foulder
$sql1="SELECT post_img FROM post WHERE post_id={$post_id}";
$result1=mysqli_query($conn, $sql1) or die("query failed");
$row1= mysqli_fetch_assoc($result1);

unlink("upload/".$row1['post_img']);

// this id is get from the url and this get id help to delete the row which the user click to delete
// and also when the row delete in post table there is another query update to reduce the post count n category table
$sql="DELETE FROM post WHERE post_id={$post_id};";
$sql.="UPDATE category SET post=post-1 WHERE category_name='{$category}'";

if (mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
}
else {
    echo "item is not deleted there is an error";
}
?>


<!-- there is another code for same thing -->


<!-- 

include 'config.php';

// Sanitize input to prevent SQL injection
$post_id = mysqli_real_escape_string($conn, $_GET['id']);
$sqlcategory = mysqli_real_escape_string($conn, $_GET['catid']);

// Query to delete the post
$sql_delete = "DELETE FROM post WHERE post_id={$post_id}";

// Execute the delete query
if (mysqli_query($conn, $sql_delete)) {
    // Update the category post count after deleting the post
    $sql_update = "UPDATE category SET post = post - 1 WHERE category_name = '{$sqlcategory}'";

    // Execute the update query
    if (mysqli_query($conn, $sql_update)) {
        // Redirect to the post list page
        header("Location: {$hostname}/admin/post.php");
    } else {
        echo "Error updating category post count: " . mysqli_error($conn);
    }
} else {
    echo "Error deleting post: " . mysqli_error($conn);
} -->
