<?php
//require('../class/User.php');
// require('../class/Inventory.php');
 require_once ('../class/Order.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../src/routes/auth/signin.php');
}
if ($_SESSION['role'] != 'vendor') {
    header('location: ../src/routes/auth/signin.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vendor</title>

    <!-- link for modal  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../js/bootstrap.js"></script>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="../css/slick.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="../css/style.css" />

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

</head>

<body>
    <header>
        <?php
        //<!-- TOP HEADER -->
        include('../src/components/topHeader.php');
        //<!-- /TOP HEADER -->

        //<!-- MAIN HEADER -->
        include('../src/components/mainHeader.php');
        //<!-- /MAIN HEADER -->
        ?>
    </header>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Inventory</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="addProduct-tab" data-bs-toggle="tab" data-bs-target="#addProduct" type="button" role="tab" aria-controls="addProduct" aria-selected="false">Add Product</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="updateProduct-tab" data-bs-toggle="tab" data-bs-target="#updateProduct" type="button" role="tab" aria-controls="updateProduct" aria-selected="false">Update Product</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="adjustStock-tab" data-bs-toggle="tab" data-bs-target="#adjustStock" type="button" role="tab" aria-controls="adjustStock" aria-selected="false">Adjust Stock</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="grn-tab" data-bs-toggle="tab" data-bs-target="#grn" type="button" role="tab" aria-controls="grn" aria-selected="false">GRN</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="issued-tab" data-bs-toggle="tab" data-bs-target="#issued" type="button" role="tab" aria-controls="issued" aria-selected="false">Issued</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Pending Order</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="feature-tab" data-bs-toggle="tab" data-bs-target="#feature" type="button" role="tab" aria-controls="feature" aria-selected="false">Sold Item</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="msg-tab" data-bs-toggle="tab" data-bs-target="#msg" type="button" role="tab" aria-controls="msg" aria-selected="false">Message</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="inventory" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $vendorId = $_SESSION['id'];
                            $count = 1;
                            foreach (Inventory::getVendorInventory($vendorId) as $row) {
                                $inventoryId = $row['inventoryId'];
                                echo "<tr>";
                                echo "<th scope='row'>$count</th>";
                                echo "<td>" .$row['inventoryName']. "</td>";
                                echo "<td>" .$row['categoryName']. "</td>";
                                echo "<td>" .number_format($row['price'], 2). "</td>";
                                echo "<td>" .$row['quantity']. "</td>";
                                echo "</tr>";
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="addProduct" role="tabpanel" aria-labelledby="addProduct-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <h1>Add product</h1>
                    <form action="../class/addInventory.php" method="POST">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name">
<!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $username_error; ?><!--</span>-->
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label><br>
                            <select class="form-select" id="category" name="category">
                                <?php
                                foreach (Category::getAllCategories() as $row) {
                                    echo "<option value='" . $row['categoryId'] . "'>" . $row['categoryName'] . "</option>";
                                }
                                ?>
                            </select>
                            <!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $username_error; ?><!--</span>-->
                        </div>
                        <div class="form-group mb-5">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="price">
<!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $password_error; ?><!--</span>-->
                        </div>
                        <div class="form-group mb-5">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control" id="qty" name="quantity" placeholder="quantity">
                            <!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $password_error; ?><!--</span>-->
                        </div>
                        <button type="submit" class="btn primary-btn rounded" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px">Add Product</button>
                    </form>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="updateProduct" role="tabpanel" aria-labelledby="updateProduct-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <h1>Update product</h1>
                    <form action="../class/addInventory.php" method="POST">
                        <div class="form-group">
                            <select class="form-select" id="adjustStockInventory" name="inventoryId">
                                <?php
                                foreach (Inventory::getVendorInventory($vendorId) as $row) {
                                    echo "<option value='" . $row['inventoryId'] . "'>" . $row['inventoryName'] . "</option>";
                                }
                                ?>
                            </select>
                            <!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $username_error; ?><!--</span>-->
                        </div>
                        <div class="form-group mb-5">
                            <label for="quantity">Change Name</label>
                            <input type="text" class="form-control" id="newName" name="newName" placeholder="Product Name">
                            <!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $password_error; ?><!--</span>-->
                        </div>
                        <div class="form-group mb-5">
                            <label for="price">Change Price</label>
                            <input type="text" class="form-control" id="newPrice" name="newPrice" placeholder="price">
                            <!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $password_error; ?><!--</span>-->
                        </div>

                        <button type="submit" class="btn primary-btn rounded" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px">Update Product</button>
                    </form>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="adjustStock" role="tabpanel" aria-labelledby="adjustStock-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <h1>Adjust Stock</h1>
<!--                    <form action="../class/addInventory.php" method="POST">-->
                        <div class="form-group">
                            <label for="AdjustStock">Adjust Stock</label><br>
                            <select class="form-select" id="adjustStockInventory" name="inventoryId">
                                <?php
                                foreach (Inventory::getVendorInventory($vendorId) as $row) {
                                    echo "<option value='" . $row['inventoryId'] . "'>" . $row['inventoryName'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mb-5">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control" id="adjustQuantity" name="quantity" placeholder="quantity">
                            <!--                            <span class="invalid-feedback" style="color: red;">--><?php //echo $password_error; ?><!--</span>-->
                        </div>
                            <div>
                            <button type="button" class="btn primary-btn rounded" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px" onclick="addStock()">Add Stock</button>
                            <button type="button" class="btn primary-btn rounded" style="background-color: darkred; border-radius: 5px; padding: 10px 20px" onclick="issueStock()">Issue Stock</button>
                        </div>
<!--                    </form>-->
                    <script>
                        function addStock() {
                            let inventoryId = document.getElementById("adjustStockInventory").value;
                            let quantity = document.getElementById("adjustQuantity").value;
                            window.location.href = "../class/addStock.php?inventoryId=" + inventoryId + "&quantity=" + quantity;
                        }
                        function issueStock() {
                            let inventoryId = document.getElementById("adjustStockInventory").value;
                            let quantity = document.getElementById("adjustQuantity").value;
                            window.location.href = "../class/issueStock.php?inventoryId=" + inventoryId + "&quantity=" + quantity;
                        }

                    </script>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="grn" role="tabpanel" aria-labelledby="grn-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="GRN" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        foreach (Inventory::fetchInventoryLog($vendorId, true) as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>$count</th>";
                            echo "<td>" . $row['inventoryName'] . "</td>";
                            echo "<td>" . $row['categoryName'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="issued" role="tabpanel" aria-labelledby="issued-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="ISSUED" class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        foreach (Inventory::fetchInventoryLog($vendorId, false) as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>$count</th>";
                            echo "<td>" . $row['inventoryName'] . "</td>";
                            echo "<td>" . $row['categoryName'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="order" class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Customer name</th>
                            <th scope="col">Tin No.</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">date</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach (Order::getVendorOrders($vendorId, false) as $row) {
                                echo "<tr>";
                                echo "<th scope='row'>$count</th>";
                                echo "<td>" .$row['firstname']. ' ' .$row['lastname'] . "</td>";
                                echo "<td>" .$row['tinNumber']. "</td>";
                                echo "<td>" .$row['inventoryName']. "</td>";
                                echo "<td>" .number_format($row['selling_price'], 2, '.', ','). "</td>";
                                echo "<td>" .$row['quantity']. "</td>";
                                echo "<td>" .number_format($row['selling_price'] * $row['quantity'], 2, '.', ','). "</td>";
                                echo "<td>" .$row['requestDate']. "</td>";
                                echo "</tr>";
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="feature" role="tabpanel" aria-labelledby="feature-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="sold" class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Customer name</th>
                            <th scope="col">Tin No.</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        foreach (Order::getVendorOrders($vendorId, true) as $row) {
                            echo "<tr>";
                            echo "<th scope='row'>$count</th>";
                            echo "<td>" .$row['firstname']. ' ' .$row['lastname'] . "</td>";
                            echo "<td>" .$row['tinNumber']. "</td>";
                            echo "<td>" .$row['inventoryName']. "</td>";
                            echo "<td>" .number_format($row['selling_price'], 2, '.', ','). "</td>";
                            echo "<td>" .$row['quantity']. "</td>";
                            echo "<td>" .number_format($row['selling_price'] * $row['quantity'], 2, '.', ','). "</td>";
                            echo "<td>" .$row['requestDate']. "</td>";
                            echo "</tr>";
                            $count++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="msg" role="tabpanel" aria-labelledby="msg-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="msg" class="table">
                        <thead>
                        <tr>
                            <h1>Message</h1>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <?php include('../src/components/footer.php'); ?>
    <script>
        $(document).ready(function() {
            $('#inventory, #GRN, #ISSUED ,#order, #sold').DataTable();
        });
    </script>
</body>

</html>