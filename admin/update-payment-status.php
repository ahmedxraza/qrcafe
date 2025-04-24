<?php
// update-payment-status.php

require '../partials/_dbconnect.php'; // Database connection file

if (isset($_GET['orderID']) && isset($_GET['status'])) {
    $orderID = $_GET['orderID'];
    $paymentStatus = $_GET['status'];

    $query = "UPDATE Orders SET PaymentStatus = ? WHERE OrderID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $paymentStatus, $orderID);

    if ($stmt->execute()) {
        header('Location: Admin-Manage-Orders.php?paymentUpdated=1');
        exit;
    } else {
        header('Location: Admin-Manage-Orders.php?paymentUpdated=0');
        exit;
    }
} else {
    header('Location: Admin-Manage-Orders.php?paymentUpdated=0');
    exit;
}
