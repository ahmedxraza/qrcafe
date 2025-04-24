<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header('Location: Info-Menu.php');
    exit;
}

include('../partials/_dbconnect.php');

if (!isset($_GET['orderID'])) {
    die("Invalid Access - No Order ID provided.");
}

$orderID = $_GET['orderID'];
$userID = $_SESSION['userID'];

// Fetch User's Name
$userQuery = "SELECT FullName FROM user WHERE userID = '$userID'";
$userResult = mysqli_query($conn, $userQuery);
if ($userRow = mysqli_fetch_assoc($userResult)) {
    $userName = $userRow['FullName'];
} else {
    $userName = "Valued Customer";  
}

// Fetch Grand Total for the specific order
$orderQuery = "SELECT GrandTotal FROM orders WHERE orderID = '$orderID' AND userID = '$userID' ORDER BY orderID DESC LIMIT 1";
$orderResult = mysqli_query($conn, $orderQuery);
if ($orderRow = mysqli_fetch_assoc($orderResult)) {
    $grandTotal = $orderRow['GrandTotal'];
} else {
    $grandTotal = "N/A";  
}

// Close DB connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Final-Confirmation.css" />
    <title>Order Confirmation - QR Cafe</title>
  </head>
  <body>
    <h2 class="H-Q">QR CAFE</h2>

    <div class="container">
      <h1>
        Hurrayyy!!!!! <span> <?php echo htmlspecialchars($userName); ?>,</span><br />
        Your Order Is Confirmed.
      </h1>
      <p>
        Please Wait For 15 Minutes <br />
        your order is being prepared
      </p>
      <h1 class="oid">Order ID: #<?php echo $orderID; ?></h1>
      <h1 class="thx">Thanks For Ordering! 😊</h1>
      <button class="back" onclick="window.location.href='./Write-Review.php'">
        Share Your Experience!!
      </button>
    </div>

    <div class="payment">
      <p class="pp">Pay Online!!</p>
      <p class="bill">Grand Total: ₹ <?php echo htmlspecialchars($grandTotal); ?></p>
      <div class="pay">
        <img
          src="../assets/MainMenu-imgs/payqrcode.png"
          alt="Payment QR Code"
          height="200px"
        />
      </div>
      <p class="ppp">UPI ID: workahmadraza@okicici</p>
    </div>
  </body>
</html> 
