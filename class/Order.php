<?php
//require_once ('db.php');
require_once ('Inventory.php');

class Order{
    private static PDO $conn;

    static function getBuyerId($orderId){
        $sql = "SELECT buyerId FROM `order` WHERE orderId = :orderId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(":orderId", $orderId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['buyerId'];
        } else {
            return -1;
        }
    }

    static function checkStatus($buyerId, $inventoryId): bool
    {
        //inner join order and orderdetail to be edited later
        $sql = "SELECT * FROM `order` INNER JOIN `orderdetail` ON `order`.orderId = `orderdetail`.orderId 
                WHERE `order`.buyerId = :buyerId AND `orderdetail`.inventoryId = :inventoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(":buyerId", $buyerId);
        $stmt->bindParam(":inventoryId", $inventoryId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($row['status'] == '1') {
                return true;
            }
        }
        return false;
    }
    static function getOrderId($cartId){
        $sql = "SELECT orderId FROM `order` WHERE cartId = :cartId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(":cartId", $cartId);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['orderId'];
    }
    static function setOrder($buyerId, $cartId) {
        $sql = "INSERT INTO `order` (buyerId, cartId) VALUE (:buyerId, :cartId)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':buyerId', $buyerId);
        $stmt->bindParam(':cartId', $cartId);
        $stmt->execute();
        return self::getOrderId($cartId);
    }
    static function setOrderDetail($orderId, $inventoryId, $quantity) {
        $price = Inventory::fetchPrice($inventoryId);
        $sql = "INSERT INTO orderdetail (orderId, inventoryId, quantity, selling_price) VALUES (:orderId, :inventoryId, :quantity, :price)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
    }
    static function calculateTotal($orderId) {
        $sql = "SELECT SUM(selling_price * quantity) AS total FROM orderdetail WHERE orderId = :orderId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    static function updateTotalPrice($orderId) {
        $total = self::calculateTotal($orderId);
        $sql = "UPDATE `order` SET totalPayment = :total WHERE orderId = :orderId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':total', $total);
        $stmt->execute();
    }

    static function checkOut($buyerId, $cartId) {
        $orderId = self::setOrder($buyerId, $cartId);
        if (isset($_SESSION['cartId'])) {
            foreach ($_SESSION['cart'][$cartId] as $key => $value) {
                $qty = $_SESSION['cart'][$cartId][$key]['quantity'];
                $inventoryId = $_SESSION['cart'][$cartId][$key]['inventoryId'];
                if (Inventory::getStock($inventoryId) >= $qty) {
                    self::setOrderDetail($orderId, $inventoryId, $qty);
                }
            }
            self::updateTotalPrice($orderId);
        }
    }

    public static function getVendorOrders($vendorId, $isPayed): bool|array
    {
        $sql = "SELECT firstname, lastname, tinNumber, i.inventoryName, selling_price, od.quantity, o.requestDate
                FROM `order` AS o
                INNER JOIN orderdetail AS od ON o.orderId = od.orderId
                INNER JOIN inventory AS i ON od.inventoryId = i.inventoryId
                INNER JOIN buyer b on o.buyerId = b.userId
                WHERE i.vendorId = :vendorId ";
        if ($isPayed) {
            $sql = $sql .'AND o.paymentStatus = 1';
        } else {
            $sql = $sql .'AND o.paymentStatus = 0';
        }
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(":vendorId", $vendorId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

Order::SetConnection(getConnection());




