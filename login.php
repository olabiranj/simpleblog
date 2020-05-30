<?php 
   require('config/connection.php'); // import connection

  $route = 'login';

  $cookie_name = "userr";
  $cookie_value = 'admin';
  if (isset($_POST['admin'])) {
      // Start the session
    //   session_start(); 
    //   $_SESSION["admin"] = TRUE;
    //   header('Location: addNews.php');
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    header('Location: login.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
<!-- import all links -->
  <?php require('partials/header.php') ?>
<body>
<!-- import navbar -->
  <?php require('partials/navbar.php') ?>
  <div class="container">
    <div class="row" style='height: 70vh;'>
      <div class="col-md-4 mx-auto my-auto shadow py-3">
       <form class='' action='login.php' method='POST'>
       <?php if ( isset($_COOKIE['userr']) && $_COOKIE['userr'] === 'admin') { ?>
        <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
          <strong>Welcome Admin!</strong> You can add and edit posts.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php } ?>
        
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" name='email' value="simpleblog@gmail.com" readonly class="form-control rounded-0" placeholder="News Title">
        </div>
        <button type="submit" name='admin' class="shadow btn btn-block btn-info rounded-0"><?php echo isset($_COOKIE['userr']) && $_COOKIE['userr'] === 'admin' ? 'Logged In' : 'Login' ?></button>
        </form>
      </div>
    </div>
    
  </div>
    
<!-- import scripts -->
  <?php require('partials/scripts.php') ?>
</body>
</html>