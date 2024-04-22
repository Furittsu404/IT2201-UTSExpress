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
                    <?php if (isset($_SESSION['user']) || !isset($_SESSION['user_ID'])): ?>
                        <button type="button" class="add-cart cartbtn" data-id="<?= $result[$i][0] ?>">Add
                            to Cart</button>
                    <?php endif; ?>
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

<script>
    $(document).ready(function () {
        $('.cartbtn').on('click', function (e) {
            e.preventDefault();
            let productId = $(this).data('id');
            $.ajax({
                url: '../includes/addToCart.php',
                type: 'POST',
                data: { id: productId },
                success: function (response) {
                    $('#cart-icon').text(response);
                }
            });
            $.ajax({
                url: '../includes/addToCart.php',
                type: 'POST',
                data: { action: 'validate', id2: productId },
                success: function (response) {
                    if (response === 'success') {
                        showModal('addCartModal');
                    } else if (response === 'max') {
                        showModal('maxCartModal');
                    }
                }
            });
            $.ajax({
                url: '../includes/cartUpdate.php',
                type: 'POST',
                data: { id: productId },
                success: function (response) {
                    $('#cart-content').html(response);
                }
            });
        });
    });
</script>