<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="save_post.php" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>

                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control">
                              <option disabled> Select Category</option>
                              <?php

//when i press the submit button that the SAVE word and id stored in the GLOBLE VARIABLE POST and we uses it on save_post.php for ferther things              

                                include "config.php";
// this code will only shows the options to select the category when a person is filling the add post form
                                $sql="SELECT * FROM category";
                                $result=mysqli_query($conn, $sql) or die("query failed");

                                if (mysqli_num_rows($result)) {
                                   while ($row=mysqli_fetch_assoc($result)) {
                                   echo "<option>{$row['category_name']}</option>";
                                 }
                                   }                                          
                                ?>
                          </select>
                      </div>


                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
