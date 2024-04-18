<?php
session_start();
include '../db/connection.php';
include '../db/cartAction.php';
include '../db/action.php';

$conn = new Connection();
$database = new Database($conn->connect());
$cart = new cart($conn->connect());

?>

<div class="total">total : <?= sizeof($_SESSION['cart']) ?></div>
<div class="total" style="padding: 0;font-size: 2rem;">Cost : P<?= $cart->getTotal() ?></div>
<?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
    <?php $itemData = $database->showRecords('shopproducts', "WHERE product_ID = '$id'"); ?>
    <div class="box">
        <i class="fas fa-trash trash-btn" data-id="<?= $id ?>"></i>
        <div class="cart-img-container">
            <img src="img/<?=$itemData[0][5]?>/products/<?= $id ?>.png" alt="" />
        </div>
        <div class="content">
            <h3><?= $itemData[0][1] ?></h3>
            <span class="price">P<?= $itemData[0][2] ?></span>
            <span class="quantity">qty : <?= $quantity ?></span>
        </div>
    </div>
<?php endforeach; ?>


<script>
    $(document).ready(function () {
            $('.trash-btn').on('click', function (e) {
                e.preventDefault();
                let productId = $(this).data('id');
                $.ajax({
                    url: 'includes/addToCart.php',
                    type: 'POST',
                    data: { id: productId, delete: true },
                    success: function (response) {
                        $('#cart-icon').text(response);
                    }
                });
                $.ajax({
                    url: 'includes/INDEX.cartUpdate.php',
                    type: 'POST',
                    data: { id: productId, delete: true},
                    success: function (response) {
                        $('#cart-content').html(response);
                    }
                });
            });
        });
</script>