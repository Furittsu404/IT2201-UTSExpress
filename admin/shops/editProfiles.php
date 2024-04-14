<?php
session_start();
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}
$connection = new Connection();
$database = new adminAction($connection->connect());

if (isset($_GET['shop_ID'])) {
    $shop_id = $_GET['shop_ID'];
    $result = $database->showRecords('shopdata', "WHERE shop_ID = $shop_id");
    $result2 = $database->showRecords('shoplogin', "WHERE shop_ID = $shop_id");
    if (!$result) {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}

if (isset($_POST['edit'])) {
    if (!$_FILES['shop_Image']['error'])
        $database->validateFile($_FILES, key($_FILES));
    $shoplogin = [];
    $shopdata = [];
    foreach ($_POST as $name => $val) {
        if ($_POST['shop_Password'] != NULL && $name == 'shop_Password')
            $shoplogin[$name] = password_hash($val, PASSWORD_BCRYPT);
        else if ($name == 'shop_Email')
            $shoplogin[$name] = $val;
        else if ($name != 'edit' && $name != 'shop_Password')
            $shopdata[$name] = $val;
    }
    $show = $database->showRecords('shoplogin', "WHERE shop_ID='$shop_id'");
    if ($show[0][1] == $_POST['shop_Email'] && $show[0][0] != $shop_id) {
        echo "<script>alert('Email already exists!')</script>";
    } else {
        try {
            if (!$_FILES['shop_Image']['error'])
                $database->moveFile($shop_id, 'shop_Image', $_FILES, '../../img');
            $action = $database->updateRecord($shoplogin, 'shoplogin', ['shop_ID' => $shop_id]);
            $action2 = $database->updateRecord($shopdata, 'shopdata', ['shop_ID' => $shop_id]);
            echo "<script>alert('Shop Updated Successfully.')</script>";
            echo '<script>window.location.href="profiles.php?page=" + ' . $_SESSION['page'] . ';</script>';
        } catch (Exception $e) {
            echo "Error: $e";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Edit Shop</title>
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

            <form class="container" method="post" enctype="multipart/form-data">
                <h1 class="display-5 ">Edit Shop</h1> <br>
                <div class="form-group row">
                    <label for="shop_Name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" oninput="validSymbol(this.id);" class="form-control" id="shop_Name" name="shop_Name" placeholder="Name"
                            value="<?php echo isset($result[0][1]) ? $result[0][1] : '' ?>" required>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="shop_Email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" oninput="validSymbol(this.id);" class="form-control" id="shop_Email" name="shop_Email" placeholder="Email"
                            value="<?php echo isset($result2[0][1]) ? $result2[0][1] : '' ?>" required>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="shop_Password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" oninput="validSymbol(this.id);" class="form-control" id="shop_Password" name="shop_Password"
                            placeholder="Password (Optional)">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="shop_Phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control"
                            id="shop_Phone" name="shop_Phone" placeholder="10-Digits Phone Number (Optional)"
                            value="<?php echo isset($result[0][2]) ? $result[0][2] : '' ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="shop_Location" class="col-sm-2 col-form-label">Location</label>
                    <div class="col-sm-10">
                        <input type="text" oninput="validSymbol(this.id);" class="form-control" id="shop_Location" name="shop_Location"
                            placeholder="Location (Optional)"
                            value="<?php echo isset($result[0][3]) ? $result[0][3] : '' ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="shop_Image" class="col-sm-2 col-form-label">Shop Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="shop_Image" name="shop_Image">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="current_Image" class="col-sm-2 col-form-label">Current Image</label>
                    <div class="col-sm-10">
                        <div class="shop-image" name="current_Image"><img
                                src='../../img/<?php echo $shop_id; ?>/shop_Image.png' id="shopImage"></div>
                    </div>
                </div>
                <br>
                <div class="form-group row justify-content-end gap-3">
                    <button type="button" class="btn btn-secondary w-25"
                        onclick="window.location.href = 'profiles.php?page=<?php echo $_SESSION['page']; ?>'"><span
                            class="btn-text">Cancel</span><i class="bi bi-x-lg btn-icon"></i></button>
                    <button type="submit" name="edit" class="btn btn-success w-25"><span class="btn-text">Edit
                            shop</span><i class="bi bi-check-lg btn-icon"></i></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#shop_Image').change(function () {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $('#shopImage').attr('src', event.target.result);
                        $('#shopImage').hide();
                        $('#shopImage').fadeIn(1000);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>

</html>