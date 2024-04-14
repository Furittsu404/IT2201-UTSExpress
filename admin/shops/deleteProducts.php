<?php
session_start();
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}
$connection = new Connection();
$database = new adminAction($connection->connect());

if (isset($_GET['product_ID'])) {
    $product_ID = $_GET['product_ID'];
    $result = $database->showRecords('shopproducts', "WHERE product_ID = $product_ID");
    $shop_ID = $result[0][5];
    $result2 = $database->showRecords('shopdata', "WHERE shop_ID = $shop_ID");
    if (!$result) {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}

if (isset($_POST['delete'])) {
    unlink("../../img/$shop_ID/products/$product_ID.png");
    $action = $database->deleteRecord('shopproducts', ['product_ID' => $product_ID]);
    echo "<script>alert('Deleted Product successfully.'); window.location.href='products.php?page=' + " . $_SESSION['page'] . "</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Delete Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/admin.usersedit.css">
    <link rel="stylesheet" href="../../css/admin.editproducts.css">
    <style>
        .form-control {
            border: 1;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include "../../includes/ADMIN.sidebar.Include.php"; ?>
        <div class="main p-3 d-flex flex-column align-content-center">

        <form class="container" method="post" enctype="multipart/form-data">
                <h1 class="display-5 ">Edit Product</h1> <br>
                <div class="productForm-container">
                    <div class="col-6 column-img">
                        <div class="shop-image" name="current_Image"><img
                                src='../../img/<?= $shop_ID ?>/products/<?= $result[0][4] ?>' id="productImage"></div>
                    </div>
                    <div class="col-6 column">
                        <div class="form-group row">
                            <label for="product_Name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="product_Name" name="product_Name"
                                    placeholder="Name" value="<?php echo isset($result[0][1]) ? $result[0][1] : '' ?>"
                                    readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="product_Price" class="col-sm-2 col-form-label">Price (₱)</label>
                            <div class="col-sm-10">
                                <input type="Number" class="form-control" id="product_Price" name="product_Price"
                                    placeholder="Price (₱)" step="0.01"
                                    value="<?php echo isset($result[0][2]) ? $result[0][2] : '' ?>" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="product_Description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="product_Description" name="product_Description"
                                    rows="3" readonly><?= $result[0][3] ?></textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="form-group row">
                            <label for="shop_Name" class="col-sm-2 col-form-label">Owner</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="shop_Name" name="shop_Name"
                                    placeholder="Name" value="<?php echo isset($result2[0][1]) ? $result2[0][1] : '' ?>"
                                    readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row justify-content-end gap-3">
                            <button type="button" class="btn btn-secondary w-25"
                                onclick="window.location.href = 'products.php?page=<?php echo $_SESSION['page']; ?>'"><span
                                    class="btn-text">Cancel</span><i class="bi bi-backspace btn-icon"></i></button>
                            <button type="submit" name="delete" class="btn btn-danger w-25"><span class="btn-text">Delete
                                    Product</span><i class='bi bi-trash btn-icon'></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>