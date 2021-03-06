<?php
require_once('db.php');

class Category
{
    private static PDO $conn;

    static function isUnique($categoryName)
    {
        $sql = "SELECT categoryName from category where categoryName = :categoryName";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return true;
        }
        return false;
    }

    static function getCategoryId($categoryName)
    {
        $sql = "SELECT categoryId from category where categoryName = :categoryName";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->execute();
        $categoryId = -1;
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $categoryId = $row['categoryId'];
        }
        return $categoryId;
    }

    static function getCategoryName($categoryId)
    {
        $sql = "SELECT categoryName from category where categoryId = :categoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $categoryName = $row['categoryName'];
        }
        return $categoryName;
    }

    static function getCategoryDefaultImg($categoryName)
    {
        $sql = "SELECT defaultImgName from category where categoryName = :categoryName";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->execute();
        $defaultImgName = '';
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $defaultImgName = $row['defaultImgName'];
        }
        return $defaultImgName;
    }

    static function getCategoryDefaultDescription($categoryName)
    {
        $sql = "SELECT defaultDescription from category where categoryName = :categoryName";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->execute();
        $defaultDescription = '';
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $defaultDescription = $row['defaultDescription'];
        }
        return $defaultDescription;
    }

    static function getAllCategories()
    {
        $sql = "SELECT * from category";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static function addCategory($categoryName, $categoryDesc, $defaultImgName)
    {
        if (self::isUnique($categoryName)) {
            $sql = "INSERT INTO category (categoryName, defaultImgName, defaultDescription)  VALUES (:categoryName, :defaultImgName, :defaultDescription)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':categoryName', $categoryName);
            $stmt->bindParam(':defaultImgName', $defaultImgName);
            $stmt->bindParam(':defaultDescription', $categoryDesc);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    public static function setConnection($conn)
    {
        self::$conn = $conn;
    }
}

Category::setConnection($conn);
