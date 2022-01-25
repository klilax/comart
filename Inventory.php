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
        $productId = Product::addProduct($inventory['product']);
        $sql = "INSERT INTO inventory (vendorId, productId, quantity ,price)
                VALUES (:vendorId, :productId, :quantity, :price)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId', $user->getId());
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':quantity', $inventory['quantity']);
        $stmt->bindParam(':price', $inventory['price']);
        $stmt->execute();
        echo $stmt->rowCount();
    }
    public static function getCurrentStock($user, $productName) {
        $productId = Product::getProductId($productName);
        $userId = $user->getId();
        if ($productId != -1) {
            $sql = "SELECT inventoryId, quantity FROM inventory WHERE vendorId = :userId AND productId = :productId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam('productId', $productId);
            $stmt->execute();
            if ($stmt->rowCount() != 0){
                return $stmt->fetch();
            }
        }
        return null;
    }
    public static function updateInventory($user, $productName, $quantity) {
        $stock = self::getCurrentStock($user, $productName);
        if (!is_null($stock)) {
            $sql = "UPDATE inventory SET quantity = :quantity WHERE inventoryId = :inventoryId";
            $stmt = self::$conn->prepare($sql);
            $updatedQuantity = $stock['quantity'] + $quantity;
            $inventoryId = $stock['inventoryId'];
            $stmt->bindParam(':quantity', $updatedQuantity);
            $stmt->bindParam("inventoryId", $inventoryId);
            $stmt->execute();
        } else {
            echo "Item is not in the Inventory";
        }
    }
    public function review($user, $rating, $review) {

    }
    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}
$conn = getConnection();
Inventory::setConnection($conn);
