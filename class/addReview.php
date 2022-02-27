<?php

require_once('Inventory.php');
session_start();

if (isset($_SESSION['id'])) {

    if (isset($_GET['inventoryId'], $_GET['review'], $_GET['rating'])) {
        $buyerId = $_SESSION['id'];
        $inventoryId = $_GET['inventoryId'];
        // review = decodeURIComponent();
        $review = urldecode($_GET['review']);
        $rating = $_GET['rating'];

        $product = new Inventory($inventoryId);
        $product->addReview($buyerId, $rating, $review);

        header("Location: /comart/src/routes/product.php?inventoryId=" . $inventoryId);
    }
}
