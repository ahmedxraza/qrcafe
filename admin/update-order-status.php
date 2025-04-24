<?php
include '../partials/_dbconnect.php';

if (isset($_GET['orderID']) && isset($_GET['status'])) {
    $orderID = $_GET['orderID'];  // lowercase
    $status = $_GET['status'];

    $query = "UPDATE Orders SET OrderStatus = ? WHERE OrderID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $orderID);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: Admin-Manage-Orders.php?statusUpdated=1");
        exit;
    } else {
        header("Location: Admin-Manage-Orders.php?statusUpdated=0");
        exit;
    }
} else {
    header("Location: Admin-Manage-Orders.php?statusUpdated=0");
    exit;
}
?>
