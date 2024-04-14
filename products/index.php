<?php
session_start();
include '../db/action.php';
include '../db/connection.php';

$conn = new Connection();
$database = new Database($conn->connect());

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 15;
$_SESSION['page'] = $page;
$result = $database->showRecords('shopproducts', "LIMIT $offset, 15");
$result2 = $database->showRecords('shopdata', "ORDER BY rand() LIMIT 0, 5");
$totalPages = $database->pagination('product_ID', 15, 'shopproducts');

if (isset($_GET['search'])) {
    $searchq = $_GET['search'];
    $result = $database->showRecords('shopproducts', "WHERE product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%' LIMIT $offset, 15");
    $result2 = $database->showRecords('shopdata', "WHERE shop_ID LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' LIMIT 0,5");
    $totalPages = $database->pagination('product_ID', 15, 'shopproducts', "WHERE product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%'");
}
?>


<!DOCTYPE html>
<html>

<head>
    <?php include '../includes/head.Include.php' ?>
    <title>Shops</title>
    <link rel="stylesheet" href="../css/shops.css">
</head>

<body>
    <?php include '../includes/header.Include.php' ?>

    <div class="container">
        <div class="products-interface">
            <div>
                <div class="row">
                    <h1>Featured Shops</h1>
                    <hr>
                    <div class="row2">
                    <?php if (count($result2) > 0): ?>
                        <?php for ($i = 0; $i < count($result2); $i++): ?>
                        <div class="shop-container">
                            <div class="shop-image">
                                <img src="../img/<?= $result2[$i][0] ?>/shop_Image.png">
                            </div>
                            <br><hr1><br>
                            <h1><?= $result2[$i][1] ?></h1>
                        </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="col">
                    <?php if (count($result) > 0): ?>
                        <?php for ($i = 0; $i < count($result); $i++): ?>
                            <?php $product_ID[$i] = $result[$i][0] ?>
                            <div class="product-container">
                                <div class="product-image">
                                    <img src="../img/<?= $result[$i][5] ?>/products/<?= $result[$i][0] ?>.png">
                                </div>
                                <h1><?= $result[$i][1] ?></h1>
                            </div>
                            <div class="product-container">
                                <div class="product-image">
                                    <img src="../img/<?= $result[$i][5] ?>/products/<?= $result[$i][0] ?>.png">
                                </div>
                                <h1><?= $result[$i][1] ?></h1>
                            </div>
                            <div class="product-container">
                                <div class="product-image">
                                    <img src="../img/<?= $result[$i][5] ?>/products/<?= $result[$i][0] ?>.png">
                                </div>
                                <h1><?= $result[$i][1] ?></h1>
                            </div>
                            <div class="product-container">
                                <div class="product-image">
                                    <img src="../img/<?= $result[$i][5] ?>/products/<?= $result[$i][0] ?>.png">
                                </div>
                                <h1><?= $result[$i][1] ?></h1>
                            </div>
                            <div class="product-container">
                                <div class="product-image">
                                    <img src="../img/<?= $result[$i][5] ?>/products/<?= $result[$i][0] ?>.png">
                                </div>
                                <h1><?= $result[$i][1] ?></h1>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/index.js"></script>
</body>

</html>