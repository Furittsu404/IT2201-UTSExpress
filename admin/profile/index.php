<?php
session_start();
$_SESSION['site'] = 'adminAccount';
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}

$id = $_SESSION['user_ID'];
$connection = new Connection();
$database = new adminAction($connection->connect());

if (isset($_POST['edit'])) {
    $admin = [];
    foreach ($_POST as $name => $val) {
        if ($name == 'admin_Password' && $val != NULL)
            $admin[$name] = password_hash($val, PASSWORD_BCRYPT);
        else if ($name != 'edit' && $name != 'admin_Password')
            $admin[$name] = $val;
    }
    $show = $database->showRecords('adminlogin', "WHERE admin_ID = $id");
    if ($show && $show[0][0] != $id) {
        echo "<script>alert('Email already exists!')</script>";
    } else {
        try {
            $action = $database->updateRecord($admin, 'adminlogin', ['admin_ID' => $id]);
            echo "<script>alert('Admin Updated Successfully.')</script>";
            echo '<script>window.location.href="../";</script>';
        } catch (Exception $e) {
            echo "Error: $e";
        }
    }
}

$data = $database->showRecords('adminlogin', "WHERE admin_ID = $id");
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/admin.userstable.css">
</head>

<body>
    <div class="wrapper">
        <?php include "../../includes/ADMIN.sidebar.Include.php"; ?>
        <div class="main p-3 d-flex flex-column align-content-center">
            <div class="container p-3">
                <div class="row">
                    <h1 class="modal-title fs-5" id="createModalLabel">Acount Settings</h1>
                </div>
                <hr>
                <br>
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="admin_Name" class="col-form-label">Name</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" oninput="validSymbol(this.id);" class="form-control" id="admin_Name"
                                name="admin_Name" value="<?=$data[0][1]?>" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="admin_Email" class="col-form-label">Email</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="email" oninput="validSymbol(this.id);" class="form-control" id="admin_Email"
                                name="admin_Email" value="<?=$data[0][2]?>" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="admin_Password" class="col-form-label">Password</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" oninput="validSymbol(this.id);" class="form-control" minlength="8"
                                id="admin_Password" name="admin_Password" placeholder="Password">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-secondary w-25" onclick="window.location.href='../'">Back</button>
                            <button type="submit" name="edit" class="btn btn-success w-25">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/admin.js"></script>
</body>

</html>