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
    $product_id = $_GET['product_ID'];
    $result = $database->showRecords('shopproducts', "WHERE product_ID = $product_id");
    $shop_id = $result[0][5];
    if (!$result) {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}

if (isset($_POST['delete'])) {
    unlink("../../img/$shop_id/products/$product_id.png");
    $action = $database->deleteRecord('shopproducts', ['product_ID' => $product_id]);
    echo "<script>alert('Deleted product successfully.'); window.location.href='products.php?page=' + " . $_SESSION['page'] . "</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Delete product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/admin.usersedit.css">
</head>

<body>
    <div class="wrapper">
        <?php include "../../includes/ADMIN.sidebar.Include.php"; ?>
        <div class="main p-3 d-flex flex-column align-content-center">

            <form class="container" method="post">
                <h1 class="display-5 ">Delete product?</h1> <br>
                <div class="form-group row">
                    <label for="product_Name" class="col-sm-2 col-form-label fw-bold">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_Name" name="product_Name" placeholder="Name"
                            value="<?php echo isset($result[0][1]) ? $result[0][1] : '' ?>" readonly>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="product_Price" class="col-sm-2 col-form-label fw-bold">Phone</label>
                    <div class="col-sm-10">
                        <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control"
                            id="product_Price" name="product_Price" placeholder="Price"
                            value="<?php echo isset($result[0][2]) ? $result[0][2] : '' ?>" readonly>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="product_Description" class="col-sm-2 col-form-label fw-bold">Location</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="product_Description" name="product_Description"
                            value="" readonly><?php echo isset($result[0][3]) ? $result[0][3] : '' ?></textarea>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="product_Image" class="col-sm-2 col-form-label fw-bold">Image</label>
                    <div class="col-sm-10 w-50">
                        <img src="../../img/<?php echo $shop_id; ?>/products/<?php echo $product_id; ?>.png"
                            class="img-thumbnail" alt="Product image">
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-secondary w-25"
                        onclick="window.location.href = 'products.php?page=<?php echo $_SESSION['page']; ?>'"><span class="btn-text">Cancel</span>
                        <i class="bi bi-backspace btn-icon"></i></button>
                    <button type="submit" name="delete" class="btn btn-danger w-25"><span class="btn-text">Delete
                            product</span><i class='bi bi-trash btn-icon'></i></button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>