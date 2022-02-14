<?php
require_once ('Inventory.php');
session_start();
$nameChanged = false;
$priceChanged = false;
if (isset($_GET['inventoryId'], $_GET['newName'])) {
    $inventoryId = $_GET['inventoryId'];
    $name = $_GET['newName'];
    if (!empty($name)) {
        $nameChanged = true;
        Inventory::changeInventoryName($name, $inventoryId);
    }
}

if (isset($_GET['inventoryId'], $_GET['newPrice'])) {
    $inventoryId = $_GET['inventoryId'];
    $price = $_GET['newPrice'];
    if (!empty($price) && is_numeric($price)) {
        $priceChanged = true;
        Inventory::changeInventoryPrice($price, $inventoryId);
    } else {
        unset($_GET['inventoryId']);
        unset($_GET['newPrice']);
    }
}

if ($nameChanged && $priceChanged) {
    $_SESSION['adjust_success_1'] = "Product name and price updated successfully";
} elseif ($nameChanged) {
    $_SESSION['adjust_success_1'] = "Product name updated successfully";
} elseif ($priceChanged) {
    $_SESSION['adjust_success_1'] = "Product price updated successfully";
}

header('location: ../vendor/index.php');