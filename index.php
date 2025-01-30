<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">

                    <!-- this is the code which i copy fron post.php file because the sql query fetch the same date whih is required here to show and also the code for pagenation -->

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
                    
                  $sql="SELECT post.post_id, post.title, post.description, post.category,post.author,
                  post.post_img,post.post_date, user.username FROM post
                  LEFT JOIN user ON post.author=user.user_id
                  ORDER BY post.post_id DESC LIMIT {$offset}, {$limit}";

                  $result=mysqli_query($conn, $sql)  or die("query fail");
                  if (mysqli_num_rows($result) > 0) {
                    while ($row=mysqli_fetch_assoc($result)) {     
                    ?>

                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id'];?> 
                                    "><img src="admin/upload/<?php echo $row['post_img'];?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['post_id'];?>'>
                                             <?php echo $row['title'];?> 
                                        </a></h3>
                                        <div class="post-information">
                                            <span>
                                              <i class="fa fa-tags" aria-hidden="true"></i>
                                              <a href='category.php'> <?php echo $row['category'];?> </a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?aid=<?php echo $row['author'];?>'><?php echo $row['username'];?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date'];?>
                                            </span>
                                        </div>
                                        <p class="description">
                                            <?php echo substr($row['description'],0,130);?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'];?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                              }
                           }
                        ?>

                   <!-- there is pagination code -->
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
                         echo '<li><a href="index.php?page='.($page - 1).'">Prev</a></li>';
                       }
                      
                       for ($i=1; $i <= $total_page ; $i++) { 
                         if ($i==$page) {
                           $active="active";
                         }else {
                           $active="";
                         }
   
                        echo '<li class="'.$active.'" ><a href="index.php?page='.$i.'">'.$i.'</a></li>';
                       }
                       // condition for next button showing
                       if ($total_page > $page) {
                         echo '<li><a href="index.php?page='.($page + 1).'">Next</a></li>';
                       }
                       echo '</ul>';
                     }
                    ?>



                    </div><!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
