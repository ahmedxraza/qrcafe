<?php
// Start session to manage login status
include("../partials/Admin-Session.php");
  include("../partials/_dbconnect.php");
  restrictAdminPage();

// Include database connection
require '../partials/_dbconnect.php';

$adminName = isset($_SESSION['username']) ? $_SESSION['username'] : "Admin"; 

// Fetch all required counts from database
$totalOrders = 0;
$totalFoodItems = 0;
$totalUsers = 0;
$pendingOrders = 0;
$totalReviews = 0;

// Total Orders
$orderQuery = "SELECT COUNT(*) AS total FROM Orders";
$orderResult = mysqli_query($conn, $orderQuery);
if ($row = mysqli_fetch_assoc($orderResult)) {
    $totalOrders = $row['total'];
}

// Food Items
$foodQuery = "SELECT COUNT(*) AS total FROM Food";
$foodResult = mysqli_query($conn, $foodQuery);
if ($row = mysqli_fetch_assoc($foodResult)) {
    $totalFoodItems = $row['total'];
}

// Categories
$catQuery = "SELECT COUNT(*) AS total FROM Category";
$catResult = mysqli_query($conn, $catQuery);
if ($row = mysqli_fetch_assoc($catResult)) {
    $totalCategories = $row['total'];
}

// Total Users
$userQuery = "SELECT COUNT(*) AS total FROM User";
$userResult = mysqli_query($conn, $userQuery);
if ($row = mysqli_fetch_assoc($userResult)) {
    $totalUsers = $row['total'];
}

// Pending Orders (assuming paymentStatus 'Pending')
$pendingOrderQuery = "SELECT COUNT(*) AS total FROM Orders WHERE OrderStatus = 'Pending'";
$pendingOrderResult = mysqli_query($conn, $pendingOrderQuery);
if ($row = mysqli_fetch_assoc($pendingOrderResult)) {
    $pendingOrders = $row['total'];
}

// Total Reviews (if you have a feedback table)
$reviewQuery = "SELECT COUNT(*) AS total FROM reviews";
$reviewResult = mysqli_query($conn, $reviewQuery);
if ($row = mysqli_fetch_assoc($reviewResult)) {
    $totalReviews = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Admin-Dashboard.css">
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css">
    <title>Admin Dashboard</title>
    <style>
        .stat-icon {
            width: 85px;
            height: 85px;
            object-fit: contain;
        }
    </style>
</head>
<body>
  <?php include("../partials/Admin-Nav-Side.php");?>
    <!-- Dashboard -->
    <h1 class="hd">Dashboard</h1>
    <div class="welcome hov">
        <h1 class="wh">
        Welcome Back "<span class="name"><?php echo htmlspecialchars($adminName); ?></span>" <br> Good to see you
        </h1>
    </div>

    <div class="containerr">
        <div class="dashboard-stats">
            <div class="stat-box orders hov">
                <img src="../assets/admin/Total-orders.png" alt="Orders Icon" class="stat-icon">
                <div class="stat-text">
                    <span class="stat-number"><?php echo $totalOrders; ?></span>
                    <span class="stat-label">Total Orders</span>
                </div>
            </div>

            <div class="stat-box food hov">
                <img src="../assets/admin/Food-Items.png" alt="Food Icon" class="stat-icon">
                <div class="stat-text">
                    <span class="stat-number"><?php echo $totalFoodItems; ?></span>
                    <span class="stat-label">Food Items</span>
                </div>
            </div>

            <div class="stat-box tables hov">
                <img src="../assets/admin/Categories.png" alt="Table Icon" class="stat-icon">
                <div class="stat-text">
                    <span class="stat-number"><?php echo $totalCategories; ?></span> <!-- You can also make this dynamic if needed -->
                    <span class="stat-label">Total Categories</span>
                </div>
            </div>

            <div class="stat-box users hov">
                <img src="../assets/admin/Users.png" alt="Users Icon" class="stat-icon">
                <div class="stat-text">
                    <span class="stat-number"><?php echo $totalUsers; ?></span>
                    <span class="stat-label">Users</span>
                </div>
            </div>

            <div class="stat-box p-orders hov">
                <img src="../assets/admin/pending-orders.png" alt="Pending Orders Icon" class="stat-icon">
                <div class="stat-text">
                    <span class="stat-number"><?php echo $pendingOrders; ?></span>
                    <span class="stat-label">Pending Orders</span>
                </div>
            </div>

            <div class="stat-box reviews hov">
                <img src="../assets/admin/reviews.png" alt="Reviews Icon" class="stat-icon">
                <div class="stat-text">
                    <span class="stat-number"><?php echo $totalReviews; ?></span>
                    <span class="stat-label">Reviews</span>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/Admin-Nav-Side.js"></script>
</body>
</html>
