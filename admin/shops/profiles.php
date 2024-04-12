<?php
session_start();
$_SESSION['site'] = 'shopProfiles';
include '../../db/action.php';
include '../../db/connection.php';

$connection = new Connection();
$database = new Database($connection->connect());
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Admin Dashboard</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>
    <div class="wrapper">
        <?php include '../../includes/ADMIN.sidebar.Include.php'; ?>
        <div class="main p-3">
            <div class="welcome">
                <p>WELCOME TO PROFILE FUCK YOU</p>
            </div>
        </div>
    </div>

    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/admin.js"></script>
</body>

</html>