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

$sql = "DELETE FROM message WHERE messageId = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $messageId);
$stmt->execute();

if ($stmt->rowCount() == 1) {
    $message = "Message deleted.";
    $opeStatus = 0;
} else {
    $message = "Error in deleting Message, Try again.";
    $opeStatus = 1;
}
$_SESSION['message'] = $message;
$_SESSION['opeStatus'] = $opeStatus;
header("Location: index.php");
