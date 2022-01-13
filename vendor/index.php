<?php
require('../Inventory.php');
session_start();
if (!isset($_SESSION['vendor'])) {
    header('location: ../signin.php');
}
if ($_SESSION['role'] != 'vendor') {
    header('location: ../signin.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vendor</title>
</head>
<body>
    <h1>Vendor Page</h1>
    <?php
        $vendor = unserialize($_SESSION['user']);
        echo $vendor->getUsername();
        $productInfo['productName'] = 'RHS 30X30X1';
        $productInfo['category'] = 'steel structure';
        $inventory['product'] = $productInfo;
        $inventory['quantity'] = 50;
        $inventory['price'] = 700.50;
//        echo Product::addProduct($productInfo);
        Inventory::newInventory($vendor, $inventory);
    ?>
</body>
</html>