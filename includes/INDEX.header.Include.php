<header class="header" id="header">
  <a href="?"><img src="img/UTS-Express.png" class="logo" /></a>

  <nav class="navbar">
    <a href="?" class="<?= ($_SESSION['site'] === 'Home') ? "active-tab navtxt" : "navtxt" ?>" id="navtxt">Home</a>
    <a href="products" class="<?= ($_SESSION['site'] === 'Products') ? "active-tab navtxt1" : "navtxt1" ?>" id="navtxt">Products</a>
    <a href="shops" class="<?= ($_SESSION['site'] === 'Shops') ? "active-tab navtxt2" : "navtxt2" ?>" id="navtxt">Shops</a>
    <a href="about" class="<?= ($_SESSION['site'] === 'About') ? "active-tab navtxt3" : "navtxt3" ?>" id="navtxt">About Us</a>
    <a href="faq" class="<?= ($_SESSION['site'] === 'Faq') ? "active-tab navtxt4" : "navtxt4" ?>" id="navtxt">FAQ</a>
  </nav>

  <div class="icons" id="nav">
    <div class="fas fa-bars" id="menu-btn"></div>
    <div class="fas fa-search" id="search-btn"></div>
    <div class="fas fa-shopping-cart" id="cart-btn"></div>
    <?php
    if (isset($_SESSION['user_ID'])) {
      echo '<div class="fas fa-user" id="user-btn"></div>';
    } else {
      echo '<div class="fas fa-user" id="user-btn" style="display: none;"></div>';
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
    <a href="shop/profile">Profile</a>
  <?php endif; ?>
  <?php if (isset($_SESSION['driver'])): ?>
    <a href="profile">Profile</a>
  <?php endif; ?>
  <a href="db/logout.php">Logout</a>
</nav>