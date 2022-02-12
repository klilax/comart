<?php
session_start();
require('../class/User.php');

$newCategoryName = strip_tags($_POST['category-name']);
$oldCategoryName = strip_tags($_POST['oldcategory-name']);

if (!empty($oldCategoryName) && !empty($newCategoryName)) {
    $sql = "SELECT categoryId FROM category WHERE categoryName = :categoryName";
    $stmt1 = $conn->prepare($sql);
    $stmt1->bindParam(':categoryName', $oldCategoryName);
    $stmt1->execute();
    if ($stmt1->rowCount() == 1) {
        $row = $stmt1->fetch();
        $categoryId = $row[0];

        $sql = "UPDATE category SET categoryName = '$newCategoryName' WHERE categoryId = :categoryId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $message = "Category Updated!";
            $opeStatus = 0;
            $_SESSION['message'] = $message;
            $_SESSION['opeStatus'] = $opeStatus;
        } else {
            $message = "Error Updating Category, Try again!";
            $opeStatus = 1;
            $_SESSION['message'] = $message;
            $_SESSION['opeStatus'] = $opeStatus;
        }
    } else {
        $message = "Old name not found!";
        $opeStatus = 1;
        $_SESSION['message'] = $message;
        $_SESSION['opeStatus'] = $opeStatus;
    }
} else {
    $message = "Please fill the fields properly!";
    $opeStatus = 1;
    $_SESSION['message'] = $message;
    $_SESSION['opeStatus'] = $opeStatus;
}



header("Location: index.php");
