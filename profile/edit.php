<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
$id = $_SESSION['user_ID'];
$conn = new Connection();
$database = new Database($conn->connect());

if ($_POST['user_Password'] != $_POST['user_ConfirmPassword']) {
    echo "<script>alert('Password does not match!')</script>";
    echo "<script>window.location.href='../profile';</script>";
    exit();
}

$verifyEmail = $database->verifyEmail($_POST['user_Email'],$id);
if (!$verifyEmail) {
    $user = [];
    $userdata = [];
    foreach ($_POST as $name => $val) {
        if ($name == 'user_Password' && $val != NULL)
            $user[$name] = password_hash($val, PASSWORD_BCRYPT);
        else if ($name == 'user_Email' && $val != NULL)
            $user[$name] = $val;
        else if ($val != NULL && $name != 'user_ConfirmPassword')
            $userdata[$name] = $val;
    }
    $email = $_POST['user_Email'];
    $show = $database->showRecords('userlogin', "WHERE user_Email = '$email'");
    if ($show && $show[0][0] != $id) {
        echo "<script>alert('Email already exists!')</script>";
    } else {
        try {
            $action = $database->updateRecord($user, 'userlogin', ['user_ID' => $id]);
            $action2 = $database->updateRecord($userdata, 'userdata', ['user_ID' => $id]);
            echo "<script>alert('Account Updated Successfully.')</script>";
            echo '<script>window.location.href="../";</script>';
        } catch (Exception $e) {
            echo "Error: $e";

        }
    }
    echo "<script>window.location.href='../profile';</script>";
} else {
    echo "<script>alert('Email already exists!')</script>";
    echo "<script>window.location.href='../profile';</script>";
}

?>