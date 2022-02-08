<?php
require('../class/User.php');
require('../class/Category.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('location: ../signin.php');
}
if ($_SESSION['role'] != 'admin') {
    header('location: ../signin.php');
}

$categoryName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName'];
    if (!empty($_POST['categoryName'])) {
        Category::addCategory($categoryName);
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comart | Admin Dashboard</title>

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
        const fun = function(event) {
            event.preventDefault();
        }
        const form = document.getElementById('formId');
        form.addEventListner("submit", fun);
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
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
                <b>Info</b>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">
                <b>View Vendors</b>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><b>View Buyers</b></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false"><b>View Category</b></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="feature-tab" data-bs-toggle="tab" data-bs-target="#feature" type="button" role="tab" aria-controls="feature" aria-selected="false"><b>View Featured</b></button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <section class=" bg" style="min-height: 70vh;">
                <h2 style="text-align: center; margin: 20px;">Accounts Summary</h2>
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="info" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalA = 0;
                            $totalV = 0;
                            $totalB = 0;

                            $sql = 'SELECT * FROM user WHERE role = "admin"';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            echo "<tr>";
                            echo "<td>Administrator</td>";
                            echo "<td>Active</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                            $totalA += $count;

                            $sql = 'SELECT * FROM user WHERE role = "vendor" AND status = 1';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            echo "<tr>";
                            echo "<td>Vendor</td>";
                            echo "<td>Active</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                            $totalV += $count;

                            $sql = 'SELECT * FROM user WHERE role = "vendor" AND status = 2';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            echo "<tr>";
                            echo "<td>Vendor</td>";
                            echo "<td>Suspended</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                            $totalV += $count;

                            $sql = 'SELECT * FROM user WHERE role = "vendor" AND status = 0';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            echo "<tr>";
                            echo "<td>Vendor</td>";
                            echo "<td>Waiting list</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                            $totalV += $count;

                            $sql = 'SELECT * FROM user WHERE role = "buyer" AND status = 1';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            echo "<tr>";
                            echo "<td>Buyer</td>";
                            echo "<td>Active</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                            $totalB += $count;

                            $sql = 'SELECT * FROM user WHERE role = "buyer" AND status = 2';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            echo "<tr>";
                            echo "<td>Buyer</td>";
                            echo "<td>Suspended</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                            $totalB += $count;
                            ?>
                        </tbody>
                    </table>
                    <?php
                    echo '<div class="summary" style="margin-top: 20px; text-align: center;">';
                    echo "<h4>Total Admins : $totalA</h4>";
                    echo "<h4>Total Vendors : $totalV</h4>";
                    echo "<h4>Total Buyers : $totalB</h4>";
                    echo '</div>';
                    ?>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="vendor" class="table">
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
                                    } else if ($row[6] == 0) {
                                        echo "<td><span class='badge bg-warning'>Waiting for Approval</span></td>";
                                        echo "<td>";
                                        echo "<a href='acceptAcc.php?id=$id'><button type='button' class='btn btn-light'>Accept</button></a>";
                                    } else if ($row[6] == 2) {
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
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="buyer" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
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
                                    echo "<td>$row[1] $row[2]</td>";
                                    echo "<td>$row[3]</td>";
                                    echo "<td>$row[4]</td>";
                                    echo "<td>$row[5]</td>";
                                    echo "<td>$row[6]</td>";
                                    if ($row[7] == 1) {
                                        echo "<td><span class='badge bg-success'>Active</span></td>";
                                        echo "<td>";
                                        echo "<a href='suspendAcc.php?id=$id'><button type='button' class='btn btn-light'>Suspend</button></a>";
                                    } else if ($row[7] == 0) {
                                        echo "<td><span class='badge bg-warning'>Waiting for Approval</span></td>";
                                        echo "<td>";
                                        echo "<a href='acceptAcc.php?id=$id'><button type='button' class='btn btn-light'>Accept</button></a>";
                                    } else if ($row[7] == 2) {
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
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-50 mx-auto text-secondary d-flex icon-boxes">

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="formId">
                        <input style="margin-left: 30%; margin: 20px 50px;   width: 180px; float:left;" class="form-control" type="text" placeholder="Category Name" name="categoryName" id="queryV">
                        <input type='submit' class='btn btn-secondary' style="margin: 20px 5px; width: 180px; height: 35px;" value="Add New Category">
                    </form>
                    <table id="category" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $rows = Category::getAllCategories();
                            if ($rows) {
                                foreach ($rows as $row) {
                                    echo "<tr>";
                                    echo "<th scope='row'>$count</th>";
                                    echo "<td>" . $row['categoryName'] . "</td>";
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
        <div class="tab-pane fade" id="feature" role="tabpanel" aria-labelledby="feature-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="feature" class="table">
                        <thead>
                            <tr>
                                <h1>Heloo Feature</h1>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

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

    <script>
        $(document).ready(function() {
            $('#vendor, #buyer, #category').DataTable();
        });
    </script>

</body>

</html>