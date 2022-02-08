<?php

session_start();

class Cart {
    static function getCartId() {
        $file_read = fopen("cartId.txt", "r") or die("unable to open file");
        $id = fgets($file_read);
        fclose($file_read);

        $file_write = fopen("cartId.txt", "w") or die("unable to open file");
        fwrite($file_write, $id + 1);
        fclose($file_write);
        return $id;
    }
    static function initCart() {
        $cartId = self::getCartId();
        $_SESSION['cartId'] = $cartId;
        $_SESSION['cart'][$cartId] = array();
    }


    static function addToCart($inventoryId, $productName, $price, $quantity = 1) {
        if (!isset($_SESSION['cartId'])) {
            self::initCart();
        }
        $cartId = $_SESSION['cartId'];
        if (isset($_SESSION['cart'][$cartId][$inventoryId])) {
            $_SESSION['cart'][$cartId][$inventoryId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$cartId][$inventoryId]['quantity'] = $quantity;
        }
        $_SESSION['cart'][$cartId][$inventoryId]['name'] = $productName;
        $_SESSION['cart'][$cartId][$inventoryId]['price'] = $price;
        $_SESSION['cart'][$cartId][$inventoryId]['inventoryId'] = $inventoryId;
    }

    static function removeFromCart($inventoryId) {
        if (isset($_SESSION['cartId'])) {
            $cartId = $_SESSION['cartId'];
            unset($_SESSION['cart'][$cartId][$inventoryId]);
        }
    }

    static function removeAllFromCart() {
        if (isset($_SESSION['cartId'])) {
            $cartId = $_SESSION['cartId'];
            unset($_SESSION['cart'][$cartId]);
        }
    }

}
if (isset($_SESSION['id'])) {
    if (isset($_GET['inventoryId'], $_GET['productName'], $_GET['price'])) {
        $buyerId = $_SESSION['id'];
        $inventoryId = $_GET['inventoryId'];
        $name = urldecode($_GET['productName']);
        $price = $_GET['price'];
        Cart::addToCart($inventoryId, $name, $price);
        header("Location: ../index.php");
    }
}

//echo Cart::getCartId();