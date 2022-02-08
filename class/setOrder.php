<?php
require_once ('Order.php');
session_start();

if(isset($_SESSION['id'])) {
    $buyerId = $_SESSION['id'];
    if (isset($_SESSION['cartId'])){
        $cartId = $_SESSION['cartId'];
        Order::checkOut($buyerId, $cartId);
        unset($_SESSION['cartId']);
        unset($_SESSION['cart'][$cartId]);
        header("Location: ../index.php");
    }
}