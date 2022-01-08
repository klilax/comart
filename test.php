<?php
//require('db.php');
require('User.php');
//$userDetail = ['id' => 2, 'username' => 'klilax', 'password' => '1234', 'role' => 'admin', 'status' => 1];
$userDetail = ['username' => 'klilax', 'password' => '1234', 'role' => 'vendor'];
$test_user = new User($userDetail);
echo $test_user->getUsername();
echo $test_user->isNewUser();
$test_user->setEmail('admin@ad.com');

$test_user->save();