<?php
require('../class/User.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../signin.php');
}
if ($_SESSION['role'] != 'admin') {
    header('location: ../signin.php');
}

$inventoryId = $_GET['id'];
$feature = -1;

$sql = "SELECT featured FROM inventory WHERE inventoryId = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $inventoryId);
$stmt->execute();
if ($stmt->rowCount()) {
    $row = $stmt->fetch(PDO::FETCH_NUM);
    $feature = $row[0];

    if ($feature == 0) {
        $sql = "UPDATE inventory SET featured = 1 WHERE inventoryId = :id";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bindParam(':id', $inventoryId);
        $stmt1->execute();
    } else {
        $sql = "UPDATE inventory SET featured = 0 WHERE inventoryId = :id";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bindParam(':id', $inventoryId);
        $stmt2->execute();
    }
}

if ($feature == 0) {
    if ($stmt1->rowCount() == 1) {
        $message = "Product Featured!";
        $opeStatus = 0;
    }
} else if ($feature == 1) {
    if ($stmt2->rowCount() == 1) {
        $message = "Product Un-Featured!";
        $opeStatus = 0;
    }
} else {
    $message = "Error , Try again.";
    $opeStatus = 1;
}
$_SESSION['message'] = $message;
$_SESSION['opeStatus'] = $opeStatus;
header("Location: index.php");
