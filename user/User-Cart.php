<?php
session_start();
if (!isset($_SESSION['fullname']) || !isset($_SESSION['userID'])) {
    header('Location: Info-Menu.php');
    exit;
}

include('../partials/_dbconnect.php');
$userid = $_SESSION['userID'];
$fullname = $_SESSION['fullname'];

// Fetch tableORsitting from user table
$sqlTable = "SELECT tableORsitting FROM user WHERE userID = '$userid'";
$resultTable = mysqli_query($conn, $sqlTable);
$tableRow = mysqli_fetch_assoc($resultTable);
$tableORsitting = $tableRow['tableORsitting'] ?? 'N/A';

// Fetch Cart Items using userID (not fullname)
$cartItems = [];
$sql = "SELECT c.cartID, c.FoodID, f.FoodName, f.FoodImage, c.Quantity, c.FoodTotal
        FROM cart c
        JOIN food f ON c.FoodID = f.FoodID
        WHERE c.userID = '$userid'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/User-Cart.css">
    <title>My Cart</title>
</head>
<body>

<h2 class="H-Q">QR CAFE</h2>
<div class="container">
    <h2 class="title">Order Summary</h2>
    <h2 class="tbl"><?= htmlspecialchars($tableORsitting) ?></h2>

    <div class="items-container" id="cartItemsContainer">
    <?php if (count($cartItems) > 0): ?>
        <?php foreach ($cartItems as $item): ?>
            <div class="item" data-cartid="<?= $item['cartID'] ?>" data-foodid="<?= $item['FoodID'] ?>" data-price="<?= $item['FoodTotal'] / $item['Quantity'] ?>">
                <div class="item-img">
                    <img src="../assets/FOODS/<?= htmlspecialchars($item['FoodImage']) ?>" alt="<?= htmlspecialchars($item['FoodName']) ?>">
                </div>
                <div class="item-details">
                    <p class="item-name"><?= htmlspecialchars($item['FoodName']) ?></p>
                    <div class="quantity">
                        <button class="qty-btn" onclick="updateQuantity(<?= $item['cartID'] ?>, -1)">-</button>
                        <span class="qty-count"><?= $item['Quantity'] ?></span>
                        <button class="qty-btn" onclick="updateQuantity(<?= $item['cartID'] ?>, 1)">+</button>
                    </div>
                </div>
                <p class="item-price">₹ <span class="item-total" data-rawtotal="<?= $item['FoodTotal'] ?>"><?= number_format($item['FoodTotal'], 2) ?></span></p>
            </div>
            <!-- <hr class="break"> -->
        <?php endforeach; ?>
    <?php else: ?>
        <p class="empty">Your cart is empty.</p>
    <?php endif; ?>
</div>


    <div class="billing">
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₹ <span id="subtotal">0.00</span></span>
            </div>
            <div class="total-row">
                <span>GST (5%):</span>
                <span>₹ <span id="gst">0.00</span></span>
            </div>
            <div class="total-row grand-total">
                <span>Grand Total:</span>
                <span>₹ <span id="grandTotal">0.00</span></span>
            </div>
        </div>
        <div class="final">
            <button class="pay hnc" id="payButton" onclick="openModal()" <?= count($cartItems) == 0 ? 'disabled' : '' ?>>Pay At Counter</button>
            <br>
            <a href="./Main-Menu.php" id="back"><- Go Back To Menu</a>
        </div>
    </div>
</div>

<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <h3>Confirm Order</h3>
        <p>Are you sure you want to proceed with the order?</p>
        <form action="place-order.php" method="POST">
            <input type="hidden" name="userID" value="<?= $_SESSION['userID'] ?>">
            <input type="hidden" name="tableORsitting" value="<?= htmlspecialchars($tableORsitting) ?>">
            <input type="hidden" name="subtotal" id="formSubtotal">
            <input type="hidden" name="gst" id="formGST">
            <input type="hidden" name="grandTotal" id="formGrandTotal">

            <div class="modal-buttons">
                <button type="submit" class="modal-btn confirm-btn hnc">Yes, Confirm</button>
                <button type="button" class="modal-btn cancel-btn hnc" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function updateQuantity(cartID, change) {
    const item = document.querySelector(`.item[data-cartid="${cartID}"]`);
    const qtySpan = item.querySelector('.qty-count');
    let qty = parseInt(qtySpan.innerText) + change;

    if (qty < 1) {
        removeFromCart(cartID);
        return;
    }

    qtySpan.innerText = qty;

    const pricePerItem = parseFloat(item.getAttribute('data-price'));
    const newTotal = pricePerItem * qty;

    // Update both displayed total and raw data for calculations
    const totalElement = item.querySelector('.item-total');
    totalElement.innerText = newTotal.toFixed(2);
    totalElement.setAttribute('data-rawtotal', newTotal);  // THIS LINE IS MISSING IN YOUR CODE

    fetch('update-cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cartID=${cartID}&quantity=${qty}&foodTotal=${newTotal}`
    }).then(() => updateTotals());
}


function removeFromCart(cartID) {
    fetch('remove-from-cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cartID=${cartID}`
    }).then(() => {
        document.querySelector(`.item[data-cartid="${cartID}"]`).remove();
        updateTotals();
    });
}

function updateTotals() {
    let subtotal = 0;

    document.querySelectorAll('.item').forEach(item => {
        subtotal += parseFloat(item.querySelector('.item-total').getAttribute('data-rawtotal'));
    });

    const gst = subtotal * 0.05;
    const grandTotal = subtotal + gst;

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('gst').innerText = gst.toFixed(2);
    document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);

    document.getElementById('payButton').disabled = (subtotal === 0);
}

function openModal() {
    const subtotal = parseFloat(document.getElementById('subtotal').innerText);
    const gst = parseFloat(document.getElementById('gst').innerText);
    const grandTotal = parseFloat(document.getElementById('grandTotal').innerText);

    document.getElementById('formSubtotal').value = subtotal.toFixed(2);
    document.getElementById('formGST').value = gst.toFixed(2);
    document.getElementById('formGrandTotal').value = grandTotal.toFixed(2);

    document.getElementById("confirmModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("confirmModal").style.display = "none";
}

updateTotals(); // Initial load
</script>

</body>
</html>
