<?php
session_start();
include '../db/actionSort.php';
include '../db/connection.php';
include '../db/cartAction.php';
$_SESSION['site'] = 'Shops';

$conn = new Connection();
$database = new Sort($conn->connect());
$cart = new cart($conn->connect());

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 24;
$_SESSION['page'] = $page;
$result2 = $database->showRecords('shopdata', "LIMIT $offset, 24");
$totalPages = $database->pagination('shop_ID', 24, 'shopdata');

if (isset($_GET['search'])) {
    if ($_GET['search'] == NULL)
        echo "<script>window.location.href='?'</script>";
    $searchq = $_GET['search'];
    $result2 = $database->showRecords('shopdata', "WHERE shop_ID LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' OR shop_Location LIKE '%$searchq%' LIMIT $offset,24");
    $totalPages = $database->pagination('shop_ID', 24, 'shopdata', "WHERE shop_ID LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' OR shop_Location LIKE '%$searchq%'");
}
if (isset($_GET['sort']) && $_GET['sort'] != 'reset') {
    $result2 = $database->sort('shops', $offset, 24, $_GET['sort'], $searchq ?? NULL);
} else {
    $database->namesort = 0;
    $database->locsort = 0;
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
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
    <div class="search" id="search">
        <div class="search-form" method="get" action="">
            <input type="search" name="search" id="search-box" placeholder="Search...."
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="fas fa-search"></button>
        </div>
    </div>
    <div class="sort-container">
        <div class="products-interface">
            <div class="row2">
                <h1>SORT:</h1>
                <button class="sort-button <?= $database->namesort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?sort=<?= $database->sort1 ? 'name-asc' : 'name-desc'; ?>'+searchQuery();">Name
                    <?= $database->sort1 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <button class="sort-button <?= $database->locsort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?sort=<?= $database->sort2 ? 'location-asc' : 'location-desc'; ?>'+searchQuery();">Location
                    <?= $database->sort2 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <?php if (isset($_GET['sort']) && $_GET['sort'] != 'reset'): ?>
                    <button class="sort-button reset-sort" type="button" onclick="resetSort('reset')">Reset</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container" id="search-results">
        <div class="products-interface">
            <div class="row">
                <h1>Shop List</h1>
                <hr>
                <div class="container2">
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
                                    <h1 style="font-weight: 400;"><i class="bi bi-geo-alt-fill"></i><?= $result2[$i][3] ?></h1>
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
                                } ?><?php if (isset($_GET['sort'])) {
                                     echo '&sort=' . $_GET['sort'];
                                 } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page - 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    } ?><?php if (isset($_GET['sort'])) {
                                         echo '&sort=' . $_GET['sort'];
                                     } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item"><a class="page-link <?= ($i === $page) ? "active" : "" ?>" href="?page=<?= $i ?><?php if (isset($_GET['search'])) {
                                          echo '&search=' . $searchq;
                                      } ?><?php if (isset($_GET['sort'])) {
                                           echo '&sort=' . $_GET['sort'];
                                       } ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page + 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    } ?><?php if (isset($_GET['sort'])) {
                                         echo '&sort=' . $_GET['sort'];
                                     } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $totalPages ?><?php if (isset($_GET['search'])) {
                                      echo '&search=' . $searchq;
                                  } ?><?php if (isset($_GET['sort'])) {
                                       echo '&sort=' . $_GET['sort'];
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