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
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'validate') {
        if (sizeof($_SESSION['cart']) == 10) {
            if (isset($_SESSION['cart'][$_POST['id2']]))
                echo 'success';
            else 
                echo 'max';
        } else {
            echo 'success';
        }
    }
}
?>