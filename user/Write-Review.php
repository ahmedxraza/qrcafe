<?php
session_start();
include('../partials/_dbconnect.php');

// Redirect if not logged in
if (!isset($_SESSION['userID'])) {
    header("Location: Info-Menu.php"); // Redirect to login page if session not set
    exit;
}

$userID = $_SESSION['userID'];

// Fetch user data from user table (fullName, mobileNo)
$stmt = $conn->prepare("SELECT fullName, mobileNo FROM user WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // User not found (should not happen if session is correctly set)
    header("Location: Info-Menu.php");
    exit;
}

$userData = $result->fetch_assoc();
$fullName = $userData['fullName'];
$mobileNo = $userData['mobileNo'];

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = trim($_POST['review']);

    if (!empty($review)) {
        $stmt = $conn->prepare("INSERT INTO reviews (userID, fullName, mobileNo, review, reviewDate) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isss", $userID, $fullName, $mobileNo, $review);

        if ($stmt->execute()) {
            $success = "Review submitted successfully!";
        } else {
            $error = "Failed to submit review.";
        }
    } else {
        $error = "Please fill the review field.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Write-Review.css">
    <title>User's Review Page</title>
</head>
<body>
<a href="./Main-Menu.php" class="back-arrow"
      ><img src="../assets/MainMenu-imgs/back.png" alt="back" />
    </a>

<h2 class="H-Q">QR CAFE</h2>

<form action="" method="POST" onsubmit="return validateForm()">
    <div class="form-group">
        <label for="review">Write a Review</label>
        <textarea name="review" id="review" placeholder="Share Your Sweet Memories"></textarea>
        <p class="err" id="errorMsg">*Please Fill The Review</p>

        <?php if (isset($error)) { ?>
            <p class="err" style="display:block;"><?php echo $error; ?></p>
        <?php } elseif (isset($success)) { ?>
            <p style="color: green; font-size: 1.6rem;"><?php echo $success; ?></p>
        <?php } ?>

        <input type="submit" value="Submit">
    </div>
</form>

<a href="./Main-Menu.php" class="back"><-- Go Back to Home</a>

<hr>
<h2 class="H-Q">Reviews</h2>

<div class="review-container">
    <?php
    $result = $conn->query("SELECT fullName, review, DATE_FORMAT(reviewDate, '%h:%i %p - %d/%m/%Y') AS formattedDate FROM reviews ORDER BY reviewDate DESC");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="review">';
            echo '<h3>' . htmlspecialchars($row['fullName']) . '</h3>';
            echo '<p class="time">' . $row['formattedDate'] . '</p>';
            echo '<p class="review-text">' . nl2br(htmlspecialchars($row['review'])) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p class="nor">No reviews yet. Be the first to write one!</p>';
    }
    ?>
</div>

<script>
function validateForm() {
    const review = document.getElementById("review").value.trim();
    const errorMsg = document.getElementById("errorMsg");

    if (review === "") {
        errorMsg.style.display = "block";
        return false;
    } else {
        errorMsg.style.display = "none";
        return true;
    }
}
</script>

</body>
</html>
