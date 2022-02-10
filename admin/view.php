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
$sql = "SELECT readStatus FROM message WHERE messageId = :id";
$stmt1 = $conn->prepare($sql);
$stmt1->bindParam(':id', $messageId);
$stmt1->execute();
if ($stmt1->rowCount() == 1) {
    $row = $stmt1->fetch();
    $status = $row[0];
    if ($status == 0) {
        $sql = "UPDATE message SET readStatus = 1 WHERE messageId = :id";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bindParam(':id', $messageId);
        $stmt2->execute();
        // if ($stmt2->rowCount() == 1) {
        //     $message = "Mark as read!";
        //     $opeStatus = 0;
        // } else {
        //     $message = "Error, try again";
        //     $opeStatus = 1;
        // }
        // $_SESSION['message'] = $message;
        // $_SESSION['opeStatus'] = $opeStatus;
    }
}

header("Location: index.php");



header("Location: index.php");
