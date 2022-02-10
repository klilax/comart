<?php
require('../class/User.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../signin.php');
}
if ($_SESSION['role'] != 'admin') {
    header('location: ../signin.php');
}

$messageId = $_GET['id'];
$status = -1;

$sql = "SELECT readStatus FROM message WHERE messageId = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $messageId);
$stmt->execute();
if ($stmt->rowCount()) {
    $row = $stmt->fetch(PDO::FETCH_NUM);
    $status = $row[0];

    if ($status == 0) {
        $sql = "UPDATE message SET readStatus = 1 WHERE messageId = :id";
        $stmt1 = $conn->prepare($sql);
        $stmt1->bindParam(':id', $messageId);
        $stmt1->execute();
    } else {
        $sql = "UPDATE message SET readStatus = 0 WHERE messageId = :id";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bindParam(':id', $messageId);
        $stmt2->execute();
    }
}

if ($status == 0) {
    if ($stmt1->rowCount() == 1) {
        $message = "Marked as read!";
        $opeStatus = 0;
    }
} else if ($status == 1) {
    if ($stmt2->rowCount() == 1) {
        $message = "Marked as unread!";
        $opeStatus = 0;
    }
} else {
    $message = "Error , Try again.";
    $opeStatus = 1;
}
$_SESSION['message'] = $message;
$_SESSION['opeStatus'] = $opeStatus;
header("Location: index.php");
