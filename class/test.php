<?php
//require('db.php');
//require('User.php');
//require('Product.php');
require ('Inventory.php');

$admin = ['username' => 'admin', 'password' => 'admin', 'role' => 'admin', 'firstName'=> 'admin', 'lastName'=> 'sudo'];
$vendor = ['username' => 'abcplc','email'=>'abcplc@abc.com' ,'password' => '1234', 'role' => 'vendor', 'vendorName'=> 'ABC PLC', 'tinNumber'=>000031245];
$buyer = ['username' => 'john','email'=>'john@gmail.com' ,'password' => '1234', 'role' => 'buyer', 'firstName'=> 'john', 'lastName'=> 'smith', 'tinNumber'=>000031245];
$buyer2 = ['username' => 'buyer','email'=>'buyer@gmail.com' ,'password' => '1234', 'role' => 'buyer', 'firstName'=> 'ali', 'lastName'=> 'smith', 'tinNumber'=>7931245];
//$test_user = new User();
//echo $test_user->getUsername();
//echo $test_user->isNewUser();
//$test_user->setEmail('admin@ad.com');

$productInfo['productName'] = 'RHS 30X30X2';
$productInfo['category'] = 'steel structure';
$inventory['product'] = $productInfo;
$inventory['quantity'] = 30;
$inventory['price'] = 1000;

//Product::addProduct($productInfo);

//User::register($buyer2);
//User::auth('john', '1234');
//User::auth('abcplc', '1234');
//echo "test123";

//Category::addCategory('cement');
//Inventory::newInventory(1, $inventory);
//Inventory::updateInventory(1, 'RHS 30X30X2',20);

