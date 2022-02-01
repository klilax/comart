<?php

class Category {
    private static PDO $conn;



    static function addCategory($categoryName) {
        $sql = "INSERT INTO category (categoryName) VALUE :category";

    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }

}
Category::setConnection(conn);