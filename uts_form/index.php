<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
        $plate_no = mysqli_real_escape_string($conn, $_POST['plate_no']);
        $license_id = mysqli_real_escape_string($conn, $_POST['license_id']);
        
        $sql = "INSERT INTO uts (full_name, email, contact_no, plate_no, license_id) 
        VALUES ('$full_name', '$email', '$contact_no', '$plate_no', '$license_id')";

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

  <style>
      * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-size: cover;
        }
        .container-fluid {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }
        .section-container {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #343a40;
            border-color: #343a40;
            width: 100%;
        }
  </style>
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
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required> 
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-md-6">
            <label for="contact_no" class="form-label">Contact No.</label>
            <input type="text" class="form-control" id="contact_no" name="contact_no" required> 
        </div>
        <div class="col-md-6">
            <label for="plate_no" class="form-label">UTS NO. / Plate No.</label>
            <input type="text" class="form-control" id="plate_no" name="plate_no" required> 
        </div>
        <div class="col-md-6">
            <label for="license_id" class="form-label">License / ID Card</label>
            <input type="file" name="license_id" id="license_id" accept=".png, .jpg, .jpeg, .pdf" required> 
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button> 
        </div>
    </form>
  </section>
</body>
</html>
