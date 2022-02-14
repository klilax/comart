<?php
require_once ('Inventory.php');
session_start();

if (isset($_GET['inventoryId'], $_GET['quantity'])) {
    $inventoryId = $_GET['inventoryId'];
    $quantity = $_GET['quantity'];
    echo $inventoryId;
    echo $quantity;
    Inventory::addStock($inventoryId, $quantity);
    $_SESSION['adjust_success_1'] = "Added stock successfully";
    header('location: ../vendor/index.php');
}


?>

