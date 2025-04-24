<?php
include("../partials/Admin-Session.php");
include("../partials/_dbconnect.php");
restrictAdminPage();

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteUserID'])) {
    $userID = intval($_POST['deleteUserID']);

    // Delete related data from other tables first
    $deleteOrderItems = "DELETE FROM Order_Items WHERE userID = $userID";
    $deleteOrders = "DELETE FROM Orders WHERE userID = $userID";
    $deleteReviews = "DELETE FROM Reviews WHERE userID = $userID";
    $deleteUser = "DELETE FROM user WHERE userID = $userID";

    $success = true;

    // Execute delete queries
    if (!mysqli_query($conn, $deleteOrderItems)) $success = false;
    if (!mysqli_query($conn, $deleteOrders)) $success = false;
    if (!mysqli_query($conn, $deleteReviews)) $success = false;
    if (!mysqli_query($conn, $deleteUser)) $success = false;

    if ($success) {
        echo "success";
    } else {
        echo "error";
    }
    mysqli_close($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Admin-Manage-Users.css" />
    <link rel="stylesheet" href="../css/Admin-Nav-Side.css" />
    <title>Manage Users</title>
</head>
<body>
<?php include("../partials/Admin-Nav-Side.php");?>
    <!-- Manage Users Start Here -->
    <h1 class="users">Users</h1>
    <hr />
    <div class="users-table">
        <table class="user-table">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Action</th> <!-- Added Action Column -->
                </tr>
            </thead>
            <tbody>
                <?php
                include "../partials/_dbconnect.php";

                $sql = "SELECT userID, fullName, email, mobileNo FROM user"; 
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['userID']}</td>
                                <td>{$row['fullName']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['mobileNo']}</td>
                                <td>
                                    <button class='delete btn' onclick='openDeleteModal({$row['userID']})'>Delete</button>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Failed to fetch data from database!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this user?</p>
            <div class="modal-buttons">
                <button id="confirmDelete" class="confirm-btn">Delete</button>
                <button id="cancelDelete" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <script src="../js/Admin-Nav-Side.js"></script>
    <script>
        let deleteUserID = null;

        // Open Modal Function
        function openDeleteModal(userID) {
            deleteUserID = userID;
            document.getElementById('deleteModal').style.display = 'flex'; // Show modal
        }

        // Close Modal Function
        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').style.display = 'none'; // Hide modal
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
            if (deleteUserID !== null) {
                fetch("Admin-Manage-Users.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "deleteUserID=" + deleteUserID
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        alert("User deleted successfully!");
                        location.reload();
                    } else {
                        alert("Failed to delete user.");
                    }
                });
            }
        });
    </script>
</body>
</html>
