<?php
session_start();
require('../class/User.php');
if ($_SESSION['role'] == 'admin') {
    $name = strip_tags($_POST['recipient-name']);
}
$title = strip_tags($_POST['messageTitle']);
$message = strip_tags($_POST['message-text']);

if ($_SESSION['role'] == 'admin') {
    $adminId = $_SESSION['adminId'];
    $sql = "SELECT id FROM user where username = :username";
    $stmt1 = $conn->prepare($sql);
    $stmt1->bindParam(':username', $name);
} else if ($_SESSION['role'] == 'vendor') {
    $vendorId = $_SESSION['vendorId'];
    $sql = "SELECT id FROM user where role = :role";
    $stmt1 = $conn->prepare($sql);
    $role = 'admin';
    $stmt1->bindParam(':role', $role);
}

$stmt1->execute();
if ($stmt1->rowCount() == 1) {
    $row = $stmt1->fetch();
    $receiverId = $row[0];

    $sql = "INSERT INTO message (senderId, receiverId, messageBody, messageTitle) 
                values (:senderId, :receiverId, :messageBody, :messageTitle)";
    $stmt = $conn->prepare($sql);
    if ($_SESSION['role'] == 'admin') {
        $stmt->bindParam(':senderId', $adminId);
    } else if ($_SESSION['role'] == 'vendor') {
        $stmt->bindParam(':senderId', $vendorId);
    }
    $stmt->bindParam(':receiverId', $receiverId);
    $stmt->bindParam(':messageBody', $message);
    $stmt->bindParam(':messageTitle', $title);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $message = "Message Sent!";
        $opeStatus = 0;
    } else {
        $message = "Error in sending Message, Try again!";
        $opeStatus = 1;
    }
    $_SESSION['message'] = $message;
    $_SESSION['opeStatus'] = $opeStatus;
} else {
    $message = "Error, No recipient found with that name";
    $opeStatus = 1;
    $_SESSION['message'] = $message;
    $_SESSION['opeStatus'] = $opeStatus;
}

if ($_SESSION['role'] == 'admin') {
    header("Location: index.php");
}
if ($_SESSION['role'] == 'vendor') {
    header("Location: ../vendor/index.php");
}
