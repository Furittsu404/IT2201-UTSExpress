<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
$_SESSION['site'] = 'Products';

$conn = new Connection();
$database = new Database($conn->connect());

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 15;
$_SESSION['page'] = $page;
$result = $database->showRecords('shopproducts', "ORDER BY rand() LIMIT $offset, 18");
$result2 = $database->showRecords('shopdata', "ORDER BY rand() LIMIT 0, 6");
$totalPages = $database->pagination('product_ID', 15, 'shopproducts');

if (isset($_GET['search'])) {
    if($_GET['search'] == NULL)
        echo "<script>window.location.href='?'</script>";
    $searchq = $_GET['search'];
    $result = $database->showRecords('shopproducts', "WHERE product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%' LIMIT $offset, 15");
    $result2 = $database->showRecords('shopdata', "WHERE shop_ID LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' LIMIT 0,6");
    $totalPages = $database->pagination('product_ID', 15, 'shopproducts', "WHERE product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%'");
}
$sort1 = 1;
$sort2 = 2;
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'name-ascending') {
        $result = $database->showRecords('shopproducts', "ORDER BY product_Name ASC LIMIT $offset, 24");
        $namesort = 1;
        $sort1 = 0;
    } else if ($_GET['sort'] == 'name-descending') {
        $result = $database->showRecords('shopproducts', "ORDER BY product_Name DESC LIMIT $offset, 24");
        $namesort = 1;
        $sort1 = 1;
    } else if ($_GET['sort'] == 'price-ascending') {
        $result = $database->showRecords('shopproducts', "ORDER BY product_Price ASC LIMIT $offset, 24");
        $pricesort = 1;
        $sort2 = 0;
    } else if ($_GET['sort'] == 'price-descending') {
        $result = $database->showRecords('shopproducts', "ORDER BY product_Price DESC LIMIT $offset, 24");
        $pricesort = 1;
        $sort2 = 1;
    }
} else {
    $namesort = 0;
    $pricesort = 0;
}
?>


<!DOCTYPE html>
<html>

<head>
    <?php include '../includes/head.Include.php' ?>
    <title>Shops</title>
    <link rel="stylesheet" href="../css/products.css">
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
                            <div class="shop-container" onclick="window.location.href='../shop/?shop_ID=<?= $result2[$i][0] ?>'">
                                <div class="shop-image">
                                    <img src="../img/<?= $result2[$i][0] ?>/shop_Image.png">
                                </div>
                                <br>
                                <hr1>
                                <br>
                                <h1><?= $result2[$i][1] ?></h1>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="row3">
                    <h1>SORT PRODUCTS:</h1>
                    <button class="sort-button <?= $namesort ? 'active-sort' : '' ?>" type="button"
                        onclick="window.location.href='?sort=<?= $sort1 ? 'name-ascending' : 'name-descending'; ?>'">Name
                        <?= $sort1 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                    <button class="sort-button <?= $pricesort ? 'active-sort' : '' ?>" type="button"
                        onclick="window.location.href='?sort=<?= $sort2 ? 'price-ascending' : 'price-descending'; ?>'">Price
                        <?= $sort2 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                    <?php if (isset($_GET['sort']) || isset($_GET['search'])): ?>
                        <button class="sort-button reset-sort" type="button"
                            onclick="window.location.href='?'">Reset</button>
                    <?php endif; ?>
                </div>
                <div class="col">
                    <h1>Products</h1>
                    <hr>
                    <div class="container2">
                        <?php if (count($result) > 0): ?>
                            <?php for ($i = 0; $i < count($result); $i++): ?>
                                <?php $product_ID[$i] = $result[$i][0] ?>
                                <div class="product-container">
                                    <div class="product-image" onclick="showModal('description<?= $i ?>')">
                                        <img src=" ../img/<?= $result[$i][5] ?>/products/<?= $result[$i][0] ?>.png">
                                    </div>
                                    <a onclick="showModal('description<?= $i ?>')">
                                        <h1 style="color: darkgreen;cursor: pointer;"><?= $result[$i][1] ?></h1>
                                        <h1 style="color: darkgreen;align-self: left;">P<?= $result[$i][2] ?></h1>
                                    </a>
                                    <div class="end">
                                        <button type="button" onclick="showModal('description<?= $i ?>')"
                                            class="info">Info</button>
                                        <button type="button" onclick="AddToCart()" class="add-cart">Add
                                            to Cart</button>
                                    </div>
                                </div>
                                <div id="description<?= $i ?>" class="modal">
                                    <div class="modal-content">
                                        <div class="close" onclick="closeModal('description<?= $i ?>')">&times;</div>
                                        <h1><?= $result[$i][1] ?></h1>
                                        <hr><br>
                                        <h1 style="font-weight: 400;"><?= $result[$i][3] ?></h1>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.Include.php' ?>                           
    <script src="../js/index.js"></script>
</body>

</html>