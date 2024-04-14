<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
$_SESSION['site'] = 'Shops';
$shop_ID = $_GET['shop_ID'];

$conn = new Connection();
$database = new Database($conn->connect());

$result = $database->showRecords('shopproducts', "WHERE shop_ID LIKE '$shop_ID'");
$result2 = $database->showRecords('shopdata', "WHERE shop_ID LIKE '$shop_ID'");
if (isset($_GET['search'])) {
    if ($_GET['search'] == NULL)
        echo "<script>window.location.href='?'</script>";
    $searchq = $_GET['search'];
    $result = $database->showRecords('shopproducts', "WHERE shop_ID = '$shop_ID' AND product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%' LIMIT $offset, 15");
    $result2 = $database->showRecords('shopdata', "WHERE shop_ID LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' LIMIT 0,6");
    $totalPages = $database->pagination('product_ID', 15, 'shopproducts', "WHERE product_ID LIKE '%$searchq%' OR product_Name LIKE '%$searchq%'");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/head.Include.php'; ?>
    <title><?= $result[0][1] ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/index.css">

</head>

<body>
    <?php include '../includes/header.Include.php'; ?>
    <section class="home" id="home">

        <div class="content">
            <h3>NATO CLSU<span> Express</span> </h3>
            <p>Tara na at mag try sa NATO Express</p>
            <a href="#" class="btn">Shop now</a>
        </div>



    </section>

    <section class="features" id="features">

        <h1 class="heading"> Best <span>Sellers</span></h1>

        <div class="box-container">

            <div class="box">
                <img src="rawr.png" alt="">
                <h3>Carbonara</h3>
                <p>Yummy Pare</p>
                <a href="#" class="btn">Read More</a>
            </div>

            <div class="box">
                <img src="rawr.png" alt="">
                <h3>Free Delivery</h3>
                <p>Yummy Pare</p>
                <a href="#" class="btn">Read More</a>
            </div>

            <div class="box">
                <img src="rawr.png" alt="">
                <h3>Easy Payment</h3>
                <p>Yummy Pare</p>
                <a href="#" class="btn">Read More</a>
            </div>

        </div>

    </section>



    <section class="products" id="placeholder">

        <h1 class="heading"> our <span>products</span></h1>

        <div class="swiper product-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>1Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>2Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>3Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>4Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>
        </div>




        <div class="swiper product-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>5Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>6Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>7Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>

                <div class="swiper-slide box">
                    <img src="rawr.png" alt="">
                    <h3>8Fresh Pare</h3>
                    <div class="price">50PHP</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="#" class="btn">add to cart</a>
                </div>
            </div>
        </div>

    </section>


    <section class="review" id="review">

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
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>