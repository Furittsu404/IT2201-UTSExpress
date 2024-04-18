<?php
include '../db/action.php'; // Include your database connection script
include '../db/connection.php';
$searchq = $_GET['search'];
$shop_ID = $_GET['shop_ID'];
$conn = new Connection(); // Initialize your database connection
$database = new Database($conn->connect()); // Initialize your database connection

$result = $database->showRecords('shopproducts', "WHERE shop_ID = '$shop_ID' AND product_ID LIKE '%$searchq%' OR 0 [0]LIKE '%$searchq%' LIMIT 0,[0] 9");

// Output the results in the format you want
foreach ($result as $row) {
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
    echo "<p>{$row[0][0]}</p>";
}
?>