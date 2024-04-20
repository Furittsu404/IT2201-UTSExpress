<?php
session_start();
include '../db/connection.php';
include '../db/cartAction.php';

$conn = new Connection();
$cart = new cart($conn->connect());

if (isset($_POST['id'])) {
    $cart->validateCart();
    if (isset($_POST['delete'])) {
        $cart->deleteCart();
        if (isset($_SESSION['user_ID'])) {
            $cart->saveCart();
        }
    } else {
        if (isset($_SESSION['user_ID'])) {
            $cart->addCart();
            $cart->saveCart();
        } else {
            $cart->addCart();
        }
    }

}
?>