<?php
    require('../class/User.php');
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: ../signin.php');
    }
    if ($_SESSION['role'] != 'admin') {
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
        <title>Comart | Admin Dashboard</title>

        <!-- link for modal  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        

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

        <style>
            th,
            td {
                text-align: center;
            }
            table button {
            margin: 0px 10px;
            }
            #titleh3 {
                text-align: center;
                margin-top: 30px;
            }
        
        </style>

        <script>
            function searchVendors() {
                let query = document.getElementById("queryV").value;
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("vendorTable").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "searchV.php?query=" + query, true);
                xhttp.send();
            }

            function searchBuyers() {
                let query = document.getElementById("queryB").value;
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("buyerTable").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "searchB.php?query=" + query, true);
                xhttp.send();
            }
        </script>

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
            echo "<div class='alert alert-success row w-75 mx-auto' role='alert'>";
            echo  $_SESSION['message'];
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning row w-75 mx-auto' role='alert'>";
            echo  $_SESSION['message'];
            echo "</div>";
        }
        unset($_SESSION['message']);
        unset($_SESSION['opeStatus']);
    }
    ?>

<h3 id="titleh3">Vendors</h3>
<input style="margin-left: 72.5%; margin-bottom: 20px; align-items: flex-end; width: 15%;" class="form-control" type="search" placeholder="Search for vendors"
 aria-label="Search" id='queryV' onkeyup="searchVendors()">
    <section class=" bg" style="min-height: 20vh;" id='vendorTable'>
        <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Vendor Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Tin Number</th>
                        <th scope="col">Reg. Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $adminId = $_SESSION['id'];
                    $sql = 'SELECT id, vendorName, email, role, tinNumber, registrationDate, status FROM vendor INNER JOIN user u on vendor.userId = u.id WHERE 1 ORDER BY vendorName';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $count = 1;
                    if ($stmt->rowCount()) {
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            $id = $row[0];
                            echo "<tr>";
                            echo "<th scope='row'>$count</th>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[4]</td>";
                            echo "<td>$row[5]</td>";
                            if ($row[6] == 1) {
                                echo "<td><span class='badge bg-success'>Active</span></td>";
                                echo "<td>";
                                echo "<a href='suspendAcc.php?id=$id'><button type='button' class='btn btn-light'>Suspend</button></a>";
                            } else if ($row[6] == 0){
                                echo "<td><span class='badge bg-warning'>Waiting for Approval</span></td>";
                                echo "<td>";
                                echo "<a href='acceptAcc.php?id=$id'><button type='button' class='btn btn-light'>Accept</button></a>";
                            }  else if ($row[6] == 2) {
                                echo "<td><span class='badge bg-danger'>Suspended</span></td>";
                                echo "<td>";
                                echo "<a href='activateAcc.php?id=$id'><button type='button' class='btn btn-light'>Activate</button></a>";
                            }
                            echo "<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteModal'>Delete</button></td>";

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

    <h3 id="titleh3">Buyers</h3>
    <input style="margin-left: 72.5%; margin-bottom: 20px; align-items: flex-end; width: 15%;" class="form-control" type="search" placeholder="Search for buyers"
    aria-label="Search" id='queryB' onkeyup="searchBuyers()">
    <section class=" bg" style="min-height: 20vh;" id='buyerTable'>
        <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Tin Number</th>
                        <th scope="col">Reg. Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $adminId = $_SESSION['id'];
                    $sql = 'SELECT id, firstName, lastName, email, role, tinNumber, registrationDate, status FROM buyer INNER JOIN user u on buyer.userId = u.id WHERE 1 ORDER BY firstName';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $count = 1;
                    if ($stmt->rowCount()) {
                        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                            $id = $row[0];
                            echo "<tr>";
                            echo "<th scope='row'>$count</th>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[4]</td>";
                            echo "<td>$row[5]</td>";
                            echo "<td>$row[6]</td>";
                            if ($row[7] == 1) {
                                echo "<td><span class='badge bg-success'>Active</span></td>";
                                echo "<td>";
                                echo "<a href='suspendAcc.php?id=$id'><button type='button' class='btn btn-light'>Suspend</button></a>";
                            } else if ($row[7] == 0){
                                echo "<td><span class='badge bg-warning'>Waiting for Approval</span></td>";
                                echo "<td>";
                                echo "<a href='acceptAcc.php?id=$id'><button type='button' class='btn btn-light'>Accept</button></a>";
                            }  else if ($row[7] == 2) {
                                echo "<td><span class='badge bg-danger'>Suspended</span></td>";
                                echo "<td>";
                                echo "<a href='activateAcc.php?id=$id'><button type='button' class='btn btn-light'>Activate</button></a>";
                            }
                            echo "<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteModal'>Delete</button></td>";

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

        <?php 
            include('../src/components/footer.php');

            echo
            '<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Account</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to permanently delete this account?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
            echo "<a href='deleteAcc.php?id=$id'><button type='button' class='btn btn-danger'>Delete</button></a>";
            echo '</div>
                                </div>
                            </div>
                        </div> ';
        ?>
                    
        
            
    </body>
</html>