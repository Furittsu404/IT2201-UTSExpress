<?php
session_start();
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}
$connection = new Connection();
$database = new adminAction($connection->connect());

if (isset($_GET['driver_ID'])) {
    $driver_id = $_GET['driver_ID'];
    $result = $database->showRecords('driverdata', "WHERE driver_ID = $driver_id");
    $result2 = $database->showRecords('driverlogin', "WHERE driver_ID = $driver_id");
    if (!$result) {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}

if (isset($_POST['edit'])) {
    $driverlogin = [];
    $driverdata = [];
    foreach ($_POST as $name => $val) {
        if ($_POST['driver_Password'] != NULL && $name == 'driver_Password')
            $driverlogin[$name] = password_hash($val,PASSWORD_BCRYPT);
        else if ($name == 'driver_Email')
            $driverlogin[$name] = $val;
        else if ($name != 'edit' && $name != 'driver_Password')
            $driverdata[$name] = $val;
    }
    $show = $database->showRecords('driverlogin', "WHERE driver_ID='$driver_id'");
    if ($show[0][1] == $_POST['driver_Email'] && $show[0][0] != $driver_id) {
        echo "<script>alert('Email already exists!')</script>";
    } else {
        try {
            $action = $database->updateRecord($driverlogin, 'driverlogin', ['driver_ID' => $driver_id]);
            $result = $database->showRecords('driverdata', "WHERE driver_ID = $driver_id");
            $result2 = $database->showRecords('driverlogin', "WHERE driver_ID = $driver_id");
            $action2 = $database->updateRecord($driverdata, 'driverdata', ['driver_ID' => $driver_id]);
            echo "<script>alert('User Updated Successfully.')</script>";
            echo '<script>window.location.href="../?page=" + ' . $_SESSION['page'] . ';</script>';
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
    <title>Edit Driver</title>
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

            <form class="container" method="post">
                <h1 class="display-5 ">Edit Driver</h1> <br>
                <div class="form-group row">
                    <label for="driver_Name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="driver_Name" name="driver_Name" placeholder="Name"
                            value="<?php echo isset($result[0][2]) ? $result[0][2] : '' ?>" required>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="driver_Nickname" class="col-sm-2 col-form-label">Nickname</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="driver_Nickname" name="driver_Nickname"
                            placeholder="Nickname" value="<?php echo isset($result[0][1]) ? $result[0][1] : '' ?>"
                            required>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="driver_Email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="driver_Email" name="driver_Email" placeholder="Email"
                            value="<?php echo isset($result2[0][1]) ? $result2[0][1] : '' ?>" required>
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="driver_Password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="driver_Password" name="driver_Password"
                            placeholder="Password (Optional)">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="driver_Phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control"
                            id="driver_Phone" name="driver_Phone" placeholder="10-Digits Phone Number (Optional)"
                            value="<?php echo isset($result[0][3]) ? $result[0][3] : '' ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="driver_Location" class="col-sm-2 col-form-label">Location</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="driver_Location" name="driver_Location"
                            placeholder="Location (Optional)"
                            value="<?php echo isset($result[0][4]) ? $result[0][4] : '' ?>">
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-secondary w-25"
                        onclick="window.location.href = 'profiles.php?page=<?php echo $_SESSION['page']; ?>'"><span class="btn-text">Cancel</span><i
                            class="bi bi-x-lg btn-icon"></i></button>
                    <button type="submit" name="edit" class="btn btn-success w-25"><span class="btn-text">Edit
                            User</span><i class="bi bi-check-lg btn-icon"></i></button>
                </div>
            </form>
        </div>
    </div>
</body> 

</html>