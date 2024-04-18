<?php
session_start();
include '../db/connection.php';
include '../db/cartAction.php';

$conn = new Connection();
$cart = new cart($conn->connect());

if (isset($_POST['id'])) {
    if (isset($_POST['delete'])) {
        $cart->deleteCart();
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