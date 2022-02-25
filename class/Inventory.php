<?php
//require('db.php');
require('User.php');
require('Category.php');
//require('Order.php');

class Inventory {
    private int $inventoryId;
    private int $vendorId;
    private int $categoryId;
    private string $productName;
    private int $quantity;
    private int $featured;
    private string $imgName;
    private string $description;
    private float $rating;
    private float $price;


    private static PDO $conn;

    public function __construct($inventoryId) {
        $this->inventoryId = $inventoryId;
        $this->fetchInventory($inventoryId);
    }

    public function getInventoryId(): int {
        return $this->inventoryId;
    }

    public function getVendorId(): int {
        return $this->vendorId;
    }

    public function getCategoryId(): int {
        return $this->categoryId;
    }

    public function getProductName(): string {
        return $this->productName;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function getFeatured(): int {
        return $this->featured;
    }

    public function getImgName(): string {
        return $this->imgName;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getRating(): float {
        return $this->rating;
    }

    public static function fetchImgName($categoryId): string {
        return Category::getCategoryDefaultImg(Category::getCategoryName($categoryId));
    }

    public static function fetchDescription($categoryId): string {
        return Category::getCategoryDefaultDescription(Category::getCategoryName($categoryId));
    }

    public function getPrice(): float {
        return $this->price;
    }

    private function fetchInventory($inventoryId) {
        $sql = "SELECT * FROM inventory WHERE inventoryId = :inventoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->categoryId = $result['categoryId'];
        $this->vendorId = $result['vendorId'];
        $this->productName = $result['inventoryName'];
        $this->quantity = $result['quantity'];
        $this->featured = $result['featured'];
        $this->price = $result['price'];
        $this->rating = $result['rating'];

        if (!is_null($result['imgName'])) {
            $this->imgName = $result['imgName'];
        } else {
            $this->imgName = $this->fetchImgName($this->categoryId);
        }
        if (!is_null($result['description'])) {
            $this->description = $result['description'];
        } else {
            $this->description = $this->fetchDescription($this->categoryId);
        }
    }

    public function addReview($buyerId, $rating, $review) {
        $sql = "INSERT INTO review (inventoryId, buyerId, rating, review) VALUES (:inventoryId, :buyerId, :rating, :review)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inventoryId', $this->inventoryId);
        $stmt->bindParam(':buyerId', $buyerId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review', $review);
        $stmt->execute();
    }

    public function getReviews(): bool|array {
        $sql = "SELECT firstname, lastname, rating, review
                FROM review AS r
                INNER JOIN buyer AS b ON b.userId = r.buyerId
                AND r.inventoryId = :inventoryId";

        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inventoryId', $this->inventoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVendorName(): string {
        $sql = "SELECT vendorName FROM vendor WHERE userId = :vendorId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId', $this->vendorId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['vendorName'];
    }

    /*----------------------------------- Static Methods -----------------------------------------------*/
    public static function vendorName($vendorId): string {
        $sql = "SELECT vendorName FROM vendor WHERE userId = :vendorId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId', $vendorId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['vendorName'];
    }

    public static function newInventory($productName, $categoryId, $price, $quantity, $imgName, $description): bool {
        $vendorId = $_SESSION['id'];
        if (self::isUnique($vendorId, $productName)) {
            $sql = "INSERT INTO inventory (inventoryName, categoryId, vendorId, quantity ,price , imgName, description)
            VALUES (:inventoryName, :categoryId, :vendorId, :quantity, :price, :imgName, :description)";

            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':inventoryName', $productName);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->bindParam(':vendorId', $vendorId);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':imgName', $imgName);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
            return true;
        }
        return false;
    }

    public static function isUnique($vendorId, $productName): bool {
        $sql = "SELECT * FROM inventory WHERE vendorId = :vendorId AND inventoryName = :productName";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId', $vendorId);
        $stmt->bindParam(':productName', $productName);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return false;
        }
        return true;
    }

    public static function fetchInventoryId($productName, $vendorId): int {
        $sql = "SELECT inventoryId FROM inventory WHERE inventoryName = :productName AND vendorId = :vendorId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':vendorId', $vendorId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['inventoryId'];
    }

    public static function getStock($inventoryId) {
        $sql = "SELECT quantity FROM inventory WHERE inventoryId = :inventoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['quantity'];
    }

    public static function getAllFeatured($category): bool|array {
        if ($category == 'all') {
            $sql = "SELECT * FROM inventory WHERE featured = 1";
        } else {
            $categoryId = Category::getCategoryId($category);
            $sql = "SELECT * FROM inventory WHERE categoryId = $categoryId AND featured = 1";
        }
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function fetchInventoryLog($vendorId, $isGRN): bool|array {
        $sql = "SELECT inventoryName, il.quantity, categoryName, date
                FROM inventorylog AS il 
                INNER JOIN inventory i on il.inventoryId = i.inventoryId
                INNER JOIN category c on i.categoryId = c.categoryId
                WHERE i.vendorId = :vendorId
                AND  il.incoming = :grn ";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId', $vendorId);
        $stmt->bindParam(':grn', $isGRN);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function logTransaction($inventoryId, $quantity, $isGRN) {
        $sql = "INSERT INTO inventorylog (inventoryId, quantity ,incoming) VALUES (:inventoryId, :quantity ,:isGRN)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':isGRN', $isGRN);
        $stmt->execute();
    }

    public static function getCurrentStock($inventoryId) {
        $sql = "SELECT quantity FROM inventory WHERE  inventoryId = :inventoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $row = $stmt->fetch();
            return $row['quantity'];
        }
        return -1;
    }

    public static function changeInventoryName($newName, $inventoryId) {
        $sql = "UPDATE inventory SET inventoryName = :newName WHERE inventoryId = :inventoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':newName', $newName);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->execute();
    }

    public static function changeInventoryPrice($newPrice, $inventoryId) {
        $sql = "UPDATE inventory SET price = :newPrice WHERE inventoryId = :inventoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':newPrice', $newPrice);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->execute();
    }

    public static function addStock($inventoryId, $quantity): bool {
        $stock = self::getCurrentStock($inventoryId);
        if ($stock != -1) {
            $sql = "UPDATE inventory SET quantity = :quantity WHERE inventoryId = :inventoryId";
            $stmt = self::$conn->prepare($sql);
            $updatedQuantity = $stock + $quantity;
            $stmt->bindParam(':quantity', $updatedQuantity);
            $stmt->bindParam("inventoryId", $inventoryId);
            $stmt->execute();
            self::logTransaction($inventoryId, $quantity, true);
            return true;
        }
        return false;
    }

    public static function issueStock($inventoryId, $quantity): bool {
        $stock = self::getCurrentStock($inventoryId);
        if ($stock >= $quantity) {
            $sql = "UPDATE inventory SET quantity = :quantity WHERE inventoryId = :inventoryId";
            $stmt = self::$conn->prepare($sql);
            $updatedQuantity = $stock - $quantity;
            $stmt->bindParam(':quantity', $updatedQuantity);
            $stmt->bindParam("inventoryId", $inventoryId);
            $stmt->execute();
            self::logTransaction($inventoryId, $quantity, 0);
            return true;
        }
        return false;
    }

    public static function fetchPrice($inventoryId) {
        $sql = "SELECT price FROM inventory WHERE inventoryId = :inventoryId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['price'];
    }

    public static function getVendorInventory($vendorId): bool|array {
        $sql = "SELECT * FROM inventory AS i
                INNER JOIN category AS c WHERE i.categoryId = c.categoryId 
                AND vendorId = :vendorId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':vendorId', $vendorId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllInventory($category): bool|array {
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

    public static function searchInventory($category, $query): bool|array {
        if ($category == 'all') {
            $sql = "SELECT * FROM inventory WHERE inventoryName LIKE :query";
        } else {
            $categoryId = Category::getCategoryId($category);
            $sql = "SELECT * FROM inventory WHERE categoryId = :categoryId AND inventoryName LIKE :query";
        }
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':query', $query);
        if ($category != 'all') {
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
