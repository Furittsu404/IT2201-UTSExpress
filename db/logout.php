<?php
session_start();
session_destroy();
session_start();
$_SESSION['cart'] = [];
header("Location: ..");
?>