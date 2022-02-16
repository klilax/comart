<?php

require_once('Inventory.php');
session_start();

define('MB', 1048576);

if (isset($_SESSION['id'], $_POST['productName'], $_POST['quantity'], $_POST['category'], $_POST['price'])) {

    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $imgName = '';

    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileInputError = '';
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1 * MB) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $filePath = '../img/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $filePath);
                    $imgName = $fileNameNew;
                    // header('Location: /comart/vendor/index.php?uploaded');
                } else {
                    $_SESSION['adjust_error_1'] = 'File is too large. Maximum file size is 1MB.';
                }
            } else {
                $_SESSION['adjust_error_1'] = 'There was an error uploading your file.';
            }
        } else {
            $_SESSION['adjust_error_1'] = 'You can not upload files of this type.';
        }
    }

    if (Inventory::newInventory($productName, $category, $price, $quantity, $imgName)) {
        $vendorId = $_SESSION['id'];
        $inventoryId = Inventory::fetchInventoryId($productName, $vendorId);
        Inventory::logTransaction($inventoryId, $quantity,true);
        $_SESSION['adjust_success_1'] = "New Inventory successfully added";
    } else {
        $_SESSION['adjust_error_1'] = "Product already exists";
    }
    header('location: ../vendor/index.php');
}
