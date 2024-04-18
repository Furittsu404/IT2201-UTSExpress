<?php
session_start();
include '../db/actionSort.php';
include '../db/connection.php';
include '../db/cartAction.php';

$_SESSION['site'] = 'Shops';
$shopPage = true;
$shop_ID = $_GET['shop_ID'];

$conn = new Connection();
$database = new Sort($conn->connect());
$cart = new cart($conn->connect());

if (isset($_POST['create'])) {
    $database->validateFile($_FILES, key($_FILES));
    $key = $database->addProduct($_POST);
    $name = $database->showRecords('shopproducts', "WHERE shop_ID LIKE '$shop_ID' ORDER BY product_ID DESC LIMIT 0,1");
    $database->moveFile($shop_ID, $name[0][0], $_FILES, '../img', 'products');
    $_POST = [];
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 9;
$result = $database->showRecords('shopproducts', "WHERE shop_ID LIKE $shop_ID LIMIT $offset, 9");
$totalPages = $database->pagination('product_ID', 9, 'shopproducts', "WHERE shop_ID = '$shop_ID'");
$result2 = $database->showRecords('shopdata', "WHERE shop_ID LIKE '$shop_ID'");
$new = $database->showRecords('shopproducts', "WHERE shop_ID LIKE '$shop_ID' ORDER BY product_ID DESC LIMIT 0,3");

if (isset($_GET['search'])) {
    if ($_GET['search'] == NULL)
        echo "<script>window.location.href='?'</script>";
    $searchq = $_GET['search'];
    $result = $database->showRecords('shopproducts', "WHERE shop_ID = '$shop_ID' AND product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%' LIMIT $offset, 9");
    $totalPages = $database->pagination('product_ID', 9, 'shopproducts', "WHERE shop_ID = $shop_ID AND product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%'");
}

if (isset($_GET['sort']) && $_GET['sort'] != 'reset') {
    $result = $database->sort('shopPage', $offset, 9, $_GET['sort'], $searchq ?? NULL, $_GET['shop_ID']);
} else {
    $database->namesort = 0;
    $database->pricesort = 0;
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.Include.php'; ?>
    <title><?= $result2[0][1] ?></title>
    <link rel="stylesheet" href="../css/shopPage.css">

</head>

<body>
    <?php include '../includes/header.Include.php'; ?>

    <section class="home" id="home"
        style="background: url('../img/<?= $shop_ID ?>/shop_Image.png') no-repeat;background-position: center;background-size: cover;">
        <div class="content">
            <h1 style="font-size: 4em;color: darkgreen;font-weight: 800;"><?= $result2[0][1] ?></h1>
            <p style="font-weight: 400;color: black;"><i class="bi bi-geo-alt-fill"></i><?= $result2[0][3] ?></p>
        </div>
    </section>
    <div class="search" id="search">
        <div class="search-form" method="get" action="">
            <input type="search" name="search" id="search-box" placeholder="Search...."
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="fas fa-search"></button>
        </div>
    </div>
    <div id="search-results">
        <?php if (!isset($_GET['search'])): ?>
            <section class="features" id="features">
                <hr>
                <h1 class="heading"> New <span>Products</span></h1>

                <div class="box-container">
                    <?php if (count($new) > 0): ?>
                        <?php for ($i = 0; $i < count($new); $i++): ?>
                            <?php $new_id[$i] = $new[$i][0]; ?>
                            <div class="box">
                                <img src="../img/<?= $shop_ID ?>/products/<?= $new[$i][4]; ?>" alt="">
                                <h3><?= $new[$i][1]; ?></h3>
                                <p>Price: P<?= $new[$i][2]; ?></p>
                                <a id="cartbtn" class="btn cartbtn" data-id="<?= $new[$i][0]; ?>">Add To Cart</a>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="products">
            <hr>
            <h1 class="heading"> our <span>products</span></h1>
            <div class="sort-container">
                <h1>SORT:</h1>
                <button class="sort-button <?= $database->namesort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?shop_ID=<?= $_GET['shop_ID'] ?>&sort=<?= $database->sort1 ? 'name-asc' : 'name-desc'; ?>'+searchQuery();">Name
                    <?= $database->sort1 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <button class="sort-button <?= $database->pricesort ? 'active-sort' : '' ?>" type="button"
                    onclick="window.location.href='?shop_ID=<?= $_GET['shop_ID'] ?>&sort=<?= $database->sort2 ? 'price-asc' : 'price-desc'; ?>'+searchQuery();">Price
                    <?= $database->sort2 ? '<i class="bi bi-arrow-up up"></i>' : '<i class="bi bi-arrow-down down"></i>' ?></button>
                <?php if (isset($_GET['sort']) && $_GET['sort'] != 'reset'): ?>
                    <button class="sort-button reset-sort" type="button" onclick="window.location.href='?shop_ID=<?= $_GET['shop_ID'] ?><?php if (isset($_GET['search']) && $_GET['search'] != null) {
                          echo '&search=' . $_GET['search'] ;
                      } ?>'">Reset</button>
                <?php endif; ?>
            </div>
            <div class="product-grid">
                <?php if (count($result) > 0): ?>
                    <?php for ($i = 0; $i < count($result); $i++): ?>
                        <?php $product_ID[$i] = $result[$i][0]; ?>
                        <div class="product">
                            <img src="../img/<?= $shop_ID ?>/products/<?= $result[$i][4]; ?>" alt="">
                            <h3><?= $result[$i][1]; ?></h3>
                            <p>Price: P<?= $result[$i][2]; ?></p>
                            <a id="cartbtn" class="btn cartbtn" data-id="<?= $result[$i][0]; ?>">Add to Cart</a>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_ID'])) if ($_SESSION['user_ID'] === $_GET['shop_ID']): ?>
                    <div class="product" name="add-product" onclick="showModal('add-product-form')">
                        <i class="bi bi-plus-square"></i>
                        <h3>Add Product</h3>
                    </div>
                    <div id="add-product-form" class="modal">
                        <div class="modal-content">
                            <div class="modal-top">
                                <h1 style="font-size: 2.5rem;">ADD PRODUCT</h1>
                                <div class="close" onclick="closeModal('add-product-form')">&times;</div>
                            </div>
                            <hr><br>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <label for="product_Name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="product_Name" name="product_Name"
                                        placeholder="Name">
                                </div>
                                <div class="form-row">
                                    <label for="product_Price" class="form-label">Price (₱)</label>
                                    <input type="number" step="0.01" class="form-control" id="product_Price"
                                        name="product_Price" placeholder="Name">
                                </div>
                                <div class="form-row">
                                    <label for="product_Description" class="form-label">Description</label>
                                    <textarea rows="3" class="form-control" id="product_Description"
                                        name="product_Description" placeholder="Name"></textarea>
                                </div>
                                <div class="form-row">
                                    <label for="product_Image" class="form-label">Product Image</label>
                                    <input type="file" class="form-control" id="product_Image" name="product_Image"
                                        placeholder="Name">
                                </div>
                                <div class="form-row hidden">
                                    <label for="shop_ID" class="form-label">SHOP ID</label>
                                    <input type="text" class="form-control" id="shop_ID" name="shop_ID"
                                        value="<?= $_SESSION['user_ID'] ?>">
                                </div>
                                <div class="product-image" id="productImage-container">
                                    <img src="" id="productImage" />
                                </div>
                                <div class="form-row-btn">
                                    <button type="button" class="form-btn cancel"
                                        onclick="closeModal('add-product-form');"><span class="btn-text">Cancel</span><i
                                            class="bi bi-x-lg btn-icon"></i></button>
                                    <button type="submit" name="create" class="form-btn create"><span class="btn-text">Add
                                            Product</span><i class="bi bi-check-lg btn-icon"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <ul class="pagination">
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
                                }
                                echo "&shop_ID=" . $shop_ID; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item"><a class="page-link <?= ($i === $page) ? "active" : "" ?>" href="?page=<?= $i ?><?php if (isset($_GET['search'])) {
                                      echo '&search=' . $searchq;
                                  }
                                  echo "&shop_ID=" . $shop_ID; ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= ($page + 1) ?><?php if (isset($_GET['search'])) {
                                    echo '&search=' . $searchq;
                                }
                                echo "&shop_ID=" . $shop_ID; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $totalPages ?><?php if (isset($_GET['search'])) {
                                  echo '&search=' . $searchq;
                              }
                              echo "&shop_ID=" . $shop_ID; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    </div>


    <section class="blogs" id="blogs">

        <h1 class="heading"> Check Us <span>Out!</span></h1>

        <div class="box-container">

            <div class="box">
                <img src="rawr.png" alt="">
            </div>

            <div class="box">
                <img src="rawr.png" alt="">
            </div>

            <div class="box">
                <img src="rawr.png" alt="">
            </div>
        </div>

    </section>
    <?php include '../includes/footer.Include.php' ?>
    <script src="../js/products.js"></script>
    <script>
        function handleSearchQuery() {
            const searchQuery = document.getElementById('search-box').value;
            const shopID = <?= $shop_ID ?>;
            const sortType = '<?= isset($_GET['sort']) ? $_GET['sort'] : 'reset' ?>';
            const page = <?= $page ? $page : NULL ?>;

            const search = new XMLHttpRequest();
            search.open('GET', `search.php?search=${searchQuery}&shop_ID=${shopID}<?= isset($_GET['sort']) ? '&sort=${sortType}' : '' ?><?= isset($_GET['page']) ? '&page=${page}' : '' ?>`, true);
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