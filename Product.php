<?php
class Product {
    private $productId;
    private $productName;
    private $category;
    private static $conn;


    public function __construct($productInfo) {
        $this->productId = $productInfo['productId'];
        $this->productName = $productInfo['productName'];
        $this->category = $productInfo['category'];
    }

    public static function addProduct($productInfo) {

    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

Product::setConnection(getConnection());
?>