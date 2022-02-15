<?php
//require('../class/User.php');
// require('../class/Inventory.php');
require_once('../class/Order.php');
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

    <style>
        .form-select {
            font-size: 16px;
        }
        .dataTables_filter {
            float: right;
        }
        #adjustQuantity, #newName, #newPrice, #imgFile, #qty, #price, #productName {
            width: 500px;
        }
        #updateInventory, #adjustStockInventory, #category{
            width: 500px;
        }
        table button {
            margin: 5px 10px;
        }

    </style>

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

    <?php
    if (isset($_SESSION['message'])) {
        if ($_SESSION['opeStatus'] == 0) {
            echo "<div class='alert alert-success row w-25 mx-auto' role='alert'>";
            echo  $_SESSION['message'];
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning row w-25 mx-auto' role='alert'>";
            echo  $_SESSION['message'];
            echo "</div>";
        }
        unset($_SESSION['message']);
        unset($_SESSION['opeStatus']);
    }
    ?>

    <?php
    if (isset($_SESSION['adjust_success_1'])){
        echo "<div class='alert alert-success row w-25 mx-auto' role='alert'>";
        echo  $_SESSION['adjust_success_1'];
        echo "</div>";
    } elseif (isset($_SESSION['adjust_error_1'])) {
        echo "<div class='alert alert-warning row w-25 mx-auto' role='alert'>";
        echo $_SESSION['adjust_error_1'];
        echo "</div>";
    }
    unset($_SESSION['adjust_success_1']);
    unset($_SESSION['adjust_error_1']);
    ?>

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
                                echo "<td>" . $row['inventoryName'] . "</td>";
                                echo "<td>" . $row['categoryName'] . "</td>";
                                echo "<td>" . number_format($row['price'], 2) . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
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
                    <form action="../class/addInventory.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name" onkeyup="validateProductName(); validateForm()">
                            <p id="addProductError1" style="color: darkred"></p>
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

                        </div>
                        <div class="form-group mb-5">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="price" onkeyup="validatePriceAdd(); validateForm()">
                            <p id="addProductError2" style="color: darkred"></p>
                        </div>
                        <div class="form-group mb-5">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control" id="qty" name="quantity" placeholder="quantity" onkeyup="validateQuantityAdd(); validateForm()">
                            <p id="addProductError3" style="color: darkred"></p>
                        </div>
                        <div class="form-group mb-5">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="imgFile" name="file" placeholder="image">

                        </div>
                        <button type="submit" class="btn primary-btn rounded" id="addButton" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px" disabled>Add Product</button>
                    </form>
                </div>
            </section>
        </div>
        <script>

            function validatePriceAdd() {
                let price = document.getElementById("price").value;
                if (isNaN(price) || price === "") {
                    document.getElementById("addProductError2").innerHTML = "Please enter a valid price";
                    return false;
                } else if (price <= 0) {
                    document.getElementById("addProductError2").innerHTML = "Please enter a number greater than 0";
                    return false;
                } else {
                    document.getElementById("addProductError2").innerHTML = "";
                    return true;
                }
            }

            function validateQuantityAdd() {
                let quantity = document.getElementById("qty").value;
                if (isNaN(quantity) || quantity === "") {
                    document.getElementById("addProductError3").innerHTML = "Please enter a valid quantity";
                    return false;
                } else if (quantity <= 0) {
                    document.getElementById("addProductError3").innerHTML = "Please enter a number greater than 0";
                    return false;
                } else {
                    document.getElementById("addProductError3").innerHTML = "";
                    return true;
                }
            }

            function validateProductName() {
                let productName = document.getElementById("productName").value;
                if (productName.length === 0) {
                    document.getElementById("addProductError1").innerHTML = "Please enter a valid product name";
                    return false;
                } else {
                    document.getElementById("addProductError1").innerHTML = "";
                    return true;
                }
            }

            function validateForm() {
                let productName = document.getElementById("productName").value;
                let quantity = document.getElementById("qty").value;
                let price = document.getElementById("price").value;
                if (productName.length === 0) {
                    document.getElementById("addButton").disabled = true;
                } else if(isNaN(quantity) || quantity === "" || quantity <= 0){
                    document.getElementById("addButton").disabled = true;
                } else document.getElementById("addButton").disabled = isNaN(price) || price === "" || price <= 0;
            }
        </script>
        <div class="tab-pane fade" id="updateProduct" role="tabpanel" aria-labelledby="updateProduct-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <h1>Update product</h1>
<!--                    <form action="" method="POST">-->
                        <div class="form-group">
                            <select class="form-select" id="updateInventory" name="updateInventory">
                                <?php
                                foreach (Inventory::getVendorInventory($vendorId) as $row) {
                                    echo "<option value='" . $row['inventoryId'] . "'>" . $row['inventoryName'] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group mb-5">
                            <label for="quantity">Change Name</label>
                            <input type="text" class="form-control" id="newName" name="newName" placeholder="New product Name">
                            <p id="updateError1" style="color: darkred"></p>
                        </div>
                        <div class="form-group mb-5">
                            <label for="price">Change Price</label>
                            <input type="text" class="form-control" id="newPrice" name="newPrice" placeholder="price" onkeyup="validatePrice()">
                            <p id="updateError2" style="color: darkred"></p>

                        </div>
                        <div>
                            <button type="button" id="submit_updateProduct" class="btn primary-btn rounded" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px" onclick="updateInventory()">Update Product</button>
                        </div>
<!--                    </form>-->
                </div>
            </section>
            <script>
                function updateInventory() {
                    let name = document.getElementById("newName").value;
                    let price = document.getElementById("newPrice").value;
                    let inventoryId = document.getElementById("updateInventory").value;
                    if (name === "" && price === "") {
                        document.getElementById("updateError1").innerHTML = "Please fill one of the two fields";
                        document.getElementById("updateError2").innerHTML = "Please fill one of the two fields";
                    } else {
                        document.getElementById('updateError1').innerHTML = "";
                        document.getElementById('updateError2').innerHTML = "";
                        if (!isNaN(price) && price > 0) {
                            window.location.href = "../class/updateInventory.php?newName=" + name + "&newPrice=" + price + "&inventoryId=" + inventoryId;
                        } else {
                            document.getElementById("updateError2").innerHTML = "Please enter a valid price";
                        }
                    }
                }

                function validatePrice() {
                    let quantity = document.getElementById("newPrice").value;
                    if (isNaN(quantity)) {
                        document.getElementById("updateError2").innerHTML = "Please enter a valid price";
                    } else {
                        document.getElementById("updateError2").innerHTML = "";
                    }
                }

            </script>
        </div>
        <div class="tab-pane fade" id="adjustStock" role="tabpanel" aria-labelledby="adjustStock-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <h1>Adjust Stock</h1>
                    <div class="form-group">
                        <label for="adjustStockInventory">Adjust Stock</label><br>
                        <select class="form-select" id="adjustStockInventory" name="adjustStockInventory">
                            <?php
                            foreach (Inventory::getVendorInventory($vendorId) as $row) {
                                echo "<option value='" . $row['inventoryId'] . "'>" . $row['inventoryName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-5">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" id="adjustQuantity" name="quantity" placeholder="quantity" onkeyup="validateQuantity()">
                        <p id="adjustError" style="color: darkred"></p>
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
                            if (isNaN(quantity)) {
                                document.getElementById("adjustError").innerHTML = "Quantity must be a number";
                            }else if(quantity <= 0){
                                document.getElementById("adjustError").innerHTML = "Quantity must be greater than 0";
                            } else {
                                window.location.href = "../class/addStock.php?inventoryId=" + inventoryId + "&quantity=" + quantity;
                            }
                        }

                        function issueStock() {
                            let inventoryId = document.getElementById("adjustStockInventory").value;
                            let quantity = document.getElementById("adjustQuantity").value;
                            if (isNaN(quantity)) {
                                document.getElementById("adjustError").innerHTML = "Quantity must be a number";
                            }else if(quantity <= 0){
                                document.getElementById("adjustError").innerHTML = "Quantity must be greater than 0";
                            } else {
                                window.location.href = "../class/issueStock.php?inventoryId=" + inventoryId + "&quantity=" + quantity;
                            }

                        }

                        function validateQuantity() {
                            let quantity = document.getElementById("adjustQuantity").value;
                            if (isNaN(quantity)) {
                                document.getElementById("adjustError").innerHTML = "Quantity must be a number";
                            } else {
                                document.getElementById("adjustError").innerHTML = "";
                            }
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
                                echo "<td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>";
                                echo "<td>" . $row['tinNumber'] . "</td>";
                                echo "<td>" . $row['inventoryName'] . "</td>";
                                echo "<td>" . number_format($row['selling_price'], 2, '.', ',') . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . number_format($row['selling_price'] * $row['quantity'], 2, '.', ',') . "</td>";
                                echo "<td>" . $row['requestDate'] . "</td>";
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
                                echo "<td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>";
                                echo "<td>" . $row['tinNumber'] . "</td>";
                                echo "<td>" . $row['inventoryName'] . "</td>";
                                echo "<td>" . number_format($row['selling_price'], 2, '.', ',') . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . number_format($row['selling_price'] * $row['quantity'], 2, '.', ',') . "</td>";
                                echo "<td>" . $row['requestDate'] . "</td>";
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
                    <button type='button' class='btn btn-primary contactA' data-toggle='modal' data-target='#contactAdmin' value='$id' style="margin: 20px 50px; margin-left: 70%;  width: 180px;">Contact an Admin</button>
                    <table id=" msgT" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">From</th>
                                <th scope="col">Email</th>
                                <th scope="col">messageTitle</th>
                                <th scope="col" style='display: none;'>messageBody</th>
                                <th scope="col">Status</th>
                                <th scope="col" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $vendorId = $_SESSION['id'];
                            $sql = 'SELECT messageId, username, email, messageTitle, messageBody, readStatus FROM message
                            INNER JOIN user on message.senderId = user.id WHERE receiverId = :receiverId ORDER BY readStatus';
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':receiverId', $vendorId);
                            $stmt->execute();
                            $count = 1;
                            if ($stmt->rowCount()) {
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    $id = $row[0];
                                    echo "<tr>";
                                    echo "<th scope='row'>$count</th>";
                                    echo "<td id='senderName$id'>$row[1]</td>";
                                    echo "<td>$row[2]</td>";
                                    echo "<td id='messageTitle$id'>$row[3]</td>";
                                    echo "<td id='messageB$id' style='display: none;'>$row[4]</td>";
                                    if ($row[5] == 1) {
                                        echo "<td><span class='badge bg-success'>Read</span></td>";
                                        echo "<td colspan='3'>";
                                        echo "<a href='../admin/read.php?id=$id'><button type='button' class='btn btn-warning'>Mark as unread</button></a>";
                                    } else if ($row[5] == 0) {
                                        echo "<td><span class='badge bg-danger'>Unread</span></td>";
                                        echo "<td colspan='3'>";
                                        echo "<a href='../admin/read.php?id=$id'><button type='button' class='btn btn-success'>Mark as read</button></a>";
                                    }
                                    echo "<button type='button' class='btn btn-secondary view' data-toggle='modal' data-target='#viewMessage' value = '$id'>View</button>";
                                    echo "<button type='button' class='btn btn-danger deleteMsg' data-toggle='modal' data-target='#deleteMessage' value='$id'>Delete</button></td>";

                                    echo "</tr>";
                                    $count++;
                                }
                            } else {
                                // no data
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <?php include('../src/components/footer.php');

    echo '<div class="modal fade" id="viewMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  style="margin-top: 100px;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle" style="margin-top: 50px; margin-left: 35%;">View Message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></a>
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                      <div class="mb-3">
                      <label for="sender-name" class="col-form-label">From:</label>
                      <input type="text" class="form-control" id="sender-name" disabled>
                      </div>
                        <div class="mb-3">
                           <label for="title-name" class="col-form-label">Message Title:</label>
                          <input type="text" class="form-control" id="title-name" disabled>
                       </div>
                        <div class="mb-3">
                          <label for="message-body" class="col-form-label">Message Body:</label>
                          <textarea class="form-control" id="message-body" rows="4" disabled></textarea>
            </div>
            </div>
            <div class="modal-footer">';
    echo "<a id='markRead'><button type='button' class='btn btn-secondary'>Close</button></a>";
    echo ' </div>
        </div>
    </div>
  </div> ';

    echo
    '<div class="modal fade" id="deleteMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Delete Message</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  </div>
                                  <div class="modal-body">
                                      Are you sure you want to permanently delete this message?
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
    echo "<a id='deleteM'><button type='button' class='btn btn-danger'>Delete</button></a>";
    echo '</div>
                              </div>
                          </div>
                      </div> ';

    echo '<div class="modal fade" id="contactAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  style="margin-top: 100px;">
                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send message to an admin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          </div>
                          <div class="modal-body">
                            <form id="contactAdminForm">
                              <div class="mb-3">
                                           <label for="messageTitle" class="col-form-label">Message Title:</label>
                                          <input type="text" class="form-control" id="messageTitle" name="messageTitle">
                                       </div>
                              <div class="mb-3">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="message-text" name="message-text" rows="3"></textarea>
                              </div>
                              <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" id="sendM" value="Send Message">
                          </div>
                            </form>
                          </div>
                          
                        </div>
                      </div>
                    </div>';

    ?>
    <script>
        $(document).ready(function() {
            $('#inventory, #GRN, #ISSUED ,#order, #sold, #msgT').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {

            // View Message
            $(document).on('click', '.view', function() {
                var id = $(this).val();
                var sender = $('#senderName' + id).text();
                var title = $('#messageTitle' + id).text();
                var message = $('#messageB' + id).text();

                // $('#viewMessage').modal('show');
                $('#sender-name').val(sender);
                $('#title-name').val(title);
                $('#message-body').val(message);

                $messageId = $(this).val();
                var viewMsgLink = '../admin/view.php?id=' + $messageId;
                document.getElementById("markRead").setAttribute("href", viewMsgLink);
            });

            // Delete Message
            $(document).on('click', '.deleteMsg', function() {
                $msgId = $(this).val();

                var deleteMsgLink = '../admin/deleteMsg.php?id=' + $msgId;
                document.getElementById("deleteM").setAttribute("href", deleteMsgLink);
            });

            // Contact Admin // Send message
            $(document).on('click', '.contactA', function() {
                <?php
                $_SESSION['vendorId'] = $vendorId;
                ?>
            });

            $(document).ready(function() {
                $("#contactAdminForm").submit(function(event) {
                    submitContactAForm();
                    return false;
                });
            });

            function submitContactAForm() {
                $.ajax({
                    type: "POST",
                    url: "../admin/sendMessage.php",
                    cache: false,
                    data: $('form#contactAdminForm').serialize(),
                    success: function(response) {
                        $("body").html(response)
                        $("#contactAdmin").modal('hide');
                    },
                    error: function() {
                        alert("Error");
                    }
                });
            }

        });
        function validateNumber() {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
    </script>
</body>

</html>