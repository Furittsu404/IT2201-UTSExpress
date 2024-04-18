<?php
session_start();
include '../db/actionSort.php';
include '../db/connection.php';
$_SESSION['site'] = 'Products';

$conn = new Connection();
$database = new Sort($conn->connect());

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 24;
$_SESSION['page'] = $page;
$result = $database->showRecords('shopproducts', "LIMIT $offset, 24");
$result2 = $database->showRecords('shopdata', "ORDER BY rand() LIMIT 0, 6");
$totalPages = $database->pagination('product_ID', 24, 'shopproducts');
if (isset($_GET['search'])) {
    if ($_GET['search'] == NULL)
        echo "<script>window.location.href='?'</script>";
    $searchq = $_GET['search'];
    $result = $database->showRecords('shopproducts', "WHERE product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%' LIMIT $offset, 24");
    $totalPages = $database->pagination('product_ID', 24, 'shopproducts', "WHERE product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%'");
}
if (isset($_GET['sort']) && $_GET['sort'] != 'reset') {
    $result = $database->sort('products', $offset, 24, $_GET['sort'], $searchq ?? NULL);
} else {
    $database->namesort = 0;
    $database->pricesort = 0;
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
    <div class="search" id="search">
        <div class="search-form" method="get" action="">
            <input type="search" name="search" id="search-box" placeholder="Search...."
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="fas fa-search"></button>
        </div>
    </div>
    <div class="container">
        <div class="home">
            <div class="row">
                <h1>Shops you may like</h1>
                <hr>
                <div class="row2">
                    <?php if (count($result2) > 0): ?>
                        <?php for ($i = 0; $i < count($result2); $i++): ?>
                            <div class="shop-container"
                                onclick="window.location.href='../shop/?shop_ID=<?= $result2[$i][0] ?>'">
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
        </div>


        <div class="products-interface">

            <div class="row3">
                <h1>SORT PRODUCTS:</h1>
                <button class="sort-button <?= $database->namesort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?sort=<?= $database->sort1 ? 'name-asc' : 'name-desc'; ?>'+searchQuery();">Name
                    <?= $database->sort1 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <button class="sort-button <?= $database->pricesort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?sort=<?= $database->sort2 ? 'price-asc' : 'price-desc'; ?>'+searchQuery();">Price
                    <?= $database->sort2 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <?php if (isset($_GET['sort']) && $_GET['sort'] != 'reset'): ?>
                    <button class="sort-button reset-sort" type="button" onclick="resetSort('reset')">Reset</button>
                <?php endif; ?>
            </div>
            <div class="col" id="search-results">
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
                                    <br>
                                    <button type="button" id="add-to-cart-btn" class="add-cart">Add
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
                <div>
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1<?php if (isset($_GET['search'])) {
                                    echo '&search=' . $searchq;
                                }
                                if (isset($_GET['sort'])) {
                                    echo '&sort=' . $_GET["sort"];
                                } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page - 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    }
                                    if (isset($_GET['sort'])) {
                                        echo '&sort=' . $_GET["sort"];
                                    } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item"><a class="page-link <?= ($i === $page) ? "active" : "" ?>" href="?page=<?= $i ?><?php if (isset($_GET['search'])) {
                                          echo '&search=' . $searchq;
                                      }
                                      if (isset($_GET['sort'])) {
                                          echo '&sort=' . $_GET["sort"];
                                      } ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page + 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    }
                                    if (isset($_GET['sort'])) {
                                        echo '&sort=' . $_GET["sort"];
                                    } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $totalPages ?><?php if (isset($_GET['search'])) {
                                      echo '&search=' . $searchq;
                                  }
                                  if (isset($_GET['sort'])) {
                                      echo '&sort=' . $_GET["sort"];
                                  } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.Include.php' ?>
    <script src="../js/index.js"></script>
    <script src="../js/products.js"></script>
    <script>
        function handleSearchQuery() {
            const searchQuery = document.getElementById('search-box').value;
            const sortType = '<?= isset($_GET['sort']) ? $_GET['sort'] : 'reset' ?>';
            const page = <?= $page ? $page : NULL ?>;

            const search = new XMLHttpRequest();
            search.open('GET', `search.php?search=${searchQuery}<?= isset($_GET['sort']) ? '&sort=${sortType}' : '' ?><?= isset($_GET['page']) ? '&page=${page}' : '' ?>`, true);
            search.onreadystatechange = function () {
                if (search.readyState === 4 && search.status === 200) {
                    document.getElementById('search-results').innerHTML = search.responseText;
                }
            };
            search.send();
        }
        document.getElementById('search-box').addEventListener('input', handleSearchQuery);
    </script>
</body>

</html>