<?php 

   require('config/connection.php'); // import connection
   
  // handle submit new post
  if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $author = mysqli_real_escape_string($conn, $_POST['author']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);
      $body = mysqli_real_escape_string($conn, $_POST['body']);
      $photo = $target_dir . $_FILES["photo"]["name"];
      
      $sql = "INSERT INTO news(title, body, category, photo, created_by) VALUES('$title', '$body', '$category', '$photo', '$author')";
      if ($conn->query($sql) === TRUE) {
        $text ='<div class=" mb-0 alert alert-success alert-dismissible fade show" role="alert">
        <strong>Post created successfully</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>';
        echo "$text";
        // header('Location: addNews.php');
      }else{
        echo 'query error: ' . $conn->error;
      }
      // echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
    
  }

  // handle edit post page
  if (isset($_GET['id'])) {
    $sql = 'SELECT * FROM news WHERE id=' . $_GET['id'];
    $result = $conn->query($sql);
    $resultObj = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  // handle update new post
  if (isset($_POST['update'])) {
    # if old img is not altered, update other fields
    if ($_FILES["photo"]["name"] === '') {
      $id = mysqli_real_escape_string($conn, $_POST['id']);
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $author = mysqli_real_escape_string($conn, $_POST['author']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);
      $body = mysqli_real_escape_string($conn, $_POST['body']);
      $sql = "UPDATE news SET title='$title', created_by='$author', category='$category', body='$body' WHERE id='$id'" ;
      if ($conn->query($sql) === TRUE) {
        $text ='<div class=" mb-0 alert alert-success alert-dismissible fade show" role="alert">
          <strong>Post updated successfully</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>';
          echo "$text";
      } else {
        echo 'Unable to update post: '. $conn->error;
      }
    # update all fields including new img
    } else {
      // get and delete old img
      $id = mysqli_real_escape_string($conn, $_POST['id']);
      $sql = 'SELECT * FROM news WHERE id=' . $id;
      $result = $conn->query($sql);
      $newsObject = mysqli_fetch_all($result, MYSQLI_ASSOC); 
      $photo = $newsObject[0]['photo'];
      unlink($photo);

      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["photo"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $photo = $target_dir . $_FILES["photo"]["name"];
        $body = mysqli_real_escape_string($conn, $_POST['body']);
        $sql = "UPDATE news SET title='$title', photo='$photo', created_by='$author', category='$category', body='$body' WHERE id='$id'" ;
        if ($conn->query($sql) === TRUE) {
          $text ='<div class=" mb-0 alert alert-success alert-dismissible fade show" role="alert">
          <strong>Post updated successfully</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>';
          echo "$text";
        } else {
          echo 'Unable to update post: '. $conn->error;
        }
      } else {
        $text ='<div class=" mb-0 alert alert-info alert-dismissible fade show" role="alert">
          <strong>Sorry, there was an error uploading your file.</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>';
          echo "$text";
      }
    }
        
  }
  $route = 'addnews';
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
      <div class="col-md-6 mx-auto shadow mt-4 py-3">
      <?php if ( isset($_COOKIE['userr']) && $_COOKIE['userr'] === 'admin') { ?>
       <form action='addNews.php' method='POST' enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="text" name='title' value="<?php echo isset($_GET['id']) ? $resultObj[0]['title'] : ''; ?>" required class="form-control rounded-0" placeholder="News Title">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Author</label>
            <input type="text" name='author' value="<?php echo isset($_GET['id']) ? $resultObj[0]['created_by'] : ''; ?>" required class="form-control rounded-0" placeholder="Author">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Category</label>
            <select name='category' required class="form-control rounded-0" placeholder="Category" >
              <option value='<?php echo isset($_GET['id']) ? $resultObj[0]['category'] : ''; ?>'><?php echo isset($_GET['id']) ? $resultObj[0]['category'] : ''; ?></option>
              <option value='News'>News</option>
              <option value='Sports'>Sports</option>
              <option value='Entertainments'>Entertainments</option>
              <option value='Politics'>Politics</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label> 
            <?php if (isset($_GET['id'])) { ?>
            <img class='float-right mb-2' src="<?php echo $resultObj[0]['photo'] ; ?>" height='60' width='60' alt="">
            <?php } ?>
            <input type="file" name='photo' class="form-control rounded-0" placeholder="Upload a photo">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Body</label>
            <textarea class="form-control rounded-0"  required name="body" id="" cols="40" rows="5"><?php echo isset($_GET['id']) ? $resultObj[0]['body'] : ''; ?></textarea>
        </div>
        <input type="hidden" value='<?php echo isset($_GET['id']) ? $resultObj[0]['id'] : ''; ?>' name="id">
        <button type="submit" name="<?php echo isset($_GET['id']) ? 'update' : 'submit'; ?>" class="shadow btn btn-block btn-info rounded-0"><?php echo isset($_GET['id']) ? 'Update' : 'Submit'; ?></button>
        </form>
      <?php } else { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error 400: </strong> You're not authorized to acces this page'.
          
        </div>

      <?php } ?>
      </div>
    </div>
    
  </div>
    
<!-- import scripts -->
  <?php require('partials/scripts.php') ?>
</body>
</html>