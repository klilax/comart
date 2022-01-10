<?php
class Product {
    private $productId;
    private $productName;
    private $category;
    private static $conn;



    public static function setConnection($conn) {
        self::$conn = $conn;
    }
}

?>