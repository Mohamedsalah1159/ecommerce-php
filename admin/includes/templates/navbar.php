<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class= "container">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang("HOME_ADMIN") ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="categories.php"><?php echo lang("CATEGORIES") ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php"><?php echo lang("ITEMS") ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php"><?php echo lang("MEMBERS") ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comments.php"><?php echo lang("COMMENTS") ?></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          mohamed
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
            <li><a class="dropdown-item" href="members.php?do=edit&userid= <?php echo $_SESSION['ID'] ?>">Edit Profil</a></li>
            <li><a class="dropdown-item" href="#">Sittings</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
</nav>