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
        $_SESSION['cart']['count'] = 0;
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
            $_SESSION['cart']['count'] += 1;
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

    if (isset($_GET['inventoryId'], $_GET['productName'], $_GET['price'], $_GET['quantity'])) {
        $buyerId = $_SESSION['id'];
        $inventoryId = $_GET['inventoryId'];
        $name = urldecode($_GET['productName']);
        $price = $_GET['price'];
        $quantity = $_GET['quantity'];
        Cart::addToCart($inventoryId, $name, $price, $quantity);
        header("Location: /src/routes/product.php?inventoryId=" . $inventoryId);
    } elseif (isset($_GET['inventoryId'], $_GET['productName'], $_GET['price'])) {
        $buyerId = $_SESSION['id'];
        $inventoryId = $_GET['inventoryId'];
        $name = urldecode($_GET['productName']);
        $price = $_GET['price'];
        Cart::addToCart($inventoryId, $name, $price);
        header("Location: ../index.php");
    }

}
