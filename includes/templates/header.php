<!DOCTYPE>
<html>
    <head>
        <meta charset= "UTF-8" />
        <title><?php gettitle()?></title>
        <link rel='stylesheet' href='<?php echo $css?>bootstrap.min.css' />
        <link rel='stylesheet' href='<?php echo $css?>fontawesome.min.css' />
        <link rel='stylesheet' href='<?php echo $css?>jquery-ui.css' />
        <link rel='stylesheet' href='<?php echo $css?>jquery.selectBoxIt1.css' />
        <link rel='stylesheet' href='<?php echo $css?>frontend1.css' />
    </head>
    <body>
      <div class="upper-bar">
        <div class="container" style="direction: rtl;">
        <?php
          if(isset($_SESSION["user"])){?>
          <img class='my-image img-thumbnail img-circle' src='download.jpg' alt='' />
          <div class="btn-group my-info">
              <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <?php echo $sessionUser ?>
                  <span class="caret"></span>
              </span>
                <ul class="dropdown-menu">
                  <li><a href="profile.php">My Profile</a></li>
                  <li><a href="newad.php">New Item</a></li>
                  <li><a href="profile.php#my-ads">My Items</a></li>
                  <li><a href="logout.php">Logout</a></li>
                </ul>
          </div>
          <?php
          }else{
            ?>
          <a href="login.php">
            <span>Login/Signup</span>
          </a>
            <?php
          }
        ?>

        </div>
      </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class= "container">
  <a class="navbar-brand" href="index.php">Homepage</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" style="justify-content: flex-end;" id="navbarSupportedContent">
    <ul class="navbar-nav navbar-right">
      <?php
          $allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
          foreach($allCats as $category){
              echo "<li><a href='categories.php?pageid=" . $category["ID"] . "' class='nav-link'>" . $category["Name"] . "</a></li>";
          }
      ?>
    </ul>
  </div>
</div>
</nav>