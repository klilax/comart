<?php
//require('db.php');
require('User.php');
require('Product.php');
//require('Order.php');

class Inventory {
    private $inventoryId;
    private $vendorId;
    private $productId;
    private static PDO $conn;



    public static function newInventory($user, $inventory) {
        $vendorId = $user->getId();
        $productId = Product::getProductId($inventory['product']['productName']);
        if ($productId == -1) {
            $productId = Product::addProduct($inventory['product']);
        }

        $sql = "INSERT INTO inventory (vendorId, productId, quantity ,price)
                VALUES (:vendorId, :productId, :quantity, :price)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId',$vendorId);
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
        $sql = "INSERT INTO review (inventoryId, buyerId, rating, review) VALUES (:inventoryId, :buyerId, :rating, :review)";
        $buyerId = $user->getId();
        if (Order::checkStatus($user, $this->inventoryId)) {
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':inventoryId', $this->inventoryId);
            $stmt->bindParam(':buyerId', $buyerId);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':review', $review);
            $stmt->execute();
        } else {
            echo "You have not placed an order for this item";
        }

    }
    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

Inventory::setConnection($conn);
