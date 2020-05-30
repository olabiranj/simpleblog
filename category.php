<?php 
require('config/connection.php');
  $sql = 'SELECT * FROM news WHERE category ="'. $_GET['category'] . '"';
  $result = $conn->query($sql);
  $newsObject = mysqli_fetch_all($result, MYSQLI_ASSOC); 
  $route = $_GET['category'];
?>
<!DOCTYPE html>
<html lang="en">
<!-- import all links -->
  <?php require('partials/header.php') ?>
<body class='bg-light'>
<!-- import navbar -->
  <?php require('partials/navbar.php') ?>
  
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto ">
        <?php if (count($newsObject) < 1) { ?>
        <h1 class='mt-4 text-center'>No post in <?php echo $_GET['category'] ?>, check another category.</h1>
        <?php } else { ?>
          <h1><?php echo ucfirst($_GET['category']) ?></h1>
          <?php foreach ($newsObject as $news) { ?>
            <div class="card mt-4 rounded-0 shadow border-0" >
              <div class="card-body flex">
                <div>
                  <h5 class="card-title"><?php echo htmlspecialchars($news['title']); ?></h5>
                  <img src="<?php echo $news['photo']; ?>" alt="<?php echo $news['title']; ?>" height='200' width='250'>
                </div>
                <div class='my-auto ml-3'>
                  <p class="card-text text-justify"><?php echo substr(htmlspecialchars($news['body']), 0, 180) . '...'; ?></p>
                  <h6><span class='font-weight-bold'><?php echo $news['created_by']; ?></span> <span>(<?php echo substr($news['reg_date'], 0, 10) ; ?>)</span></h6>
                  <a href="newsDetails.php?id=<?php echo htmlspecialchars($news['id']); ?>" class="btn btn-info rounded-0">Read More</a>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
        
      </div>
    </div>
  </div>
    
<!-- import scripts -->
  <?php require('partials/scripts.php') ?>
</body>
</html>