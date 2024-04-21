<?php $cart->validateCart(); ?> 
<header class="header" id="header">
  <a href="?"><img src="img/UTS-Express.png" class="logo" /></a>

  <nav class="navbar">
    <a href="?" class="<?= ($_SESSION['site'] === 'Home') ? "active-tab navtxt" : "navtxt" ?>" id="navtxt">Home</a>
    <a href="products" class="<?= ($_SESSION['site'] === 'Products') ? "active-tab navtxt1" : "navtxt1" ?>" id="navtxt">Products</a>
    <a href="shops" class="<?= ($_SESSION['site'] === 'Shops') ? "active-tab navtxt2" : "navtxt2" ?>" id="navtxt">Shops</a>
    <a href="about" class="<?= ($_SESSION['site'] === 'About') ? "active-tab navtxt3" : "navtxt3" ?>" id="navtxt">About Us</a>
  </nav>

  <div class="icons" id="nav">
    <div class="fas fa-bars" id="menu-btn"></div>
    <div class="fas fa-search" id="search-btn"></div>
    <div class="fas fa-shopping-cart static" id="cart-btn"><a id="cart-icon" class="cart-icon"><?= isset($_SESSION['cart']) ? sizeof($_SESSION['cart']) : 0 ?></a></div>
    <?php
    if (isset($_SESSION['user_ID'])) {
      echo '<div class="fas fa-user" id="user-btn"></div>';
    } else {
      echo '<div class="fas fa-user" id="user-btn" style="display: none;"></div>';
    }
    ?>
  </div>

  <div class="shopping-cart" id="cart">
    <a href="checkout" class="btn" style="color: black">checkout</a>
    <div id="cart-content">
      <div class="total">total : <?= sizeof($_SESSION['cart']) ?></div>
      <div class="total" style="padding: 0;font-size: 2rem;">Cost : P<?= $cart->getTotal() ?></div>
      <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
        <?php $itemData = $database->showRecords('shopproducts', "WHERE product_ID = '$id'"); ?>
        <div class="box">
          <i class="fas fa-trash trash-btn" data-id="<?= $id ?>"></i>
          <div class="cart-img-container">
            <img src="img/<?=$itemData[0][5]?>/products/<?= $id ?>.png" alt="" />
          </div>
          <div class="content">
            <h3><?= $itemData[0][1] ?></h3>
            <span class="price">P<?= $itemData[0][2] ?></span>
            <span class="quantity">qty : <?= $quantity ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</header>
<div class="search-bar" id="search">
  <form action="" class="search-form" method="get">
    <input type="search" name="search" id="search-box" placeholder="Search...."
      value="<?= $_GET['search'] ?? NULL ?>" />
    <label for="search-box" class="fas fa-search"></label>
  </form>
</div>
<nav class="user-window">
  <?php if (isset($_SESSION['admin'])): ?>
    <a href="admin">Admin Dashboard</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['admin'])): ?>
    <a href="admin/profile">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['user'])): ?>
    <a href="profile">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['shop'])): ?>
    <a href="shop/?shop_ID=<?=$_SESSION['user_ID']?>">Shop Profile</a>
    <a href="shop/profile.php">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['driver'])): ?>
    <a href="profile">Profile</a>
  <?php endif; ?>
  <a href="db/logout.php">Logout</a>
</nav>