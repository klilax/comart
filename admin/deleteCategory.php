<?php
// require('../class/User.php');
// session_start();
// if (!isset($_SESSION['user'])) {
//     header('location: ../signin.php');
// }
// if ($_SESSION['role'] != 'admin') {
//     header('location: ../signin.php');
// }

// $categoryName = $_GET['id'];

// $sql = "DELETE FROM category WHERE categoryName = :categoryName";
// $stmt = $conn->prepare($sql);
// $stmt->bindParam(':categoryName', $categoryName);
// $stmt->execute();

// if ($stmt->rowCount() == 1) {
//     $message = "Category deleted.";
//     $opeStatus = 0;
// } else {
//     $message = "Error in deleting Category, Try again.";
//     $opeStatus = 1;
// }
// $_SESSION['message'] = $message;
// $_SESSION['opeStatus'] = $opeStatus;
// header("Location: index.php");
