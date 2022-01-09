<?php
//require('db.php');
require('User.php');
//$userDetail = ['id' => 2, 'username' => 'klilax', 'password' => '1234', 'role' => 'admin', 'status' => 1];
$vendor = ['username' => 'abcplc','email'=>'abcplc@abc.com' ,'password' => '1234', 'role' => 'vendor', 'vendorName'=> 'ABC PLC', 'tinNumber'=>000031245];
$buyer = ['username' => 'john','email'=>'john@gmail.com' ,'password' => '1234', 'role' => 'buyer', 'firstName'=> 'john', 'lastName'=> 'smith', 'tinNumber'=>000031245];
$test_user = new User();
//echo $test_user->getUsername();
//echo $test_user->isNewUser();
//$test_user->setEmail('admin@ad.com');

//$test_user->save();
//echo User::fetchId('klilx');
//User::save($buyer);
User::saveBuyerInfo($buyer);
