<?php

include("../partials/Admin-Session.php");
include("../partials/_dbconnect.php");
restrictAdminPage();

// Fetch reviews from the database
$query = "SELECT * FROM Reviews";  // Assuming your table name is 'Reviews'
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result(); // Get result set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Admin-Manage-Reviews.css">
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css">
    <title>Reviews</title>
</head>
<body>
<?php include("../partials/Admin-Nav-Side.php");?>

    <!-- Manage Reviews Section -->
    <h1 class="users">Reviews</h1>
    <hr />
    <div class="users-table">
        <table class="user-table">
            <thead>
                <tr>
                    <th>ReviewID</th>
                    <th>UserID</th>
                    <th>Full Name</th>
                    <th>Mobile No</th>
                    <th>Review</th>
                    <th>Review Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($review['reviewID']); ?></td>
                        <td><?= htmlspecialchars($review['userID']); ?></td>
                        <td><?= htmlspecialchars($review['fullName']); ?></td>
                        <td><?= htmlspecialchars($review['mobileNo']); ?></td>
                        <td><?= htmlspecialchars($review['review']); ?></td>
                        <td><?= date('h:i A - d/m/Y', strtotime($review['reviewDate'])); ?></td>
                        <td>
                        <button class="delete btn" onclick="openDeleteModal(<?= $review['reviewID']; ?>)">Delete</button>
                        </td>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
        <!-- Delete Confirmation Modal -->
<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this review?</p>
        <div class="modal-buttons">
            <button id="confirmDelete" class="confirm-btn">Delete</button>
            <button id="cancelDelete" class="cancel-btn">Cancel</button>
        </div>
    </div>
</div>


    <script src="../js/Admin-Nav-Side.js"></script>
    <script>
let deleteReviewID = null;

// Open Modal Function
function openDeleteModal(reviewID) {
    deleteReviewID = reviewID;
    document.getElementById('deleteModal').style.display = 'flex'; // Ensure it's visible
}

// Close Modal Function
document.getElementById('cancelDelete').addEventListener('click', function() {
    document.getElementById('deleteModal').style.display = 'none';
});

// Close Modal When Clicking Outside (Optional)
window.addEventListener('click', function(event) {
    let modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Confirm Delete Button Function
document.getElementById('confirmDelete').addEventListener('click', function() {
    if (deleteReviewID !== null) {
        window.location.href = "Admin-Delete-Review.php?reviewID=" + deleteReviewID;
    }
});
</script>

</body>
</html>
