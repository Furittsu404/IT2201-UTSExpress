<?php
session_start();
$_SESSION['site'] = 'users';
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../");
}

$connection = new Connection();
$database = new adminAction($connection->connect());

if (isset($_POST['create'])) {
    $password = $_POST['user_Password'];
    $_POST['user_Password'] = password_hash($password, PASSWORD_BCRYPT);
    $database->create($_POST['user_Email'], $_POST);
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * 10;
$_SESSION['page'] = $page;
$result = $database->showRecords('userdata', "LIMIT $offset, 10");
$result2 = $database->showRecords('userlogin', "LIMIT $offset, 10");
$totalPages = $database->pagination('user_id', 10, 'userdata');

if (isset($_GET['search'])) {
    $searchq = $_GET['search'];
    $result = $database->showRecords('userdata', "WHERE user_id LIKE '%$searchq%' OR user_Name LIKE '%$searchq%' LIMIT $offset, 10");
    $totalPages = $database->pagination('user_id', 10, 'userdata', "WHERE user_id LIKE '%$searchq%' OR user_Name LIKE '%$searchq%'");
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../../includes/head.Include.php' ?>
    <title>Users Profiles</title>
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
                <div class="d-flex flex-row justify-content-between">
                    <h2>User Profiles</h2>
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
                <table id="users-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_count = 0;
                        for ($i = 1; $i < $page; $i++) {
                            $user_count += 10;
                        }
                        if (count($result) > 0) {
                            for ($i = 0; $i < count($result); $i++) {
                                if ($result[0][0]) {
                                    echo '<tr class=' . "'expandable'" . '>';
                                    echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"user' . ++$user_count . '");' . "'>" . $user_count . "</td>";
                                    echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"user' . $user_count . '");' . "'>" . $result[$i][0] . "</td>";
                                    echo "<td class=" . '"expandable"' . "onclick='showHideRow(" . '"user' . $user_count . '");' . "'>" . $result[$i][2] . "</td>";
                                    echo "<td><button class='edit w-40' onclick='window.location.href=" . '"edit.php?user_ID=' . $result[$i][0] . '"' . "'><span class='action-word'>Edit</span><i class='bi bi-pencil action-btn'></i></button> <button class='delete w-40' onclick='window.location.href=" . '"delete.php?user_ID=' . $result[$i][0] . '"' . "'><span class='action-word'>Delete</span><i class='bi bi-trash action-btn'></i></button></td>";
                                    echo "</tr>";
                                    echo "<tr id='user" . $user_count . "' class='hidden'>";
                                    echo "<td colspan='5'><strong>Email:&nbsp;&nbsp;</strong>" . $result2[$i][1] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Nickname:&nbsp;&nbsp;</strong>" . $result[$i][1] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Phone Number:&nbsp;&nbsp;</strong>" . $result[$i][3] . "<strong>&nbsp;&nbsp;&nbsp;&nbsp;Location:&nbsp;&nbsp;</strong>" . $result[$i][4] . "</td>";
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
                    <h1 class="modal-title fs-5" id="createModalLabel">Create User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group row">
                            <label for="user_Name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user_Name" name="user_Name"
                                    placeholder="Name" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="user_Nickname" class="col-sm-2 col-form-label">Nickname</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user_Nickname" name="user_Nickname"
                                    placeholder="Nickname" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="user_Email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="user_Email" name="user_Email"
                                    placeholder="Email" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="user_Password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="user_Password" name="user_Password"
                                    placeholder="Password" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="user_Phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="tel" oninput="numberOnly(this.id);" pattern=".{10}" class="form-control"
                                    id="user_Phone" name="user_Phone" placeholder="10-Digits Phone Number (Optional)">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="user_Location" class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user_Location" name="user_Location"
                                    placeholder="Location (Optional)">
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create" class="btn btn-success w-25">Create User</button>
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