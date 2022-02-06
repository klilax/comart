<?php
    require('../class/User.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: ../signin.php');
    }
    if ($_SESSION['role'] != 'admin') {
        header('location: ../signin.php');
    }
    
    $userId = $_GET['id'];

    $sql = "UPDATE user SET status = 1 WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    if($stmt->rowCount()==1)
    {
        $message = "Account Request Accepted!";
        $opeStatus = 0;
    }
    else {
        $message = "Error in Accepting Request, Try again.";
        $opeStatus = 1;
    }
    $_SESSION['message'] = $message;
    $_SESSION['opeStatus'] = $opeStatus;
    header("Location: index.php");
?>