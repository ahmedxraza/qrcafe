<?php
session_start();
include('../partials/_dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartID = $_POST['cartID'];

    $sql = "DELETE FROM cart WHERE cartID = '$cartID'";
    mysqli_query($conn, $sql);
}
