<?php
require_once ('Inventory.php');
session_start();

if (isset($_GET['inventoryId'], $_GET['quantity'])) {
    $inventoryId = $_GET['inventoryId'];
    $quantity = $_GET['quantity'];

    if (Inventory::issueStock($inventoryId, $quantity)) {
        $_SESSION['adjust_success_1'] = "Product issued successfully";
    } else {
        $_SESSION['adjust_error_1'] = "Sorry, Not enough stock";
    }
    header('location: ../vendor/index.php');
}