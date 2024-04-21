<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
include '../db/cartAction.php';
$_SESSION['site'] = 'Profile';

$id = $_SESSION['user_ID'];
$conn = new Connection();
$database = new Database($conn->connect());
$cart = new cart($conn->connect());
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$data = $database->showRecords('userdata', "WHERE user_ID = $id");
$data2 = $database->showRecords('userlogin', "WHERE user_ID = $id");
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../includes/head.Include.php' ?>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <?php include '../includes/header.Include.php'; ?>
    <div class="main">
        <div class="container">
            <div class="top">
                <h1 style="font-weight: 600;">Account</h1>
            </div>
            <hr>
            <div class="form">
                <form method="post" action="edit.php">
                    <div class="form-row">
                        <label for="user_Name" class="form-label">Name</label>
                        <input class="form-control" type="text" name="user_Name" id="user_Name"
                            value="<?= $data[0][2] ?>" placeholder="Name">
                    </div>
                    <div class="form-row">
                        <label for="user_Nickname" class="form-label">Nickname</label>
                        <input class="form-control" type="text" name="user_Nickname" id="user_Nickname"
                            value="<?= $data[0][1] ?>" placeholder="Nickname">
                    </div>
                    <div class="form-row">
                        <label for="user_Email" class="form-label">Email</label>
                        <input class="form-control" type="email" name="user_Email" id="user_Email"
                            value="<?= $data2[0][1] ?>" placeholder="Email">
                    </div>
                    <div class="form-row">
                        <label for="user_Password" class="form-label">Password</label>
                        <input class="form-control" type="password" name="user_Password" id="user_Password" placeholder="Password">
                    </div>
                    <div class="form-row">
                        <label for="user_ConfirmPassword" class="form-label">Confirm Password</label>
                        <input class="form-control" type="password" name="user_ConfirmPassword" id="user_ConfirmPassword" placeholder="Confirm Password">
                    </div>
                    <div class="form-row-end">
                        <input type="checkbox" class="form-check-input" onclick="showPassword('user_Password','user_ConfirmPassword')"><a>Show Password</a>
                    </div>
                    <div class="form-row">
                        <label for="user_Phone" class="form-label">Phone</label>
                        <input class="form-control" type="text" name="user_Phone" id="user_Phone"
                            value="<?= $data[0][3] ?>" placeholder="Phone number">
                    </div>
                    <div class="form-row">
                        <label for="user_Location" class="form-label">Location</label>
                        <input class="form-control" type="text" name="user_Location" id="user_Location"
                            value="<?= $data[0][4] ?>" placeholder="Location">
                    </div>

                    <div class="form-row-btn">
                        <button type="button" class="form-btn cancel"
                            onclick="window.location.href='../'"><span class="btn-text">Cancel</span><i
                                class="bi bi-x-lg btn-icon"></i></button>
                        <button type="submit" name="edit" class="form-btn create"><span class="btn-text">Save Changes</span><i class="bi bi-check-lg btn-icon"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <?php include '../includes/footer.Include.php'; ?>
    <script src="../js/products.js"></script>
</body>

</html>