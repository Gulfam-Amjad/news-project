<!-- tis php code part is all about the update of the user form by using POST method -->
<?php include "header.php"; 
      include "config.php";

// this code is to stop the normal users to access users.php by usingname in url diectly and redirect to post.php
if ($_SESSION['user_role'] == '0') { 
    header("location: {$hostname}/admin/post.php");
  }

if (isset($_POST['submit'])) {
    
    $userid=$_GET['id'];

    // $userid=mysqli_real_escape_string($conn, $_POST['user_id']);
    $fname=mysqli_real_escape_string($conn, $_POST['f_name']);
    $lname=mysqli_real_escape_string($conn, $_POST['l_name']);
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    $role=mysqli_real_escape_string($conn, $_POST['role']);

    $sql="UPDATE user SET first_name='{$fname}', last_name='{$lname}', username='{$username}', role='{$role}' WHERE user_id='$userid'";

    if (mysqli_query($conn, $sql)) {
        header("location: {$hostname}/admin/users.php");
    }else {
      echo  "<p>update is not successfully done.</p>";
    }
}


?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
<!-- this php code is for showing the names and username on the update form when we click the edit icon on user page and show the things as we stored on user table -->
                  <?php
                  include 'config.php';

                  $user_id=$_GET['id'];
                  $sql="SELECT * FROM user WHERE user_id='$user_id'";
                  $result= mysqli_query($conn, $sql) or die("query fail of getting id");
                  if (mysqli_num_rows($result)) {
                   while ($row=mysqli_fetch_assoc($result)) {
                    
                   
                  ?>

                  <form  action="<?php $_SERVER['PHP_SELF']?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="1" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                            <?php
                            if ($row['role'] == 1) {
                               echo "<option value='0'>normal User</option>
                                <option value='1' selected>Admin</option>";
                            }else {
                               echo "<option value='0' selected>normal User</option>
                                <option value='1'>Admin</option>";
                            }
                            ?>

                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php 
                  }
                }
                  ?>
                  <!-- /Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
