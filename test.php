<?php
require('db.php');
require('User.php');
require('product.php');
$admin = ['username' => 'admin', 'password' => 'admin', 'role' => 'admin', 'firstName'=> 'admin', 'lastName'=> 'sudo'];
$vendor = ['username' => 'abcplc','email'=>'abcplc@abc.com' ,'password' => '1234', 'role' => 'vendor', 'vendorName'=> 'ABC PLC', 'tinNumber'=>000031245];
$buyer = ['username' => 'john','email'=>'john@gmail.com' ,'password' => '1234', 'role' => 'buyer', 'firstName'=> 'john', 'lastName'=> 'smith', 'tinNumber'=>000031245];
$buyer2 = ['username' => 'buyer','email'=>'buyer@gmail.com' ,'password' => '1234', 'role' => 'buyer', 'firstName'=> 'ali', 'lastName'=> 'smith', 'tinNumber'=>7931245];
//$test_user = new User();
//echo $test_user->getUsername();
//echo $test_user->isNewUser();
//$test_user->setEmail('admin@ad.com');


//User::register($buyer2);
User::auth('john', '1234');
