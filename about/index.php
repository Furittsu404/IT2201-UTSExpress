<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
include '../db/cartAction.php';
$_SESSION['site'] = 'About';


$conn = new Connection();
$database = new Database($conn->connect());
$cart = new cart($conn->connect());
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}
?>


<!DOCTYPE html>
<html>

<head>
  <?php include '../includes/head.Include.php' ?>
  <link rel="stylesheet" href="../css/about.css">
  <title>About</title>
</head>

<body>
  <?php include '../includes/header.Include.php'; ?>

  <section class="contact-section">
    <div class="contact-bg">
      <h3>WELCOME TO</h3>
      <h2>Contact Us</h2>
      <div class="line">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <p class="text">Hindi ba masarap ang ulam? pwes mag email para malaman namin</p>
    </div>


    <div class="contact-body">
    <div style="text-align: center;">
    <h1 style="display: inline; font-size: 40px;">About Us</h1>
</div>

      <div class="contact-info">
        <div>
          <span><i class="fas fa-mobile-alt"></i></span>
          <span>Phone No.</span>
          <span class="text">09123456789</span>
        </div>
        <div>
          <span><i class="fas fa-envelope-open"></i></span>
          <span>E-mail</span>
          <span class="text">shop1@company.com</span>
        </div>
        <div>
          <span><i class="fas fa-map-marker-alt"></i></span>
          <span>Address</span>
          <span class="text">CLSU New Market</span>
        </div>
        <div>
          <span><i class="fas fa-clock"></i></span>
          <span>Opening Hours</span>
          <span class="text">Monday - Friday (6:00 AM to 5:00 PM)</span>
        </div>
      </div>
      

      <div class="contact-form">
        <form>
          <div>
            <input type="text" class="form-control" placeholder="First Name">
            <input type="text" class="form-control" placeholder="Last Name">
          </div>
          <div>
            <input type="mail" class="form-control" placeholder="E-mail">
            <input type="text" class="form-control" placeholder="Phone">
          </div>
          <textarea rows="5" placeholder="Message" class="form-control"></textarea>
          <input type="submit" class="send-btn" value="send message">
        </form>

        <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d61443.73120647719!2d120.935978!3d15.738798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3390d734edfc1219%3A0x3faa20a6ea786e04!2sCLSU%20New%20Market!5e0!3m2!1sen!2sph!4v1713702057557!5m2!1sen!2sph"
           width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>  
       
      </div>
    </div>

   
  </section>


  <?php include '../includes/footer.Include.php'; ?>
  <script src="../js/products.js"></script>
</body>

</html>
