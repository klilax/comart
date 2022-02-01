<?php
require_once('db.php');

class Category {
    private static PDO $conn;

    static function isUnique($categoryName) {
        $sql = "SELECT categoryName from category where categoryName = :categoryName";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return true;
        }
        return false;
    }

    static function addCategory($categoryName) {
        if (self::isUnique($categoryName)) {
            $sql = "INSERT INTO category (categoryName)  VALUES (:categoryName)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':categoryName', $categoryName);
            $stmt->execute();
        }
    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }

}

Category::setConnection($conn);