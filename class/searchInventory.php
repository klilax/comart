<?php
require_once('Inventory.php');

if (isset($_GET['query'], $_GET['category'])){
    $query = $_GET['query'];
    $query = "%$query%";
    $category = $_GET['category'];
    $rows = Inventory::searchInventory($category, $query);
    if ($rows) {
        foreach ($rows as $row) {
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
            echo '<td><a href="../class/Cart.php?inventoryId='.$inventoryId.'&productName='.$encoded_name.'&price='.$price.'"><button type="button">Add to cart</button></a></td>';

        }
    } else {
        echo "<tr>";
        echo "<td colspan=5 style='color:red'>product not found </td>";
        echo "</tr>";
    }


}

