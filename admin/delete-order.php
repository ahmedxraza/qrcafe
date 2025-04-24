<?php
require '../partials/_dbconnect.php'; // Your DB connection file

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    // 1. First, delete from Order_Items table (because it depends on Orders)
    $query1 = "DELETE FROM Order_Items WHERE OrderID = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param('i', $orderID);

    if (!$stmt1->execute()) {
        // Failed to delete items - redirect back with error
        header('Location: Admin-Manage-Orders.php?orderDeleted=0');
        exit;
    }

    // 2. Then, delete from Orders table
    $query2 = "DELETE FROM Orders WHERE OrderID = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('i', $orderID);

    if ($stmt2->execute()) {
        // Success
        header('Location: Admin-Manage-Orders.php?orderDeleted=1');
        exit;
    } else {
        // Failed to delete order itself - redirect back with error
        header('Location: Admin-Manage-Orders.php?orderDeleted=0');
        exit;
    }
} else {
    header('Location: Admin-Manage-Orders.php?orderDeleted=0');
    exit;
}
