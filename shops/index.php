<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
$_SESSION['site'] = 'Shops';

$conn = new Connection();
$database = new Database($conn->connect());

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 24;
$_SESSION['page'] = $page;
$result2 = $database->showRecords('shopdata', "ORDER BY rand() LIMIT $offset, 24");
$totalPages = $database->pagination('shop_ID', 24, 'shopdata');

if (isset($_GET['search'])) {
    if($_GET['search'] == NULL)
        echo "<script>window.location.href='?'</script>";
    $searchq = $_GET['search'];
    $result2 = $database->showRecords('shopdata', "WHERE shop_ID LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' OR shop_Location LIKE '%$searchq%' LIMIT $offset,24");
    $totalPages = $database->pagination('shop_ID', 24, 'shopdata', "WHERE shop_ID LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' OR shop_Location LIKE '%$searchq%'");
}

$sort1 = 1;
$sort2 = 2;
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'name-ascending') {
        $result2 = $database->showRecords('shopdata', "ORDER BY shop_Name ASC LIMIT $offset, 24");
        $namesort = 1;
        $sort1 = 0;
    } else if ($_GET['sort'] == 'name-descending') {
        $result2 = $database->showRecords('shopdata', "ORDER BY shop_Name DESC LIMIT $offset, 24");
        $namesort = 1;
        $sort1 = 1;
    } else if ($_GET['sort'] == 'location-ascending') {
        $result2 = $database->showRecords('shopdata', "ORDER BY shop_Location ASC LIMIT $offset, 24");
        $locsort = 1;
        $sort2 = 0;
    } else if ($_GET['sort'] == 'location-descending') {
        $result2 = $database->showRecords('shopdata', "ORDER BY shop_Location DESC LIMIT $offset, 24");
        $locsort = 1;
        $sort2 = 1;
    }
} else {
    $namesort = 0;
    $locsort = 0;
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

    <div class="sort-container">
        <div class="products-interface">
            <div class="row2">
                <h1>SORT:</h1>
                <button class="sort-button <?= $namesort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?sort=<?= $sort1 ? 'name-ascending' : 'name-descending'; ?>'">Name
                    <?= $sort1 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <button class="sort-button <?= $locsort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?sort=<?= $sort2 ? 'location-ascending' : 'location-descending'; ?>'">Location
                    <?= $sort2 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <?php if (isset($_GET['sort']) || isset($_GET['search'])): ?>
                    <button class="sort-button reset-sort" type="button" onclick="window.location.href='?'">Reset</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="products-interface">
            <div class="row">
                <h1>Shop List</h1>
                <hr>
                <div class="container2">
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
                                <h1 style="font-weight: 400;"><i class="bi bi-geo-alt-fill"></i><?= $result2[$i][3] ?></h1>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.Include.php' ?>
    <script src="../js/index.js"></script>
</body>

</html>