<?php
require_once ('db.php');

$conn = getConnection();

function averageRating($id) {
    global $conn;
    $sql = "SELECT AVG(rating) FROM review WHERE inventoryId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function updateRating($id) {
    global $conn;
    $rating = averageRating($id);
    $sql = "UPDATE inventory SET rating = :rating WHERE inventoryId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':rating', $rating);
    $stmt->execute();
}

function updateInventoryRating() {
    global $conn;
    $sql = "SELECT inventoryId FROM inventory";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        updateRating($row['inventoryId']);
    }
}