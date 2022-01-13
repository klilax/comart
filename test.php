<?php
require('db.php');
require('User.php');
require('product.php');
//$userDetail = ['id' => 2, 'username' => 'klilax', 'password' => '1234', 'role' => 'admin', 'status' => 1];
$vendor = ['username' => 'abcplc','email'=>'abcplc@abc.com' ,'password' => '1234', 'role' => 'vendor', 'vendorName'=> 'ABC PLC', 'tinNumber'=>000031245];
$buyer = ['username' => 'john','email'=>'john@gmail.com' ,'password' => '1234', 'role' => 'shop', 'firstName'=> 'john', 'lastName'=> 'smith', 'tinNumber'=>000031245];
//$test_user = new User();
//echo $test_user->getUsername();
//echo $test_user->isNewUser();
//$test_user->setEmail('admin@ad.com');


//User::register($vendor);
User::auth('abcplc', '1234');
