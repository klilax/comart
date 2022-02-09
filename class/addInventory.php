<?php

require_once ('Inventory.php');
session_start();

if (isset($_SESSION['id'], $_POST['productName'],$_POST['quantity'],$_POST['category'],$_POST['price'])) {
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    echo $productName . '<br>';
    echo $quantity . '<br>';
    echo $category . '<br>';
    echo $price . '<br>';
    Inventory::newInventory($productName, $category, $price, $quantity);
    header('location: ../vendor/index.php');
}
