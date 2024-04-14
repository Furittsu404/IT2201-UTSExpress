<header class="header" id="header">
    <a href=""><img src="img/UTS-Express.png" class="logo" /></a>

    <nav class="navbar">
        <a href="">Home</a>
        <a href="products">Products</a>
        <a href="shops">Shops</a>
        <a href="about">About Us</a>
        <a href="faq">FAQ</a>
    </nav>

    <div class="icons" id="nav">
        <div class="fas fa-bars" id="menu-btn"></div>
        <div class="fas fa-search" id="search-btn"></div>
        <div class="fas fa-shopping-cart" id="cart-btn"></div>
        <?php
        if (isset($_SESSION['user_ID'])) {
            echo '<div class="fas fa-user" id="user-btn"></div>';
        } else {
            echo '<div class="fas fa-user" id="user-btn" style="display: none;"></div>';
        }
        ?>
    </div>

    <div class="shopping-cart" id="cart">
        <div class="box">
            <i class="fas fa-trash"></i>
            <img src="img/carbo.png" alt="" />
            <div class="content">
                <h3>Carbo Pare</h3>
                <span class="price">40PHP</span>
                <span class="quantity">qty : 1</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-trash"></i>
            <img src="img/carbo.png" alt="" />
            <div class="content">
                <h3>Carbo Pare</h3>
                <span class="price">40PHP</span>
                <span class="quantity">qty : 1</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-trash"></i>
            <img src="img/carbo.png" alt="" />
            <div class="content">
                <h3>Carbo Pare</h3>
                <span class="price">40PHP</span>
                <span class="quantity">qty : 1</span>
            </div>
        </div>
        <div class="total">total : 1000</div>
        <a href="#" class="btn" style="color: black">checkout</a>
    </div>

</header>
<div class="search-bar" id="search">
    <form action="" class="search-form">
        <input type="search" id="search-box" placeholder="Search....." />
        <label for="search-box" class="fas fa-search"></label>
    </form>
</div>
<nav class="user-window">
    <?php if ($_SESSION['admin'] == true): ?>
        <a href="admin">Admin Dashboard</a>
    <?php endif; ?>
    <a href="">Profile</a>
    <a href="db/logout.php">Logout</a>
</nav>