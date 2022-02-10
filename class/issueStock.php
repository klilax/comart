<?php
require_once ('Inventory.php');
session_start();

if (isset($_GET['inventoryId'], $_GET['quantity'])) {
    $inventoryId = $_GET['inventoryId'];
    $quantity = $_GET['quantity'];
    Inventory::issueStock($inventoryId, $quantity);
    header('location: ../vendor/index.php');
}