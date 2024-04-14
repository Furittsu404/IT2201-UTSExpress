<?php
session_start();
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}
$connection = new Connection();
$database = new adminAction($connection->connect());

if (isset($_GET['user_ID'])) {
    $user_id = $_GET['user_ID'];
    $result = $database->showRecords('userdata', "WHERE user_ID = $user_id");
    $result2 = $database->showRecords('userlogin', "WHERE user_ID = $user_id");
    if (!$result) {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}

if (isset($_POST['delete'])) {
    $action = $database->deleteRecord('userlogin', ['user_ID' => $user_id]);
    $action2 = $database->deleteRecord('userdata', ['user_ID' => $user_id]);
    echo "<script>alert('Deleted User data successfully.'); window.location.href='../users/?page=' + " . $_SESSION['page'] . "</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Delete User</title>
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
                <h1 class="display-5 ">Delete User?</h1> <br>
                <div class="form-group row">
                    <label for="user_Name" class="col-sm-2 col-form-label fw-bold">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="user_Name" name="user_Name" placeholder="Name"
                            value="<?php echo isset($result[0][2]) ? $result[0][2] : '' ?>" readonly>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="user_Nickname" class="col-sm-2 col-form-label fw-bold">Nickname</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="user_Nickname" name="user_Nickname"
                            placeholder="Nickname" value="<?php echo isset($result[0][1]) ? $result[0][1] : '' ?>"
                            readonly>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="user_Email" class="col-sm-2 col-form-label fw-bold">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="user_Email" name="user_Email" placeholder="Email"
                            value="<?php echo isset($result2[0][1]) ? $result2[0][1] : '' ?>" readonly>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="user_Phone" class="col-sm-2 col-form-label fw-bold">Phone</label>
                    <div class="col-sm-10">
                        <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control"
                            id="user_Phone" name="user_Phone" placeholder="10-Digits Phone Number (Optional)"
                            value="<?php echo isset($result[0][3]) ? $result[0][3] : '' ?>" readonly>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="user_Location" class="col-sm-2 col-form-label fw-bold">Location</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="user_Location" name="user_Location"
                            placeholder="Location (Optional)"
                            value="<?php echo isset($result[0][4]) ? $result[0][4] : '' ?>" readonly>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-secondary w-25"
                        onclick="window.location.href='../users'"><span class="btn-text">Cancel</span>
                        <i class="bi bi-backspace btn-icon"></i></button>
                    <button type="submit" name="delete" class="btn btn-danger w-25"><span class="btn-text">Delete
                            User</span><i class='bi bi-trash btn-icon'></i></button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>