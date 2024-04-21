<?php
session_start();
include 'db/connection.php';
include 'db/cartAction.php';
include 'db/action.php';

$conn = new Connection();
$database = new Database($conn->connect());
$cart = new cart($conn->connect());
$_SESSION['site'] = 'Home';
if (isset($_GET['search'])) {
  $searchq = $_GET['search'];
  header("Location: products/?search=" . $searchq);
}
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}
$bg = rand(1, 4);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.Include.php' ?>
  <title>Landing Page</title>
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <?php include 'includes/INDEX.header.Include.php'; ?>

  <section class="home" id="home"
    style="background: url(img/<?= $bg ?>.jpg) no-repeat;background-position: bottom;background-size: cover; ">
    <div class="content">
      <h2>UTS CLSU<span> Express</span></h2>
      <p>Welcome!</p>
      <?php
      if (!isset($_SESSION['user_ID']))
        echo '<div class="btn-container">
             <a href="db/USER.login.php#reg" class="btn register">Register</a>
             <a href="db/USER.login.php" class="btn login">Login</a>
             </div>';
      else {
        echo '<h3 class="user_Nickname">' . $_SESSION["user_Nickname"] . '</h3>';
      }
      ?>
    </div>
  </section>

  <section class="features" id="features">
    <br>
    <div class="box-container">
      <div class="box">
        <img src="img/rea.png" alt="" />
        <h3>Reliable service</h3>
        <p>
          Count on us for consistent, dependable service that never
          disappoints. We strive to exceed your expectations with every
          interaction, ensuring peace of mind with every delivery.
        </p>
      </div>

      <div class="box">
        <img src="img/fast-delivery.png" alt="" />
        <h3>Fast Delivery</h3>
        <p>
          Quick delivery, guaranteed. Get your orders swiftly and securely to
          your building, ensuring you never have to wait long for your
          essentials.
        </p>
      </div>

      <div class="box">
        <img src="img/payment.png" alt="" />
        <h3>Easy Payment</h3>
        <p>
          Effortless payments. Easy life. Simplify your checkout process with
          seamless payment options, making your transactions hassle-free and
          convenient.
        </p>
      </div>
    </div>
  </section>

  <section class="join-now" id="join-now">
    <div class="container">
      <div class="container-col">
        <h1 class="heading">For All UTS Drivers</h1>
        <p class="content">
          Accelerate your career as a UTS-Express Driver! Join our program and play a crucial role in transporting
          goods and personnel across the campus. All UTS drivers can partake in this opportunity.
        </p>
        <br />
      </div>
      <img src="img/nato-driver.jpg" />
    </div>
  </section>

  <section class="shop" id="shop">
    <div class="container">
      <img src="img/food-park.jpg" />
      <div class="container-col">
        <h1 class="heading">Sell on UTS-Express today</h1>
        <p class="content">
          Empower your business with UTS-Express Today! Gain access to a unique marketplace tailored for UTS-related
          products and services. Sell directly to UTS stakeholders, supporting their missions with your offerings. Join
          us now to elevate your business presence and seize new opportunities!
        </p>
        <br />
        <a href="#" class="btn-join-now">Join Now</a>
      </div>
    </div>
  </section>

  <section class="join-now" id="join-now">
    <div class="container">
      <div class="container-col">
        <h1 class="heading">All your cravings, delivered.</h1>
        <p class="content">
          Experience ultimate convenience on campus with 'All Your Cravings, Delivered'! Say goodbye to hunger pangs –
          we'll bring your favorite snacks and meals straight to you, wherever you are on campus. Whether you're
          studying late or need a quick bite between classes, our delivery service has got you covered. Simply place
          your order and enjoy delicious treats delivered right to your doorstep on campus!
        </p>
        <br />
        <a href="#" class="btn-join-now">Browse Shops</a>
      </div>
      <img src="img/fan.jpg" />
    </div>
  </section>

  <section class="gallery" id="gallery">
    <h1 class="heading">Gallery</h1>
    <div class="college-container">
      <div class="college">
        <img src="img/agri.jpg" alt="City 1" />
      </div>
      <div class="college">
        <img src="img/arts.jpg" alt="City 2" />
      </div>
      <div class="college">
        <img src="img/business.jpg" alt="City 3" />
      </div>
    </div>
  </section>

  <?php include 'includes/INDEX.footer.Include.php' ?>

  <script src="js/index.js"></script>
  <script>
    $(document).ready(function () {
      $('.trash-btn').on('click', function (e) {
        e.preventDefault();
        let productId = $(this).data('id');
        $.ajax({
          url: 'includes/addToCart.php',
          type: 'POST',
          data: { id: productId, delete: true },
          success: function (response) {
            $('#cart-icon').text(response);
          }
        });
        $.ajax({
          url: 'includes/INDEX.cartUpdate.php',
          type: 'POST',
          data: { id: productId, delete: true },
          success: function (response) {
            $('#cart-content').html(response);
          }
        });
      });
    });
  </script>
</body>

</html>