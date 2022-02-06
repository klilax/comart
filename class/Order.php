<?php
require_once ('db.php');
session_start();
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
//    static function setOrderDetail($buyerId, $orderId, $cartItem) {
//        $sql =
//    }

//    static function getStatus(){
//       $sql = "SELECT paymentStatus FROM `order` WHERE buyerId = :buyerId AND ";
//    }
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
        $sql = "INSERT INTO orderdetail (orderId, inventoryId, quantity) VALUES (:orderId, :inventoryId, :quantity)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

    static function checkOut($buyerId, $cartId) {
        $orderId = self::setOrder($buyerId, $cartId);
        if (isset($_SESSION['cartId'])) {
            foreach ($_SESSION['cart'][$cartId] as $key => $value) {
                $qty = $_SESSION['cart'][$cartId][$key]['quantity'];
                $inventoryId = $_SESSION['cart'][$cartId][$key]['inventoryId'];
                self::setOrderDetail($orderId, $inventoryId, $qty);
            }
        }
    }


    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

Order::SetConnection(getConnection());


if(isset($_SESSION['id'])) {
    $buyerId = $_SESSION['id'];
    if (isset($_SESSION['cartId'])){
        $cartId = $_SESSION['cartId'];
        Order::checkOut($buyerId, $cartId);
        unset($_SESSION['cartId']);
        unset($_SESSION['cart'][$cartId]);
        header("Location: ../shop/index.php");
    }
}



