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
      <h2>About Us</h2>
      <div class="line">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <p class="text">UTS Express is an online delivery platform specifically for the CLSU. </p>
    </div>


    <div class="contact-body">

      <div class="contact-info">
        <div>
          <span><i class="fas fa-mobile-alt"></i></span>
          <span>Phone No.</span>
          <span class="text">09167632219</span>
        </div>
        <div>
          <span><i class="fas fa-envelope-open"></i></span>
          <span>E-mail</span>
          <span class="text">utsexp2024@gmail.com</span>
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
        <form id="contact-form">
          <div>
            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
            <input type="text" id="location" name="location" class="form-control" placeholder="Location" required>
          </div>
          <div>
            <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" required>
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required>
          </div>
          <textarea rows="5" id="message" name="message" placeholder="Message" class="form-control"></textarea>
          <input type="submit" class="send-btn" value="send message">
        </form>

        <div class="map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d61443.73120647719!2d120.935978!3d15.738798!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3390d734edfc1219%3A0x3faa20a6ea786e04!2sCLSU%20New%20Market!5e0!3m2!1sen!2sph!4v1713702057557!5m2!1sen!2sph"
            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

      </div>
    </div>


  </section>


  <?php include '../includes/footer.Include.php'; ?>
  <script src="../js/products.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#contact-form').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);

        $.ajax({
          url: '../db/contact.php',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            alert(response);
            window.location.href = '../';
          }
        });
      });
    });
  </script>
</body>

</html>