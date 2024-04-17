<?php
session_start();
include '../db/actionSort.php';
include '../db/connection.php';
$_SESSION['site'] = 'Shops';

$conn = new Connection();
$database = new Sort($conn->connect());

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
?>

<div class="products-interface" id="ajax-pagination">
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