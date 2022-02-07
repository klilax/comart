<?php
require('../class/User.php');
// require('../class/Inventory.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../signin.php');
}
if ($_SESSION['role'] != 'vendor') {
    header('location: ../signin.php');
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
    <?php
    // $vendor = unserialize($_SESSION['user']);
    //        echo $vendor->getUsername();
    // $productInfo['productName'] = 'RHS 30X30X2';
    // $productInfo['category'] = 'steel structure';
    // $inventory['product'] = $productInfo;
    // $inventory['quantity'] = 12;
    // $inventory['price'] = 1700;
    // echo $inventory['product']['productName'];
    //        echo Product::addProduct($productInfo);
    // Inventory::newInventory($vendor, $inventory);

    //        $item = Inventory::getItem($vendor, 'RHS 30X30X1');
    //        echo $item['quantity'];
    //        echo "<br>";
    //        echo $item['inventoryId'];
    //        Inventory::updateInventory($vendor, 'RHS 30X30X1', 7);
    ?>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">GRN</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">Inventory</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Some Tab</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Another Tab</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="feature-tab" data-bs-toggle="tab" data-bs-target="#feature" type="button" role="tab" aria-controls="feature" aria-selected="false">Message</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="info" class="table">
                        <thead>
                            <tr>
                                <h1>Hello Tab1</h1>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="vendor" class="table">
                        <thead>
                            <tr>
                                <h1>Hello Tab2</h1>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="buyer" class="table">
                        <thead>
                            <tr>
                                <h1>Hello Tab3</h1>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-50 mx-auto text-secondary d-flex icon-boxes">
                    <table id="category" class="table">
                        <thead>
                            <tr>
                                <h1>Hello Tab4</h1>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="feature" role="tabpanel" aria-labelledby="feature-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="feature" class="table">
                        <thead>
                            <tr>
                                <h1>Hello Tab5</h1>
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
            $('#vendor, #buyer, #category').DataTable();
        });
    </script>
</body>

</html>