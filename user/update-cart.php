<?php
session_start();
include('../partials/_dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartID = $_POST['cartID'];
    $quantity = $_POST['quantity'];
    $foodTotal = $_POST['foodTotal'];

    $sql = "UPDATE cart SET Quantity = '$quantity', FoodTotal = '$foodTotal' WHERE cartID = '$cartID'";
    mysqli_query($conn, $sql);
}
