<?php
session_start();

// Function to log in the admin
function adminLogin($username) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
}

// Function to check if the admin is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

// Function to log out the admin
function adminLogout() {
    session_unset();
    session_destroy();
    header("location: ../admin/Admin-Login.php");
    exit;
}

// Restrict access to admin pages
function restrictAdminPage() {
    if (!isAdminLoggedIn()) {
        header("location: ../admin/Admin-Login.php");
        exit;
    }
}
?>
