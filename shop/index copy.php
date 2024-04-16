<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
$_SESSION['site'] = 'Shops';
$shopPage = true;
$shop_ID = $_GET['shop_ID'];


$conn = new Connection();
$database = new Database($conn->connect());

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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.Include.php'; ?>
    <title><?= $result2[0][1] ?></title>
    <link rel="stylesheet" href="shopPage.css">

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
        <form class="search-form" method="get" action="">
            <input type="hidden" name="shop_ID" value="<?= $_GET['shop_ID'] ?>">
            <input type="search" name="search" id="search-box" placeholder="Search...."
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" required>
            <button type="submit" class="fas fa-search"></button>
        </form>
        <?php if (isset($_GET['search'])): ?>
            <button class="sort-button reset-sort" type="button"
                onclick="window.location.href='?shop_ID=<?= $shop_ID ?>'">Cancel</button>
        <?php endif; ?>
    </div>

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
                        <a href="#" class="btn">Read More</a>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>

        </div>
    </section>


    <section class="products" id="placeholder">
        <hr>
        <h1 class="heading"> our <span>products</span></h1>

        <div class="product-grid">
            <?php if (count($result) > 0): ?>
                <?php for ($i = 0; $i < count($result); $i++): ?>
                    <?php $product_ID[$i] = $result[$i][0]; ?>
                    <div class="product">
                        <img src="../img/<?= $shop_ID ?>/products/<?= $result[$i][4]; ?>" alt="">
                        <h3><?= $result[$i][1]; ?></h3>
                        <p>Price: P<?= $result[$i][2]; ?></p>
                        <a href="#" class="btn">Read More</a>
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


    <section class="review" id="review">
        <hr>
        <h1 class="heading"> Customer <span>review</span></h1>

        <div class="swiper review-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <p>Grabe for the yummy ang ulam sheeesh brow</p>
                    <h3>Peper Dion</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <p>Grabe for the yummy ang ulam sheeesh brow</p>
                    <h3>Peper Dion</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <p>Grabe for the yummy ang ulam sheeesh brow</p>
                    <h3>Peper Dion</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <p>Grabe for the yummy ang ulam sheeesh brow</p>
                    <h3>Peper Dion</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

            </div>

        </div>

    </section>



    <section class="blogs" id="blogs">

        <h1 class="heading"> our <span>blogs</span></h1>

        <div class="box-container">

            <div class="box">
                <img src="rawr.png" alt="">
                <div class="content">
                    <div class="icons">
                        <a href="#"> <i class="fas fa-user"></i> by user </a>
                        <a href="#"> <i class="fas fa-calendar"></i> 00/00/00 </a>
                    </div>
                    <h3>Sheeeehhh</h3>
                    <p>Sheessssshhhhhhh</p>
                    <a href="#" class="btn">read more</a>
                </div>
            </div>

            <div class="box">
                <img src="rawr.png" alt="">
                <div class="content">
                    <div class="icons">
                        <a href="#"> <i class="fas fa-user"></i> by user </a>
                        <a href="#"> <i class="fas fa-calendar"></i> 00/00/00 </a>
                    </div>
                    <h3>Sheeeehhh</h3>
                    <p>Sheessssshhhhhhh</p>
                    <a href="#" class="btn">read more</a>
                </div>
            </div>

            <div class="box">
                <img src="rawr.png" alt="">
                <div class="content">
                    <div class="icons">
                        <a href="#"> <i class="fas fa-user"></i> by user </a>
                        <a href="#"> <i class="fas fa-calendar"></i> 00/00/00 </a>
                    </div>
                    <h3>Sheeeehhh</h3>
                    <p>Sheessssshhhhhhh</p>
                    <a href="#" class="btn">read more</a>
                </div>
            </div>
        </div>

    </section>

    <?php include '../includes/footer.Include.php' ?>
    <script src="../js/index.js"></script>
</body>

</html>