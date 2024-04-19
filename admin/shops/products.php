<?php
session_start();
$_SESSION['site'] = 'shopProducts';
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}

$connection = new Connection();
$database = new adminAction($connection->connect());

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 10;
$_SESSION['page'] = $page;
$result = $database->showRecords('shopdata', "LIMIT $offset, 10");
$result2 = $database->showRecords('shoplogin', "LIMIT $offset, 10");
$totalPages = $database->pagination('shop_id', 10, 'shopdata');

if (isset($_GET['search'])) {
    $searchq = $_GET['search'];
    $result = $database->showRecords('shopdata', "WHERE shop_id LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' LIMIT $offset, 10");
    $totalPages = $database->pagination('shop_id', 10, 'shopdata', "WHERE shop_id LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%'");
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Shops Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/admin.userstable.css">
    <link rel="stylesheet" href="../../css/admin.shopproducts.css">
</head>

<body>
    <div class="wrapper">
        <?php include "../../includes/ADMIN.sidebar.Include.php"; ?>
        <div class="main p-3">
            <div class="container">
                <div class="d-flex flex-row justify-content-between align-content-center">
                    <h2>Shop Products</h2>
                    <form class="d-flex flex-row justify-content-end w-50 gap-3" method="get">
                        <input class="form-control mr-sm-2 search-bar" type="search" id="search-bar" name="search"
                            placeholder="Search By ID or Name" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 search search-word"
                            type="submit">Search</button>
                        <?php if (isset($_GET['search'])): ?>
                            <button type="button" class="btn btn-danger my-2 my-sm-0 cancel-word"
                                onclick="window.location.href='?'">Cancel</button>
                        <?php endif; ?>
                        <button class="btn btn-outline-success my-2 my-sm-0 search search-icon" type="button"
                            id="search-icon"><i class="bi bi-search"></i></button>
                        <?php if (isset($_GET['search'])): ?>
                            <button type="button" class="btn btn-danger my-2 my-sm-0 cancel-icon" type="button"
                                id="search-icon" onclick="window.location.href='?'"><i class="bi bi-x-lg"></i></button>
                        <?php endif; ?>
                    </form>
                </div>
                <br>
                <?php
                $shop_count = 0;
                for ($i = 1; $i < $page; $i++) {
                    $shop_count += 10;
                }
                ?>

                <?php if (count($result) > 0): ?>
                    <?php for ($i = 0; $i < count($result); $i++): ?>
                        <?php $shop_id[$i] = $result[$i][0] ?>
                        <div class="expandable container d-flex justify-content-between my-0 shopproduct-container"
                            onclick="showHideRow('shops<?php echo ++$shop_count ?>');showHideRow('shops1<?php echo $shop_count ?>');">
                            <div class="expandable d-flex flex-row align-items-center">
                                <?php echo $shop_count ?>.
                                <div class="shop-image"><img src="../../img/<?php echo $result[$i][0] ?>/shop_Image.png"></div>
                                <div class="d-flex flex-column align-items-baseline shop-title">
                                    <p class="fw-bold fs-4 text-1"><?php echo $result[$i][1] ?></p>
                                    <p class="fs-6 text-2"><?php echo $result2[$i][1] ?></p>
                                </div>
                            </div>
                            <i class="bi bi-caret-down-fill align-self-center" style="color: darkgreen;"></i>
                        </div>
                        <div class="d-flex align-content-center justify-content-center">
                            <div id='shops<?php echo $shop_count ?>' class='hidden products-container p-2'>

                                <div class="product-row gap-3 justify-content-center align-content-center">
                                    <?php $result3 = $database->showRecords('shopproducts', "WHERE shop_id = $shop_id[$i]"); ?>
                                    <?php if (count($result3) > 0): ?>
                                        <?php for ($j = 0; $j < count($result3); $j++): ?>
                                            <div class="product p-3 overflow-hidden">
                                                <div class="product-image">
                                                    <img src="../../img/<?= $result3[$j][5] ?>/products/<?= $result3[$j][0] ?>.png">
                                                </div>
                                                <h1><?= $result3[$j][1] ?></h1>
                                                <div class="row gap-1 justify-content-center">
                                                    <button class='edit w-40 btn btn-success'
                                                        onclick='window.location.href="editProducts.php?product_ID=<?= $result3[$j][0] ?>"'><span
                                                            class="action-word">Edit</span><i
                                                            class='bi bi-pencil action-btn'></i></button>
                                                    <button class='delete w-40 btn btn-outline-danger'
                                                        onclick='window.location.href="deleteProducts.php?product_ID=<?= $result3[$j][0] ?>"'><span
                                                            class='action-word'>Delete</span><i
                                                            class='bi bi-trash action-btn'></i></button>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <br>

                    <?php endfor; ?>
                <?php endif; ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center p-3">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1<?php if (isset($_GET['search'])) {
                                    echo '&search=' . $searchq;
                                } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page - 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item"><a class="page-link <?= ($i === $page) ? "active" : "" ?>" href="?page=<?= $i ?><?php if (isset($_GET['search'])) {
                                          echo '&search=' . $searchq;
                                      } ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page + 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $totalPages ?><?php if (isset($_GET['search'])) {
                                      echo '&search=' . $searchq;
                                  } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/admin.js"></script>
</body>

</html>