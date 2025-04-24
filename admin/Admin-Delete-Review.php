<?php
include('../partials/_dbconnect.php');

if (isset($_GET['reviewID'])) {
    $reviewID = $_GET['reviewID'];

    $query = "DELETE FROM Reviews WHERE reviewID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $reviewID);

    if ($stmt->execute()) {
        header("Location: Admin-Manage-Review.php?msg=deleted");
        exit();
    } else {
        header("Location: Admin-Manage-Review.php?msg=error");
        exit();
    }
} else {
    header("Location: Admin-Manage-Review.php");
    exit();
}
?>
