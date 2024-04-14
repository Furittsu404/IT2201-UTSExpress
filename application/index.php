<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $shop_name = mysqli_real_escape_string($conn, $_POST['shop_name']);
        $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $shop_loc = mysqli_real_escape_string($conn, $_POST['shop_loc']);
        $shop_logo = mysqli_real_escape_string($conn, $_POST['shop_logo']);
        
        $sql = "INSERT INTO shops (shop_name, contact_no, email, shop_loc, shop_logo) 
        VALUES ('$shop_name', '$contact_no', '$email', '$shop_loc', '$shop_logo')";

        if ($conn->query($sql) === TRUE) {
            $message = "Data inserted successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>Form</title>

 
</head>
<body>
  <header class="text-center">
    <h1 class="display-6">Fill out Form</h1>
  </header>
  <section class="container my-2 section-container">
    <?php if (isset($message)) : ?>
    <div class="alert alert-<?php echo isset($message) && strpos($message, "Error") !== false ? "danger" : "success"; ?>" role="alert">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>
    <form class="row g-3 p-3" enctype="multipart/form-data" method="post">
        <div class="col-md-6">
            <label for="shop_name" class="form-label">Shop Name:</label>
            <input type="text" class="form-control" id="shop_name" name="shop_name" required> 
        </div>
        <div class="col-md-6">
            <label for="contact_no" class="form-label">Shop Contact No.</label>
            <input type="text" class="form-control" id="contact_no" name="contact_no" required>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Shop email</label>
            <input type="email" class="form-control" id="email" name="email" required> 
        </div>
        <div class="col-md-6">
            <label for="shop_loc" class="form-label">Shop Location</label>
            <input type="text" class="form-control" id="shop_loc" name="shop_loc" required> 
        </div>
        <div class="col-md-6">
            <label for="shop_logo" class="form-label">Shop Logo</label>
            <input type="file" name="shop_logo" id="shop_logo" accept=".png, .jpg, .jpeg, .pdf" required> 
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button> 
        </div>
    </form>
  </section>
</body>
</html>
