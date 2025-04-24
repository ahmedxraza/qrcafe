<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header('Location: Info-Menu.php');
    exit;
}

include('../partials/_dbconnect.php');

$userID = $_POST['userID'];
$tableORsitting = $_POST['tableORsitting'];
$subtotal = $_POST['subtotal'];
$gst = $_POST['gst'];
$grandTotal = $_POST['grandTotal'];
$orderType = $_POST['OrderType'];

$userQuery = "SELECT orderType FROM user WHERE userID = '$userID'";
$userResult = mysqli_query($conn, $userQuery);
if ($userRow = mysqli_fetch_assoc($userResult)) {
    $orderType = $userRow['orderType'];
} else {
    die("Failed to fetch user OrderType: " . mysqli_error($conn));
}

// Step 1: Generate new OrderID
$orderID = 18001; // Default starting point
$orderResult = mysqli_query($conn, "SELECT MAX(OrderID) AS lastOrderID FROM orders");
if ($orderResult) {
    $row = mysqli_fetch_assoc($orderResult);
    if ($row['lastOrderID']) {
        $orderID = $row['lastOrderID'] + 1;
    }
}

// Step 2: Insert into `orders` table
$insertOrderSQL = "INSERT INTO orders (OrderID, userID, OrderType, tableORsitting, SubTotal, GST, GrandTotal, OrderStatus, OrderDate)
VALUES ('$orderID', '$userID', '$orderType', '$tableORsitting', '$subtotal', '$gst', '$grandTotal', 'Pending', NOW())";

if (!mysqli_query($conn, $insertOrderSQL)) {
    die("Order creation failed: " . mysqli_error($conn));
}

// Step 3: Fetch all items from `cart`
$cartQuery = "SELECT * FROM cart WHERE userID = '$userID'";
$cartResult = mysqli_query($conn, $cartQuery);

// Step 4: Insert each item into `order_items`
$orderItemID = 14001; // Default starting point for order items
$orderItemResult = mysqli_query($conn, "SELECT MAX(OrderItemsID) AS lastOrderItemID FROM order_items");
if ($orderItemResult) {
    $row = mysqli_fetch_assoc($orderItemResult);
    if ($row['lastOrderItemID']) {
        $orderItemID = $row['lastOrderItemID'] + 1;
    }
}

// Process cart items into `order_items`
while ($item = mysqli_fetch_assoc($cartResult)) {
    $foodID = $item['FoodID'];
    $quantity = $item['Quantity'];
    $foodTotal = $item['FoodTotal'];

    // Calculate food price dynamically (fix)
    $foodPrice = $foodTotal / $quantity;  // <- This is the corrected line

    $insertItemSQL = "INSERT INTO order_items (OrderItemsID, OrderID, userID, FoodID, Quantity, FoodPrice, FoodTotal)
    VALUES ('$orderItemID', '$orderID', '$userID', '$foodID', '$quantity', '$foodPrice', '$foodTotal')";

    if (!mysqli_query($conn, $insertItemSQL)) {
        die("Order item insertion failed: " . mysqli_error($conn));
    }

    $orderItemID++;
}


// Step 5: Clear the cart for this user
mysqli_query($conn, "DELETE FROM cart WHERE userID = '$userID'");

// Step 6: Redirect to final confirmation page
header('Location: Final-Confirmation.php?orderID=' . $orderID);
exit;
