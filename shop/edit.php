<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
$id = $_SESSION['user_ID'];
$conn = new Connection();
$database = new Database($conn->connect());

if ($_POST['shop_Password'] != $_POST['shop_ConfirmPassword']) {
    echo "<script>alert('Password does not match!')</script>";
    echo "<script>window.location.href='profile.php';</script>";
    exit();
}

$verifyEmail = $database->verifyEmail($_POST['shop_Email'],$id);
if (!$verifyEmail) {
    $shop = [];
    $shopdata = [];
    foreach ($_POST as $name => $val) {
        if ($name == 'shop_Password' && $val != NULL)
            $shop[$name] = password_hash($val, PASSWORD_BCRYPT);
        else if ($name == 'shop_Email' && $val != NULL)
            $shop[$name] = $val;
        else if ($val != NULL && $name != 'shop_ConfirmPassword')
            $shopdata[$name] = $val;
    }
    $email = $_POST['shop_Email'];
    $show = $database->showRecords('shoplogin', "WHERE shop_Email = '$email'");
    if ($show && $show[0][0] != $id) {
        echo "<script>alert('Email already exists!')</script>";
    } else {
        try {
            $action = $database->updateRecord($shop, 'shoplogin', ['shop_ID' => $id]);
            $action2 = $database->updateRecord($shopdata, 'shopdata', ['shop_ID' => $id]);
            echo "<script>alert('Account Updated Successfully.')</script>";
            echo '<script>window.location.href="../";</script>';
        } catch (Exception $e) {
            echo "Error: $e";

        }
    }
    echo "<script>window.location.href='../';</script>";
} else {
    echo "<script>alert('Email already exists!')</script>";
    echo "<script>window.location.href='profile.php';</script>";
}

?>