<?php 
   require('config/connection.php');
   
  if (isset($_GET['delete'])) {
    // get and delete old img
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = 'SELECT * FROM news WHERE id=' . $id;
    $result = $conn->query($sql);
    $newsObject = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    $photo = $newsObject[0]['photo'];
    unlink($photo);

    $sql = "DELETE FROM news WHERE id=" . $_GET['delete'];
    if ($conn->query($sql) === TRUE) {
      // echo "Record deleted successfully";
    } else {
      echo "Error deleting record:" . $conn->error;
    }
    header('Location: index.php');
  } else {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = 'SELECT * FROM news WHERE id=' . $id;
    $result = $conn->query($sql);
    $newsObject = mysqli_fetch_all($result, MYSQLI_ASSOC); 
  }
  $route = '';
?>
<!DOCTYPE html>
<html lang="en">
<!-- import all links -->
  <?php require('partials/header.php') ?>
<body>
<!-- import navbar -->
  <?php require('partials/navbar.php') ?>
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card mt-4 rounded-0  shadow border-0" >
        <div class="card-body">
            <h5 class="card-title"><?php echo $newsObject[0]['title']; ?></h5>
            <img src="<?php echo $newsObject[0]['photo']; ?>" alt="<?php echo $newsObject[0]['title']; ?>" height='225' width='250'>
            <p class="card-text"><?php echo $newsObject[0]['body']; ?></p>
            <p class="card-text"> </p>
            <h6><span class='font-weight-bold'><?php echo $newsObject[0]['created_by']; ?></span> 
            <span>(<?php echo substr($newsObject[0]['reg_date'], 0, 10); ?>)</span>
            </h6>
        </div>
      </div>
      <?php if ( isset($_COOKIE['userr']) && $_COOKIE['userr'] === 'admin') { ?>
        <div class='mt-4'>
        <a href="newsDetails.php?delete=<?php echo $newsObject[0]['id']; ?>" class="btn btn-danger rounded-0">Delete Post</a>
        <a href="addNews.php?id=<?php echo $newsObject[0]['id']; ?>" class="btn btn-success rounded-0">Edit Post</a>
        </div>
      <?php } ?>
        
    </div>
    </div>
     
  </div>
    
<!-- import scripts -->
  <?php require('partials/scripts.php') ?>
</body>
</html>