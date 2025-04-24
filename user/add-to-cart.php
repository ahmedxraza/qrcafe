<?php
session_start();
include('../partials/_dbconnect.php');

if (!isset($_SESSION['userID'])) {
    echo "error: not logged in";
    exit;
}

$userID = $_SESSION['userID'];
$foodID = $_POST['foodID'];
$foodName = $_POST['foodName'];
$foodPrice = $_POST['foodPrice'];

// Debugging - check what is coming
file_put_contents('debug_log.txt', "userID: $userID, foodID: $foodID, foodName: $foodName, foodPrice: $foodPrice\n", FILE_APPEND);

// If all values are coming correctly, only then proceed to query
if (empty($foodID) || empty($foodName) || empty($foodPrice)) {
    echo "error: missing data";
    exit;
}

// Check if item already exists in cart
$checkSql = "SELECT Quantity FROM cart WHERE userID = ? AND FoodID = ?";
$stmt = mysqli_prepare($conn, $checkSql);
mysqli_stmt_bind_param($stmt, "ii", $userID, $foodID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $newQuantity = $row['Quantity'] + 1;
    $newTotal = $newQuantity * $foodPrice;
    $updateSql = "UPDATE cart SET Quantity = ?, FoodTotal = ? WHERE userID = ? AND FoodID = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "idii", $newQuantity, $newTotal, $userID, $foodID);
    if (mysqli_stmt_execute($updateStmt)) {
        echo "success";
    } else {
        echo "error: update failed";
    }
} else {
    $quantity = 1;
    $foodTotal = $foodPrice;
    $insertSql = "INSERT INTO cart (userID, FoodID, FoodName, Quantity, FoodTotal) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertSql);
    mysqli_stmt_bind_param($insertStmt, "issid", $userID, $foodID, $foodName, $quantity, $foodTotal);
    if (mysqli_stmt_execute($insertStmt)) {
        echo "success";
    } else {
        echo "error: insert failed";
    }
}
?>
