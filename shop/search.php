<?php
session_start();
include '../db/actionSort.php';
include '../db/connection.php';
$_SESSION['site'] = 'Shops';
$shopPage = true;
$shop_ID = $_GET['shop_ID'];

$conn = new Connection();
$database = new Sort($conn->connect());

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

$database->sort1 = 1;
$database->sort2 = 2;
if (isset($_GET['sort'])) {
    $result = $database->sort('shopPage', $offset, 9, $_GET['sort'], $searchq ?? NULL, $_GET['shop_ID']);
} else {
    $database->namesort = 0;
    $database->pricesort = 0;
}
?>

<?php if (isset($_GET['search'])) if ($_GET['search'] == ''): ?>
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
                            <a id="cartbtn" class="btn cartbtn" data-id="<?= $new[$i][0]; ?>">Add to Cart</a>
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
                  echo '&search=' . $_GET['search'];
              } ?>'">Reset</button>
        <?php endif; ?>
    </div>
    <div class="product-grid">
        <?php if (count($result) > 0): ?>
            <?php for ($i = 0; $i < count($result); $i++): ?>
                <?php $product_ID[$i] = $result[$i][0]; ?>
                <div class="product">
                    <img src="../img/<?= $shop_ID ?>/products/<?= $result[$i][4]; ?>" alt="" onclick="<?php if (isset($_SESSION['user_ID'])) if ($_SESSION['user_ID'] === $_GET['shop_ID'])
                            echo "showModal('edit-product$i')"; ?>">
                    <h3 onclick="<?php if (isset($_SESSION['user_ID'])) if ($_SESSION['user_ID'] === $_GET['shop_ID'])
                        echo "showModal('edit-product$i')"; ?>"><?= $result[$i][1]; ?></h3>
                    <p>Price: P<?= $result[$i][2]; ?></p>
                    <a id="cartbtn" class="btn cartbtn" data-id="<?= $result[$i][0]; ?>">Add to Cart</a>
                </div>
                <?php if (isset($_SESSION['user_ID'])) if ($_SESSION['user_ID'] === $_GET['shop_ID']): ?>
                        <div id="edit-product<?= $i ?>" class="modal">
                            <div class="modal-content">
                                <div class="modal-top">
                                    <h1 style="font-size: 2.5rem;">ADD PRODUCT</h1>
                                    <div class="close" onclick="closeModal('edit-product<?= $i ?>')">&times;</div>
                                </div>
                                <hr><br>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <label for="product_Name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="product_Name" name="product_Name"
                                            value="<?= $result[$i][1] ?>">
                                    </div>
                                    <div class="form-row">
                                        <label for="product_Price" class="form-label">Price (₱)</label>
                                        <input type="number" step="0.01" class="form-control" id="product_Price" name="product_Price"
                                            value="<?= $result[$i][2] ?>">
                                    </div>
                                    <div class="form-row">
                                        <label for="product_Description" class="form-label">Description</label>
                                        <textarea rows="3" class="form-control" id="product_Description"
                                            name="product_Description"><?= $result[$i][3] ?></textarea>
                                    </div>
                                    <div class="form-row">
                                        <label for="product_Image" class="form-label">Product Image</label>
                                        <input type="file" class="form-control editimg" id="product_Image" name="product_Image"
                                            placeholder="Name">
                                    </div>
                                    <div class="form-row hidden">
                                        <label for="shop_ID" class="form-label">SHOP ID</label>
                                        <input type="text" class="form-control" id="shop_ID" name="shop_ID"
                                            value="<?= $_SESSION['user_ID'] ?>">
                                    </div>
                                    <div class="form-row hidden">
                                        <label for="product_ID" class="form-label">PRODUCT ID</label>
                                        <input type="text" class="form-control" id="product_ID" name="product_ID"
                                            value="<?= $result[$i][0] ?>">
                                    </div>
                                    <div class="product-image editimg-container" id="productImage-container">
                                        <img src="" id="productImage" class="editedimg" />
                                    </div>
                                    <div class="form-row-btn">
                                        <button type="button" class="form-btn cancel"
                                            onclick="closeModal('edit-product<?= $i ?>');"><span class="btn-text">Cancel</span><i
                                                class="bi bi-x-lg btn-icon"></i></button>
                                        <button type="submit" onclick="showModal('editSuccess')" name="edit"
                                            class="form-btn create"><span class="btn-text">Edit
                                                Product</span><i class="bi bi-check-lg btn-icon"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php endif; ?>
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
                                <input type="number" step="0.01" class="form-control" id="product_Price" name="product_Price"
                                    placeholder="Name">
                            </div>
                            <div class="form-row">
                                <label for="product_Description" class="form-label">Description</label>
                                <textarea rows="3" class="form-control" id="product_Description" name="product_Description"
                                    placeholder="Name"></textarea>
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
                                <button type="button" class="form-btn cancel" onclick="closeModal('add-product-form');"><span
                                        class="btn-text">Cancel</span><i class="bi bi-x-lg btn-icon"></i></button>
                                <button type="submit" name="create" class="form-btn create"><span class="btn-text">Add
                                        Product</span><i class="bi bi-check-lg btn-icon"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php if ($postEdit): ?>
                    <div id="editSuccess" class="modal-postEdit">
                        <div class="modal-content" style="width: 300px;">
                            <div>
                                <div class="close" onclick="closeModal('editSuccess')">&times;</div>
                                <h1>Product Added!</h1>
                            </div>
                            <hr><br>
                            <h1 style="text-align:center;font-size: 8rem;color: green;"><i class="bi bi-check-circle"></i>
                            </h1>
                            <h1 style="font-weight: 400;text-align: center;">Product Edited Successfuly.</h1>
                        </div>
                    </div>
            <?php endif; ?>
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
                url: '../includes/cartUpdate.php',
                type: 'POST',
                data: { id: productId },
                success: function (response) {
                    $('#cart-content').html(response);
                }
            });
            showModal('addCartModal');
        });
    });
</script>