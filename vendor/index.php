<?php
require('../User.php');
session_start();
if (!isset($_SESSION['vendor'])) {
    header('location: ../signin.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vendor</title>
</head>
<body>
    <h1>Vendor Page</h1>
    <?php
        $vendor = unserialize($_SESSION['user']);
        echo $vendor->getUsername();
    ?>
</body>
</html>