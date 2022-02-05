<?php
//require('db.php');
require('User.php');
require('Category.php');
//require('Order.php');

class Inventory {
    private $inventoryId;
    private $vendorId;
    private $productId;
    private static PDO $conn;



    public static function newInventory($user, $inventory) {
        $vendorId = $user->getId();
//        $vendorId = $user;
        $categoryId = Category::getCategoryId($inventory['product']['category']);
//        $productId = Product::getProductId($inventory['product']['productName']);
        if ($categoryId != -1) {
            $sql = "INSERT INTO inventory (inventoryName, categoryId, vendorId, quantity ,price)
                VALUES (:inventoryName, :categoryId, :vendorId, :quantity, :price)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':inventoryName', $inventory['product']['productName']);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':vendorId',$vendorId);
            $stmt->bindParam(':quantity', $inventory['quantity']);
            $stmt->bindParam(':price', $inventory['price']);
            $stmt->execute();
        }
    }

    public static function getCurrentStock($user, $productName) {
        $userId = $user->getId();
//        $userId = $user;
        $sql = "SELECT inventoryId, quantity FROM inventory WHERE vendorId = :userId AND inventoryName = :inventoryName";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':inventoryName', $productName);
        $stmt->execute();
        if ($stmt->rowCount() != 0){
            return $stmt->fetch();
        }

        return null;
    }

    public function changeInventoryName() {

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

    public static function getAllInventory($category): bool|array
    {
        if ($category == 'all') {
            $sql = "SELECT * FROM inventory";
        } else {
            $categoryId = Category::getCategoryId($category);
            $sql = "SELECT * FROM inventory WHERE categoryId = $categoryId";
        }
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function searchInventory($category, $query): bool|array
    {
        if ($category == 'all') {
            $sql = "SELECT * FROM inventory WHERE inventoryName LIKE :query";
        } else {
            $categoryId = Category::getCategoryId($category);
            $sql = "SELECT * FROM inventory WHERE categoryId = :categoryId AND inventoryName LIKE :query";
        }
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':query', $query);
        if ($category != 'all'){
            $stmt->bindParam(':categoryId', $categoryId);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

Inventory::setConnection($conn);
