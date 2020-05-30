  <nav class="navbar shadow py-3 navbar-expand-lg navbar-dark bg-info">
  <div class="container">
  <a class="navbar-brand" href="index.php">Simple Blog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class='<?php echo $route === 'home' ? "nav-item active" : "nav-item" ?>'>
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class='<?php echo $route === 'news' ? "nav-item active" : "nav-item" ?>'>
        <a class="nav-link" href="category.php?category=news">News</a>
      </li>
      <li class='<?php echo $route === 'sports' ? "nav-item active" : "nav-item" ?>'>
        <a class="nav-link" href="category.php?category=sports">Sports</a>
      </li>
      <li class='<?php echo $route === 'entertainment' ? "nav-item active" : "nav-item" ?>'>
        <a class="nav-link" href="category.php?category=entertainments">Entertainments </a>
      </li>
      <li class='<?php echo $route === 'politics' ? "nav-item active" : "nav-item" ?>'>
        <a class='nav-link' href="category.php?category=politics">Politics </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php  if ( isset($_COOKIE['userr']) && $_COOKIE['userr'] === 'admin') { ?>
        <li class='nav-item'>
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class='<?php echo $route === 'addnews' ? "nav-item active" : "nav-item" ?>'>
          <a class="nav-link" href="addNews.php">Add Item</a>
        </li>
      <?php } else { ?>
        <li class='<?php echo $route === 'login' ? "nav-item active" : "nav-item" ?>'>
          <a class="nav-link" href="login.php">Admin</a>
        </li>
      <?php } ?>
      
    </ul>
  </div></div>
</nav>