<?php
session_start();
$_SESSION['site'] = 'shopProfiles';
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}

$connection = new Connection();
$database = new adminAction($connection->connect());

if (isset($_POST['create'])) {
    $database->validateFile($_FILES);
    $password = $_POST['shop_Password'];
    $_POST['shop_Password'] = password_hash($password, PASSWORD_BCRYPT);
    $key = $database->createShop($_POST['shop_Email'], $_POST);
    if (isset($key))
        $database->moveFile($key, $_FILES);
    $_POST = [];
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 10;
$_SESSION['page'] = $page;
$result = $database->showRecords('shopdata', "LIMIT $offset, 10");
$result2 = $database->showRecords('shoplogin', "LIMIT $offset, 10");
$totalPages = $database->pagination('shop_id', 10, 'shopdata');

if (isset($_GET['search'])) {
    $searchq = $_GET['search'];
    $result = $database->showRecords('shopdata', "WHERE shop_id LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%' LIMIT $offset, 10");
    $totalPages = $database->pagination('shop_id', 10, 'shopdata', "WHERE shop_id LIKE '%$searchq%' OR shop_Name LIKE '%$searchq%'");
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Shops Profiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/admin.userstable.css">
</head>

<body>
    <div class="wrapper">
        <?php include "../../includes/ADMIN.sidebar.Include.php"; ?>
        <div class="main p-3">
            <div class="container">
                <div class="d-flex flex-row justify-content-between align-content-center">
                    <h2>Shop Profiles</h2>
                    <form class="d-flex flex-row justify-content-end w-50 gap-3" method="get">
                        <input class="form-control mr-sm-2 search-bar" type="search" id="search-bar" name="search"
                            placeholder="Search By ID or Name" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 search search-word"
                            type="submit">Search</button>
                        <?php if (isset($_GET['search'])): ?>
                            <button type="button" class="btn btn-danger my-2 my-sm-0 cancel-word"
                                onclick="window.location.href='?'">Cancel</button>
                        <?php endif; ?>
                        <button class="btn btn-outline-success my-2 my-sm-0 search search-icon" type="button"
                            id="search-icon"><i class="bi bi-search"></i></button>
                        <?php if (isset($_GET['search'])): ?>
                            <button type="button" class="btn btn-danger my-2 my-sm-0 cancel-icon" type="button"
                                id="search-icon" onclick="window.location.href='?'"><i class="bi bi-x-lg"></i></button>
                        <?php endif; ?>
                    </form>
                </div>
                <table id="shops-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Shop ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $shop_count = 0;
                        for ($i = 1; $i < $page; $i++) {
                            $shop_count += 10;
                        }
                        if (count($result) > 0) {
                            for ($i = 0; $i < count($result); $i++) {
                                if ($result[0][0]) {
                                    echo '<tr class=' . "'expandable'" . '>';
                                    echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"shops' . ++$shop_count . '");' . "showHideRow(" . '"shops1' . $shop_count . '");' . "'>" . $shop_count . "</td>";
                                    echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"shops' . $shop_count . '");' . "showHideRow(" . '"shops1' . $shop_count . '");' . "'>" . $result[$i][0] . "</td>";
                                    echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"shops' . $shop_count . '");' . "showHideRow(" . '"shops1' . $shop_count . '");' . "'>" . $result[$i][1] . "</td>";
                                    echo "<td><button class='edit w-40' onclick='window.location.href=" . '"editProfiles.php?shop_ID=' . $result[$i][0] . '"' . "'><span class='action-word'>Edit</span><i class='bi bi-pencil action-btn'></i></button> <button class='delete w-40' onclick='window.location.href=" . '"deleteProfiles.php?shop_ID=' . $result[$i][0] . '"' . "'><span class='action-word'>Delete</span><i class='bi bi-trash action-btn'></i></button></td>";
                                    echo "</tr>";
                                    echo "<tr id='shops" . $shop_count . "' class='hidden'>";
                                    echo "<td colspan='5'><strong>Email:&nbsp;&nbsp;</strong>" . $result2[$i][1] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Phone Number:&nbsp;&nbsp;</strong>" . $result[$i][2] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Location:&nbsp;&nbsp;</strong>" . $result[$i][3] . "</td>";
                                    echo "</tr>";
                                    echo "<tr id='shops1" . $shop_count . "' class='hidden'>";
                                    echo "<td colspan='5'><strong>Shop Image:</strong><br><div class=" . "'shop-image'>" . "<img src='../../img/" . $result[$i][0] . "/shop_Image.png'" . "></div></td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center p-3">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1<?php if (isset($_GET['search'])) {
                                    echo '&search=' . $searchq;
                                } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page - 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    } ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item"><a class="page-link <?= ($i === $page) ? "active" : "" ?>" href="?page=<?= $i ?><?php if (isset($_GET['search'])) {
                                          echo '&search=' . $searchq;
                                      } ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($page + 1) ?><?php if (isset($_GET['search'])) {
                                        echo '&search=' . $searchq;
                                    } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $totalPages ?><?php if (isset($_GET['search'])) {
                                      echo '&search=' . $searchq;
                                  } ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <button type="button" class="create" data-bs-toggle="modal" data-bs-target="#createModal">Create New
                    Record</button>
            </div>
        </div>
    </div>

    <div class="modal fade mod" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Create Shop</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="shop_Name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="shop_Name" name="shop_Name"
                                    placeholder="Name" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="shop_Email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="shop_Email" name="shop_Email"
                                    placeholder="Email" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="shop_Password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" minlength="8" id="shop_Password"
                                    name="shop_Password" placeholder="Password" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="shop_Phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control"
                                    id="shop_Phone" name="shop_Phone" placeholder="10-Digits Phone Number (Optional)">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="shop_Location" class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="shop_Location" name="shop_Location"
                                    placeholder="Location (Optional)">
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
                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create" class="btn btn-success w-25">Create Shop</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/admin.js"></script>
</body>

</html>