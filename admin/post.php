<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
           <!-- this php code is selecting the data from database -->
           <?php
                include 'config.php';
                // this get page is for the pagination detector
                
                // THIS STATEMENT ID DUE TO PROBLEM SOVING WHEN WE 1st time click userpage & page is not in url 
                if (isset($_GET['page'])) {
                  $page=$_GET['page'];
                }else {
                 $page=1;
                }


                $limit=3;
                $offset=($page - 1) * $limit;

                // this code for showing the post detailes on the post.php page
                // and i uses this if and ifelse condition because only admin can see the whole post and normal user only shes his post
                if ($_SESSION['user_role'] == '1') { 
                  $sql="SELECT post.post_id, post.title, post.description, post.category, post.post_date, user.username FROM post
                  LEFT JOIN user ON post.author=user.user_id
                  ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";
                }
                elseif ($_SESSION['user_role'] == '0') {
                  $sql="SELECT post.post_id, post.title, post.description, post.category, post.post_date, user.username FROM post
                  LEFT JOIN user ON post.author=user.user_id
                  WHERE post.author={$_SESSION['user_id']}
                  ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";
                }


                $result=mysqli_query($conn, $sql)  or die("query fail");

                if (mysqli_num_rows($result) > 0) {
                  
                               
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>

                      <?php
                        while ($row=mysqli_fetch_assoc($result)) {                           
                        ?>

                          <tr>
                              <td class='id'><?php echo $row['post_id'];?></td>
                              <td><?php echo $row['title'];?></td>
                              <td><?php echo $row['category'];?></td>
                              <td><?php echo $row['post_date'];?></td>
                              <td><?php echo $row['username'];?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'];?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id'];?>&catid=<?php echo $row['category'];?> '><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php } ?>
                         
                      </tbody>
                  </table>

                 <?php } ?>

                  <!-- php code for pagination -->

                  <?php
                  $sql1="SELECT * FROM post";
                  $result1=mysqli_query($conn, $sql1);

                  if (mysqli_num_rows($result1)) {
                    
                    $total_records=mysqli_num_rows($result1);
                    $limit=3;
                    $total_page=ceil($total_records/$limit);
                    echo ' <ul class="pagination admin-pagination">';
                    // condition for prev button showing
                    if ($page > 1) {
                      echo '<li><a href="post.php?page='.($page - 1).'">Prev</a></li>';
                    }
                   
                    for ($i=1; $i <= $total_page ; $i++) { 
                      if ($i==$page) {
                        $active="active";
                      }else {
                        $active="";
                      }

                     echo '<li class="'.$active.'" ><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                    }
                    // condition for next button showing
                    if ($total_page > $page) {
                      echo '<li><a href="post.php?page='.($page + 1).'">Next</a></li>';
                    }

                    echo '</ul>';
                  }
                  ?>
                 
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
