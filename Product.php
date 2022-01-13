<?php
class Product {
    private $productId;
    private $productName;
    private $category;
    private static PDO $conn;



    public function __construct($productInfo) {
        $this->productId = $productInfo['productId'];
        $this->productName = $productInfo['productName'];
        $this->category = $productInfo['category'];
    }

    public static function getProductInfo($productName) {
        $sql = "SELECT productId FROM product WHERE productName = :productName LIMIT 1";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':productName', $productName);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $row = $stmt->fetch();
            return $row['productId'];
        } else {
            return -1;
        }
    }

    public static function addProduct($productInfo) {
        $productId = self::getProductInfo($productInfo['productName']);
        if ($productId != -1) {
            return $productId;
        } else {
            $sql = "INSERT INTO product ( productName, category) VALUES 
                (:productName, :category)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':productName', $productInfo['productName']);
            $stmt->bindParam(':category', $productInfo['category']);
            $stmt->execute();
        }
        return self::getProductInfo($productInfo['productName']);
    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

Product::setConnection(getConnection());
?>