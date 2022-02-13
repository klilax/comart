<?php

require_once('Inventory.php');
session_start();

define('MB', 1048576);

if (isset($_SESSION['id'], $_POST['productName'], $_POST['quantity'], $_POST['category'], $_POST['price'])) {

    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    // $imgName = Category::getCategoryDefaultImg($category);
    $imgName = '';

    $file = $_FILES['file'];

    $fileInputError = '';

    $fileName = $file['name'];

    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    // $fileType = $file['type'];

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
                echo 'File is too large. Maximum file size is 1MB.';
            }
        } else {
            echo 'There was an error uploading your file.';
        }
    } else {
        echo 'You can not upload files of this type.';
    }

    echo $productName . '<br>';
    echo $quantity . '<br>';
    echo $category . '<br>';
    echo $price . '<br>';
    echo $imgName . '<br>';

    // Inventory::newInventory($productName, $category, $price, $quantity);
    Inventory::newInventory($productName, $category, $price, $quantity, $imgName);
    header('location: ../vendor/index.php');
}
