<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css" />
    <title>Admin Dashboard</title>
  </head>
  <body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <h2>QR CAFE</h2>
      </div>
      <ul>
        <li><a href="../admin/Admin-Dashboard.php">Dashboard</a></li>
        <li><a href="../admin/Admin-Manage-Orders.php">Manage Orders</a></li>
        <!--<li><a href="#">Manage Tables</a></li> -->
        <li><a href="../admin/Admin-Manage-Categories.php">Manage Categories</a></li>
        <li><a href="../admin/Admin-Manage-Inventory.php">Manage Inventory</a></li>
        <li><a href="../admin/Admin-Manage-Users.php">User's Info</a></li>
        <li><a href="../admin/Admin-Manage-Review.php">User's Reviews</a></li>
        <li><a href="../admin/Admin-Manage-Cart.php">User's Cart</a></li>
        
      </ul>
      <div class="logout-btn">
        <img
          src="../assets/Admin/Logout.png"
          alt="Logout Icon"
          class="logout-icon"
        />
        <!-- Custom logout icon -->
        <a href="Admin-Logout.php" id="span">Logout</a>
        <!-- Logout text -->
      </div>
    </div>

    <!-- Overlay (Clicking this will close sidebar) -->
    <div class="overlay" id="overlay"></div>

    <!-- Navbar -->
    <div class="navbar">
      <div class="hamburger" id="hamburger">&#9776;</div>
      <h1 class="heading">QR Cafe Admin Panel</h1>
    </div>

    <script src="../js/Admin-Nav-Side.js"></script>
  </body>
</html>
