<!DOCTYPE html>
<html>
<head>
<title>Emag</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container is-fullhd">
    
<nav class="navbar mb-4" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php">
      <img src="https://s13emagst.akamaized.net/layout/bg/images/logo//18/26930.svg" width="100">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item"  href="index.php">
        Home
      </a>

        
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
      <a href="cart.php">
        <ion-icon name="cart-outline" size="large"></ion-icon>
        <?php echo isset($_SESSION['cart']) && count($_SESSION['cart']) ? array_sum($_SESSION['cart']) : '' ?>
      </a>
      </div>  
      <div class="navbar-item">
        <div class="buttons">

<?php
if (isset($_SESSION['user']['id'])) {
      echo "Hello, {$_SESSION['user']['first_name']}";
?>
          <a class="button is-ligh" href="logout.php">
            <strong>Logout</strong>
          </a>
<?php  
}
else {
?>
          <a class="button is-primary" href="register.php">
            <strong>Sign up</strong>
          </a>
          <a class="button is-light" href="login.php">
            Log in
          </a>
<?php
}
?>
        </div>
      </div>
    </div>
  </div>
</nav>

