<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
include '../db/cartAction.php';
$_SESSION['site'] = 'Profile';

$conn = new Connection();
$database = new Database($conn->connect());
$cart = new cart($conn->connect());
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (sizeof($_SESSION['cart']) == 0) {
    echo "<script>window.location.href='../products'</script>";
}
if (isset($_SESSION['user_ID'])) {
    $user_id = $_SESSION['user_ID'];
    $userdata =$database->showRecords('userdata',"WHERE user_ID = $user_id");
}

$total = 0;
$shopNames = [];
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../includes/head.Include.php' ?>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/checkout.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Shopping Cart</h1>
        </div>
        <div class="shop-info">
            <img src="rea.png" alt="Shop Logo" class="shop-logo">
            <h3 class="shop-name">Charkings</h3>
        </div>
        <div class="cart">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
                        <?php $itemData = $database->showRecords('shopproducts', "WHERE product_ID = '$id'"); ?>
                        <?php $product[$itemData[0][1]] = $quantity; ?>
                        <tr>
                            <td>
                                <div class="product-img">
                                    <div class="img-prdct">
                                        <img src="../img/<?= $itemData[0][5] ?>/products/<?= $itemData[0][4] ?>">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p id="product-name"><?= $itemData[0][1] ?></p>
                            </td>
                            <td>
                                <div class="button-container">

                                    <input type="number" name="qty" id="qty<?= $id ?>"
                                        oninput="numberOnly(this.id);updateTotal(<?= $id ?>)" min="1" max="99" step="1"
                                        class="qty from-control" value="<?= $quantity ?>" />

                                </div>
                            </td>
                            <td>
                                <p>PHP <span id="price<?= $id ?>"><?= $itemData[0][2] ?></span></p>
                            </td>
                            <td>
                                <div class="price">PHP<input type="number" id="amount<?= $id ?>" class="amount form-control"
                                        value="<?= $itemData[0][2] * $quantity ?>" disabled></div>
                            </td>
                        </tr>
                        <tr>
                            <?php $shop_ID = $itemData[0][5]; ?>
                            <?php $shopData = $database->showRecords('shopdata', "WHERE shop_ID = '$shop_ID'"); ?>
                            <?php if (!in_array($shopData[0][1], $shopNames)) {
                                $shopNames[] = $shopData[0][1];
                            } ?>
                            <td class="shop-label">
                                <p><b>Shop:</b></p>
                                <p><b>Location:</b></p>

                            </td>
                            <td class="shop-details" colspan="4">
                                <p><?= $shopData[0][1] ?></p>
                                <p><?= $shopData[0][3] ?></p>
                            </td>
                        </tr>
                        <?php $total += $quantity * $itemData[0][2] ?>
                    <?php endforeach; ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td><strong>Total: PHP <span id="total"><?= $total ?></span></strong></td>
                    </tr>
                </tfoot>
            </table>


            <div id="checkout-form">
                <div class="checkout">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" oninput="letterOnly(this.id)" id="name" value="<?=isset($userdata) ? $userdata[0][1] : ''?>" placeholder="Enter your Full Name">
                    </div>
                    <div class="form-group">
                        <label for="address">Location</label>
                        <input type="text" class="form-control" oninput="validSymbol(this.id)" id="address" value="<?=isset($userdata) ? $userdata[0][4] : ''?>" placeholder="Enter your CLSU Location">
                    </div>
                    <div class="form-group">
                        <label for="cp">Phone Number</label>
                        <input type="text" class="form-control" oninput="numberOnly(this.id)" id="cp" value="<?=isset($userdata) ? $userdata[0][3] : ''?>" placeholder="Enter your number">
                    </div>

                    <div class="order-details">
                        <h2>Order Details</h2>
                        <div class="order-summary">
                            <?php foreach ($product as $key => $value): ?>
                                <p><?= $key ?> x <span class="quantity"><?= $value ?></span></p>
                            <?php endforeach; ?>
                        </div>
                        <p>Total: PHP <span id="order-total"><?= $total ?></span></p>
                    </div>

                    <label for="payment">Payment Method:</label>
                    <select id="payment" name="payment">
                        <option value="cod">Cash on Delivery (COD)</option>
                        <option value="gcash">Gcash</option>
                    </select><br><br>
                </div>
                <div class="checkout-buttons">
                    <button onclick="window.location.href='../'" class="btn btn-outline-secondary btn-icon">Back</button>
                    <button onclick="checkout()" class="btn btn-success btn-icon">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.Include.php'; ?>
    <script src="../js/checkout.js"></script>
    <script>
        function updateTotal(var_id) {
            var total = 0;
            var qty = document.getElementById('qty' + var_id).value;
            var price = document.getElementById('price' + var_id).innerHTML;
            var amount = qty * price;
            document.getElementById('amount' + var_id).value = amount;
            var total = 0;
            var amounts = document.getElementsByClassName('amount');
            for (var i = 0; i < amounts.length; i++) {
                total += parseInt(amounts[i].value);
            }
            document.getElementById('total').innerHTML = total;
            document.getElementById('order-total').innerHTML = total;
        }

        function checkout() {
            var address = document.getElementById('address').value;
            var cp = document.getElementById('cp').value;
            var payment = document.getElementById('payment').value;
            var total = document.getElementById('total').innerHTML;
            var products = <?php echo json_encode($product); ?>;
            var shopname = <?php echo json_encode($shopNames); ?>;
            var data = {
                address: address,
                cp: cp,
                payment: payment,
                total: total,
                products: products,
                shopname: shopname
            };
            $.ajax({
                url: '../db/checkout.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    alert(response);
                    window.location.href = '../';
                }
            });
        }
    </script>
</body>

</html>