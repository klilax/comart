<?php
//require('../class/User.php');
require('../class/Cart.php');
require('../class/Inventory.php');
//session_start();
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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>shop</title>
</head>
<body>

    <h1>Shopping</h1>
    <?php
        $buyer = unserialize($_SESSION['user']);
        $buyerId = $buyer->getId();

//        Cart::removeAllFromCart($buyerId);
//        Cart::addToCart($buyerId,1,'RHS30X30x2' ,780.50, 7);
//        Cart::addToCart($buyerId,7,'Rebar #3' ,550,14);
//        Cart::addToCart($buyerId,13, 8);
//        Cart::removeFromCart($buyerId, 1);

//        echo $buyer->getUsername()."<br>";
//        foreach ($_SESSION['cart'][$buyerId] as $key => $value){
//            echo $key.'<br>';
//            echo $_SESSION['cart'][$buyerId][$key]['name'].'<br>';
//            echo $_SESSION['cart'][$buyerId][$key]['quantity'].'<br>';
//            echo $value.'<br>';
//        }

    ?>
    <input type="text" id="searchItem" onkeyup="searchItem()">
    <a href="../src/routes/checkout.php"><button>view cart</button></a>

    <table class="table table-dark table-striped" id="Tablecontent">
        <thead>
            <th>#</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Available Stock</th>
        </thead>
        <tbody>
            <?php
                foreach (Inventory::getAllInventory('all') as $row) {
                    $inventoryId = $row['inventoryId'];
                    $name = $row['inventoryName'];
                    $price = $row['price'];
                    $qty = $row['quantity'];
                    echo '<tr>';
                    echo '<td>'.$inventoryId.'</td>';
                    echo '<td>'.$name.'</td>';
                    echo '<td>'.$price.'</td>';
                    echo '<td>'.$qty.'</td>';
                    $encoded_name = urlencode($name);
//                    echo '<td><a href="../class/Cart.php?inventoryId=$inventoryId&productName=$name&price=$price"><button type="button">Add to cart</button></a></td>';
                    echo '<td><a href="../class/Cart.php?inventoryId='.$inventoryId.'&productName='.$encoded_name.'&price='.$price.'"><button type="button">Add to cart</button></a></td>';

                }
            ?>
        </tbody>
    </table>
</body>
<script>



    function searchItem() {
        let query = document.getElementById("searchItem").value;
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("Tablecontent").innerHTML = this.responseText;
            }
        };
        ajax.open("GET", "../class/searchInventory.php?query=" + query + "&category=all", true);
        ajax.send();
        console.log(query);
    }
</script>
</html>
