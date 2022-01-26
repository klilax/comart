<?php
require('../User.php');
session_start();
if (!isset($_SESSION['user'])) {
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
    <title>shop</title>
</head>
<body>
    <h1>Shopping</h1>
    <?php
        $buyer = unserialize($_SESSION['user']);
        echo $buyer->getUsername()."<br>";
    ?>
    <input type="text" onkeyup="searchItem()">
</body>
<script>
    const ajax = new XMLHttpRequest();


    function searchItem() {
        console.log('hello');
    }
</script>
</html>
