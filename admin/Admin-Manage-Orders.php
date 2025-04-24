<?php
  include("../partials/Admin-Session.php");
  include("../partials/_dbconnect.php");
  restrictAdminPage();


// Initialize filters with default values
$orderType = $_POST['orderType'] ?? 'all';
$orderStatus = $_POST['orderStatus'] ?? 'all';
$paymentStatus = $_POST['paymentStatus'] ?? 'all';

// Build SQL query with filters
$sql = "SELECT o.*, u.mobileNo, u.tableORsitting, u.fullName 
        FROM Orders o 
        JOIN User u ON o.userID = u.userID
        WHERE 1"; // 1 to simplify appending conditions

if ($orderType !== 'all') {
    $sql .= " AND u.orderType = '$orderType'";
}

if ($orderStatus !== 'all') {
    $sql .= " AND o.orderStatus = '$orderStatus'";
}

if ($paymentStatus !== 'all') {
    $sql .= " AND o.paymentStatus = '$paymentStatus'";
}

// Execute query
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

// Fetch orders into array
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../css/Admin-Manage-Orders.css">
</head>
<body>
    <?php include "../partials/Admin-Nav-Side.php"; ?>

    <div class="upper">
        <h1 class="head">Manage Orders</h1>
        <form action="Admin-Manage-Orders.php" method="POST">
        <div class="form-row">
            <label>Order Type:</label>
                <select name="orderType">
                    <option value="all" <?= $orderType === 'all' ? 'selected' : '' ?>>All</option>
                    <option value="Dine-In" <?= $orderType === 'Dine-In' ? 'selected' : '' ?>>Dine-in</option>
                    <option value="Takeaway" <?= $orderType === 'Takeaway' ? 'selected' : '' ?>>Takeaway</option>
                </select>
          </div>
        <div class="form-row">
            <label>Order Status:</label>
                <select name="orderStatus">
                    <option value="all" <?= $orderStatus === 'all' ? 'selected' : '' ?>>All</option>
                    <option value="Pending" <?= $orderStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Confirmed" <?= $orderStatus === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                    <option value="Cancelled" <?= $orderStatus === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    <option value="Served" <?= $orderStatus === 'Served' ? 'selected' : '' ?>>Served</option>
                </select>
          </div>

        <div class="form-row">
            <label>Payment Status:</label>
                <select name="paymentStatus">
                    <option value="all" <?= $paymentStatus === 'all' ? 'selected' : '' ?>>All</option>
                    <option value="Pending" <?= $paymentStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Paid" <?= $paymentStatus === 'Paid' ? 'selected' : '' ?>>Paid</option>
                </select>
          </div>

            <button type="submit" class="search">Search</button>
        </form>
        <hr>
    </div>

    <div class="lower">
        <h1 class="order-title">All Orders</h1>

        <?php if (count($orders) > 0): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order">
                    <div class="o-heading">
                        <div class="left">
                            <p class="oname"><?= $order['fullName'] ?></p>
                            <p class="odate"><?= $order['OrderDate'] ?></p>
                        </div>
                        <p class="otors"><?= $order['tableORsitting'] ?></p>
                        <p class="oid">Order ID: #<?= $order['OrderID'] ?></p>
                    </div>

                    <!-- Show Items for each order -->
                    <div class="otable">
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Food Name</th>
                                    <th>Food Price</th>
                                    <th>Quantity</th>
                                    <th>Food Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orderID = $order['OrderID'];
                                $itemsResult = mysqli_query($conn, 
                                    "SELECT f.foodname, f.foodPrice, oi.quantity, oi.foodTotal 
                                     FROM Order_Items oi 
                                     JOIN Food f ON oi.foodID = f.foodId 
                                     WHERE oi.orderID = $orderID"
                                );
                                while ($item = mysqli_fetch_assoc($itemsResult)):
                                ?>
                                    <tr>
                                        <td><?= $item['foodname'] ?></td>
                                        <td>₹<?= $item['foodPrice'] ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>₹<?= $item['foodTotal'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <div class="summary-container">
                            <table class="summary-table">
                                <tr class="sub-total"><td>Subtotal:</td><td>₹<?= $order['SubTotal'] ?></td></tr>
                                <tr class="gst"><td>GST:</td><td>₹<?= $order['GST'] ?></td></tr>
                                <tr class="grand-total"><td>Grand Total:</td><td>₹<?= $order['GrandTotal'] ?></td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="obottom">
                    <button class="b1" onclick="openDialog('orderStatusDialog', <?= $order['OrderID'] ?>)">Order Status: <b><?= $order['OrderStatus'] ?></b></button>
                    <button class="b2" onclick="openDialog('paymentStatusDialog', <?= $order['OrderID'] ?>)">Payment Status: <b><?= $order['PaymentStatus'] ?></b></button>
                    <button class="b3" onclick="openDeleteDialog(<?= $order['OrderID'] ?>)">
                      <img src="../assets/Admin/deletebinicon.png" height="25" width="25">
                    </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

          <!-- Dialog for Order Status -->
<div class="dialog" id="orderStatusDialog">
  <h2>Update Order Status</h2>
  <select id="orderStatusDDL">
    <option value="Pending">Pending</option>
    <option value="Confirmed">Confirmed</option>
    <option value="Cancelled">Cancelled</option>
    <option value="Served">Served</option>
  </select>
  <button onclick="updateOrderStatus()" class="bhnc greenbtn">Update</button>
  <button onclick="closeDialog('orderStatusDialog')" class="bhnc redbtn">Cancel</button>
</div>

<!-- Dialog for Payment Status -->
<div class="dialog" id="paymentStatusDialog">
  <h2>Update Payment Status</h2>
  <select id="paymentStatusDDL">
    <option value="Pending">Pending</option>
    <option value="Paid">Paid</option>
  </select>
  <button onclick="updatePaymentStatus()" class="bhnc greenbtn">Update</button>
  <button onclick="closeDialog('paymentStatusDialog')" class="bhnc redbtn">Cancel</button>
</div>

<!-- Dialog for Delete Confirmation -->
<div class="dialog" id="deleteDialog">
  <h2>Are you sure you want to delete this order?</h2>
  <button onclick="confirmDelete()" class="bhnc redbtn">Delete</button>
  <button onclick="closeDialog('deleteDialog')" class="bhnc greenbtn">Cancel</button>
</div>

<!-- Dialog Overlay -->
<div class="dialog-overlay" id="dialogOverlay"></div>


    <script>
              let currentOrderID = null; // This will hold the orderID for whichever order we are working with.

function openDialog(dialogId, orderID = null) {
    if (orderID) {
        currentOrderID = orderID; // Store orderID when opening.
    }
    document.getElementById(dialogId).style.display = "block";
    document.getElementById("dialogOverlay").style.display = "block";
}

function closeDialog(dialogId) {
    document.getElementById(dialogId).style.display = "none";
    document.getElementById("dialogOverlay").style.display = "none";
    currentOrderID = null; // Reset orderID after closing.
}

// Open delete dialog separately because it always needs the orderID.
function openDeleteDialog(orderID) {
    currentOrderID = orderID;
    openDialog('deleteDialog');
}

// Update Order Status (send to server with orderID)
function updateOrderStatus() {
    const selectedStatus = document.getElementById("orderStatusDDL").value;
    if (!currentOrderID) {
        alert("Order ID is missing!");
        return;
    }
    // Example Ajax Request (or form submission)
    window.location.href = `update-order-status.php?orderID=${currentOrderID}&status=${selectedStatus}`;
}

// Update Payment Status (send to server with orderID)
function updatePaymentStatus() {
    const selectedStatus = document.getElementById("paymentStatusDDL").value;
    if (!currentOrderID) {
        alert("Order ID is missing!");
        return;
    }
    // Example Ajax Request (or form submission)
    window.location.href = `update-payment-status.php?orderID=${currentOrderID}&status=${selectedStatus}`;
}

// Delete Order (after confirmation)
function confirmDelete() {
    if (!currentOrderID) {
        alert("Order ID is missing!");
        return;
    }
    window.location.href = `delete-order.php?orderID=${currentOrderID}`;
}

    </script>
  </body>
</html>