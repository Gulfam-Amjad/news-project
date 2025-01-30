<?php include 'header.php'; ?>
<div id="main-content">
  <div class="container">
    <div class="row">
      <div class="col-md-8">

        <!-- post-container -->
        <div class="post-container">

          <?php
          include 'config.php';

          // Validate if 'aid' is present in the URL
          if (isset($_GET['aid'])) {
            $auth_id = $_GET['aid'];
          } else {
            die("Author ID not provided in URL.");
          }

          // Fetch author information
          $sql1 = "SELECT username FROM user WHERE user_id = {$auth_id}";
          $result1 = mysqli_query($conn, $sql1) or die("Query failed: " . mysqli_error($conn));
            $row1 = mysqli_fetch_assoc($result1);
          ?>
          <h2 class="page-heading"><?php echo $row1['username']; ?></h2>

          <?php
          // Pagination setup
          $limit = 3; // Number of posts per page
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $limit;

          // Fetch posts by author with pagination
          $sql = "SELECT post.post_id, post.title, post.description, post.category, post.author, 
                         post.post_img, post.post_date, user.username 
                  FROM post
                  LEFT JOIN user ON post.author = user.user_id
                  WHERE post.author = {$auth_id}
                  ORDER BY post.post_id DESC
                  LIMIT {$offset}, {$limit}";

          $result = mysqli_query($conn, $sql) or die("Query failed: " . mysqli_error($conn));

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <div class="post-content">
                <div class="row">
                  <div class="col-md-4">
                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>">
                      <img src="admin/upload/<?php echo $row['post_img']; ?>" alt="" />
                    </a>
                  </div>
                  <div class="col-md-8">
                    <div class="inner-content clearfix">
                      <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'>
                          <?php echo $row['title']; ?>
                        </a></h3>
                      <div class="post-information">
                        <span>
                          <i class="fa fa-tags" aria-hidden="true"></i>
                          <a href='category.php?id=<?php echo $row['category']; ?>'><?php echo $row['category']; ?></a>
                        </span>
                        <span>
                          <i class="fa fa-user" aria-hidden="true"></i>
                          <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                        </span>
                        <span>
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                          <?php echo $row['post_date']; ?>
                        </span>
                      </div>
                      <p class="description">
                        <?php echo substr($row['description'], 0, 130) . '...'; ?>
                      </p>
                      <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo "<h3>No posts found.</h3>";
          }
          ?>

          <!-- Pagination -->
          <?php
          $sql_count = "SELECT COUNT(*) AS total FROM post WHERE author = {$auth_id}";
          $count_result = mysqli_query($conn, $sql_count) or die("Count query failed: " . mysqli_error($conn));
          $total_records = mysqli_fetch_assoc($count_result)['total'];

          $total_page = ceil($total_records / $limit);

          if ($total_page > 1) {
            echo '<ul class="pagination admin-pagination">';
            if ($page > 1) {
              echo '<li><a href="author.php?aid=' . $auth_id . '&page=' . ($page - 1) . '">Prev</a></li>';
            }

            for ($i = 1; $i <= $total_page; $i++) {
              $active = ($i == $page) ? "active" : "";
              echo '<li class="' . $active . '"><a href="author.php?aid=' . $auth_id . '&page=' . $i . '">' . $i . '</a></li>';
            }

            if ($total_page > $page) {
              echo '<li><a href="author.php?aid=' . $auth_id . '&page=' . ($page + 1) . '">Next</a></li>';
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
