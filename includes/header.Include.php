<?php if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = []; ?>

<header class="header" id="header">
  <a href="../"><img src="../img/UTS-Express.png" class="logo" /></a>

  <nav class="navbar">
    <a href="../" class="<?= ($_SESSION['site'] === 'Home') ? "active-tab navtxt" : "navtxt" ?>" id="navtxt">Home</a>
    <a href="../products" class="<?= ($_SESSION['site'] === 'Products') ? "active-tab navtxt1" : "navtxt1" ?>"
      id="navtxt">Products</a>
    <a href="../shops" class="<?= ($_SESSION['site'] === 'Shops') ? "active-tab navtxt2" : "navtxt2" ?>"
      id="navtxt">Shops</a>
    <a href="../about" class="<?= ($_SESSION['site'] === 'About') ? "active-tab navtxt3" : "navtxt3" ?>"
      id="navtxt">About Us</a>
    <a href="../faq" class="<?= ($_SESSION['site'] === 'Faq') ? "active-tab navtxt4" : "navtxt4" ?>" id="navtxt">FAQ</a>
  </nav>

  <div class="icons" id="nav">
    <div class="fas fa-bars" id="menu-btn"></div>
    <div class="fas fa-search" id="search-btn" style="display: none;"></div>
    <div class="fas fa-shopping-cart static" id="cart-btn"><a id="cart-icon"
        class="cart-icon"><?= array_sum($_SESSION['cart']); ?></a></div>
    <?php
    if (isset($_SESSION['user_ID'])) {
      echo '<div class="fas fa-user" id="user-btn"></div>';
    } else {
      echo '<div class="fas fa-user" id="user-btn" ></div>';
    }
    ?>
  </div>

  <div class="shopping-cart" id="cart">
    <div class="box">
      <i class="fas fa-trash"></i>
      <img src="img/carbo.png" alt="" />
      <div class="content">
        <h3>Carbo Pare</h3>
        <span class="price">40PHP</span>
        <span class="quantity">qty : 1</span>
      </div>
    </div>
    <div class="box">
      <i class="fas fa-trash"></i>
      <img src="img/carbo.png" alt="" />
      <div class="content">
        <h3>Carbo Pare</h3>
        <span class="price">40PHP</span>
        <span class="quantity">qty : 1</span>
      </div>
    </div>
    <div class="box">
      <i class="fas fa-trash"></i>
      <img src="img/carbo.png" alt="" />
      <div class="content">
        <h3>Carbo Pare</h3>
        <span class="price">40PHP</span>
        <span class="quantity">qty : 1</span>
      </div>
    </div>
    <div class="total">total : 1000</div>
    <a href="#" class="btn" style="color: black">checkout</a>
  </div>

</header>
<nav class="user-window">
  <?php if (isset($_SESSION['admin'])): ?>
    <a href="../admin">Admin Dashboard</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['admin'])): ?>
    <a href="../admin/profile">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['user'])): ?>
    <a href="../profile">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['shop'])): ?>
    <a href="../shop/?shop_ID=<?= $_SESSION['user_ID'] ?>">Shop Profile</a>
    <a href="../shop/profile">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['driver'])): ?>
    <a href="../profile">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['user_ID'])): ?>
    <a href="../db/logout.php">Logout</a>
  <?php endif; ?>
  <?php if (!isset($_SESSION['user_ID'])): ?>
    <a href="../db/USER.login.php">Login</a>
    <a href="../db/USER.login.php#reg">Register</a>
  <?php endif; ?>
</nav>