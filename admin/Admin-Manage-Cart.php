<?php
include("../partials/Admin-Session.php");
include("../partials/_dbconnect.php");
restrictAdminPage();

// Handle delete request before any HTML output
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteCartID'])) {
    $cartID = intval($_POST['deleteCartID']);
    
    // Prepare the delete statement
    $deleteQuery = "DELETE FROM cart WHERE cartID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $cartID);

    if ($stmt->execute()) {
        header("Location: Admin-Manage-Cart.php");
        exit;
    } else {
        header("Location: Admin-Manage-Cart.php?error=delete_failed");
        exit;
    }

    $stmt->close();
    $conn->close();
}

// Fetch cart items from the database
$query = "SELECT * FROM cart";  
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); // Get result set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Admin-Manage-Cart.css">
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css">
    <title>Manage Cart</title>
</head>
<body>
<?php include("../partials/Admin-Nav-Side.php");?>

<!-- Manage Cart Section -->
<h1 class="users">Cart Items</h1>
<hr />
<div class="users-table">
    <table class="user-table">
        <thead>
            <tr>
                <th>CartID</th>
                <th>UserID</th>
                <th>FoodID</th>
                <th>Food Name</th>
                <th>Quantity</th>
                <th>Food Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cart = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($cart['cartID']); ?></td>
                    <td><?= htmlspecialchars($cart['userID']); ?></td>
                    <td><?= htmlspecialchars($cart['FoodID']); ?></td>
                    <td><?= htmlspecialchars($cart['FoodName']); ?></td>
                    <td><?= htmlspecialchars($cart['Quantity']); ?></td>
                    <td><?= htmlspecialchars($cart['FoodTotal']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="deleteCartID" value="<?= $cart['cartID']; ?>">
                            <button type="submit" class="delete btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="../js/Admin-Nav-Side.js"></script>
</body>
</html>
