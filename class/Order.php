<?php

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

    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

Order::SetConnection(getConnection());