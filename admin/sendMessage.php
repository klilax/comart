<?php
session_start();
require('../class/User.php');

$name = strip_tags($_POST['recipient-name']);
$title = strip_tags($_POST['messageTitle']);
$message = strip_tags($_POST['message-text']);
$adminId = $_SESSION['adminId'];

$sql = "SELECT id FROM user where username = :username";
$stmt1 = $conn->prepare($sql);
$stmt1->bindParam(':username', $name);
$stmt1->execute();
$row = $stmt1->fetch();
$receiverId = $row[0];

$sql = "INSERT INTO message (senderId, receiverId, messageBody, messageTitle) 
                values (:senderId, :receiverId, :messageBody, :messageTitle)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':senderId', $adminId);
$stmt->bindParam(':receiverId', $receiverId);
$stmt->bindParam(':messageBody', $message);
$stmt->bindParam(':messageTitle', $title);
$stmt->execute();
if ($stmt->rowCount() == 1) {
    $message = "Message Sent!";
    $opeStatus = 0;
} else {
    $message = "Error in sending Message";
    $opeStatus = 1;
}
$_SESSION['message'] = $message;
$_SESSION['opeStatus'] = $opeStatus;
header("Location: index.php");
