<?php

session_start();

class Cart {
    static function initCart($userId){
        $_SESSION['cart'][$userId] = array();
    }


    static function addToCart($userId, $inventoryId, $productName, $price, $quantity=1) {
        if (!isset($_SESSION['cart'][$userId])) {
            self::initCart($userId);
        }
        if (isset($_SESSION['cart'][$userId][$inventoryId])) {
            $_SESSION['cart'][$userId][$inventoryId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$userId][$inventoryId]['quantity']= $quantity;
        }
        $_SESSION['cart'][$userId][$inventoryId]['name'] = $productName;
        $_SESSION['cart'][$userId][$inventoryId]['price'] = $price;
    }

    static function removeFromCart($userId, $inventoryId) {
        unset($_SESSION['cart'][$userId][$inventoryId]);
    }

    static function removeAllFromCart($userId) {
        unset($_SESSION['cart'][$userId]);
    }

    static function viewAllCart($userId) {
        if (isset($_SESSION['cart'][$userId])) {
            foreach ($_SESSION['cart'][$userId] as $inventoryId => $quantity) {
                echo "<tr>";
                echo "<td>".$quantity['name']."</td>";
                echo "<td>".$quantity."</td>";
                echo "<td><a href='removeFromCart.php?userId=".$userId."&inventoryId=".$inventoryId."'>Remove</a></td>";
                echo "</tr>";
            }
        }
    }
}
$buyerId = $_SESSION['id'];
if (isset($_GET['inventoryId'], $_GET['productName'], $_GET['price'])) {
    $inventoryId = $_GET['inventoryId'];
    $name = urldecode($_GET['productName']);
    $price = $_GET['price'];
    Cart::addToCart($buyerId, $inventoryId, $name, $price);
    header("Location: ../shop/index.php");
}

