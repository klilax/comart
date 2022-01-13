<?php
require('db.php');
require('User.php');
require('Product.php');


class Inventory {
    private $inventoryId;
    private $vendorId;
    private $productId;
    private static PDO $conn;



    public static function newInventory($user, $inventory) {
        echo $inventory['price'].'<br>';
        echo $inventory['quantity'].'<br>';
        $productId = Product::addProduct($inventory['product']);
        $userId = $user->getId();
        $sql = "INSERT INTO inventory (vendorId, productId, quantity ,price)
                VALUES (:vendorId, :productId, :quantity, :price)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId', $userId);
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':quantity', $inventory['quantity']);
        $stmt->bindParam(':price', $inventory['price']);
        $stmt->execute();
        echo $stmt->rowCount();
    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}
$conn = getConnection();
Inventory::setConnection($conn);
