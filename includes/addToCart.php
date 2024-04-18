<?php
session_start();
include '../db/connection.php';

$conn = new Connection();

if (isset($_POST['id'])) {
    $cart->saveCart($conn->connect());
}
?>