<?php include_once '../db/action.php'; ?>
<?php $cart->validateCart(); ?>
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
  </nav>

  <div class="icons" id="nav">
    <div class="fas fa-bars" id="menu-btn"></div>
    <div class="fas fa-search" id="search-btn" style="display: none;"></div>
    <div class="fas fa-shopping-cart static" id="cart-btn"><a id="cart-icon"
        class="cart-icon"><?= sizeof($_SESSION['cart']); ?></a></div>
    <?php
    if (isset($_SESSION['user_ID'])) {
      echo '<div class="fas fa-user" id="user-btn"></div>';
    } else {
      echo '<div class="fas fa-user" id="user-btn" ></div>';
    }
    ?>
  </div>

  <div class="shopping-cart" id="cart">
    <a href="../checkout" class="btn" style="color: black">Checkout</a>
    <div id="cart-content">
      <div class="total">Total : <?= sizeof($_SESSION['cart']) ?></div>
      <div class="total" style="padding: 0;font-size: 2rem;">Cost : P<?= $cart->getTotal() ?></div>
      <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
        <?php $itemData = $database->showRecords('shopproducts', "WHERE product_ID = '$id'"); ?>
        <div class="box">
          <i class="fas fa-trash trash-btn" data-id="<?= $id ?>"></i>
          <div class="cart-img-container">
            <img src="../img/<?= $itemData[0][5] ?>/products/<?= $id ?>.png" alt="" />
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
    <a href="../shop/profile.php">Profile</a>
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

<div id="addCartModal" class="modal">
  <div class="modal-content" style="width: 300px;">
  <div>
    <div class="close" onclick="closeModal('addCartModal')">&times;</div>
    <h1>Product Added!</h1>
  </div>
    <hr><br>
    <h1 style="text-align:center;font-size: 8rem;color: green;"><i class="bi bi-check-circle"></i></h1>
    <h1 style="font-weight: 400;text-align: center;">Product Added to Cart Successfuly.</h1>
  </div>
</div>

<div id="maxCartModal" class="modal">
  <div class="modal-content" style="width: 300px;">
  <div>
    <div class="close" onclick="closeModal('addCartModal')">&times;</div>
    <h1>Cart Limit Reached!</h1>
  </div>
    <hr><br>
    <h1 style="text-align:center;font-size: 8rem;color: red;"><i class="bi bi-exclamation-circle"></i></h1>
    <h1 style="font-weight: 400;text-align: center;">You can only add a max of 10 items in your cart.</h1>
  </div>
</div>