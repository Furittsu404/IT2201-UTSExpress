<?php
session_start();
$_SESSION['site'] = 'adminAccount';
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

$id = $_SESSION['user_ID'];
$connection = new Connection();
$database = new adminAction($connection->connect());


if ($_POST['admin_Password'] != $_POST['admin_ConfirmPassword']) {
    echo "<script>alert('Password does not match!')</script>";
    echo "<script>window.location.href='../profile';</script>";
    exit();
}

$verifyEmail = $database->verifyEmail($_POST['admin_Email'], $id);
if (!$verifyEmail) {
    $admin = [];
    foreach ($_POST as $name => $val) {
        if ($name == 'admin_Password' && $val != NULL)
            $admin[$name] = password_hash($val, PASSWORD_BCRYPT);
        else if ($name != 'edit' && $name != 'admin_Password' && $name != 'admin_ConfirmPassword')
            $admin[$name] = $val;
    }
    $email = $_POST['admin_Email'];
    $show = $database->showRecords('adminlogin', "WHERE admin_Email = '$email'");
    if ($show && $show[0][0] != $id) {
        echo "<script>alert('Email already exists!')</script>";
    } else {
        try {
            $action = $database->updateRecord($admin, 'adminlogin', ['admin_ID' => $id]);
            echo "<script>alert('Account Updated Successfully.')</script>";
            echo '<script>window.location.href="../";</script>';
        } catch (Exception $e) {
            echo "Error: $e";
        }
    }
} else {
    echo "<script>alert('Email already exists!')</script>";
    echo "<script>window.location.href='../profile';</script>";
}