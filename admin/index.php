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
            margin: 5px 10px;
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
            <button class="nav-link" id="vendor-tab" data-bs-toggle="tab" data-bs-target="#vendor" type="button" role="tab" aria-controls="vendor" aria-selected="false">
                <b>View Vendors</b>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="buyer-tab" data-bs-toggle="tab" data-bs-target="#buyer" type="button" role="tab" aria-controls="buyer" aria-selected="false">
                <b>View Buyers</b></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="category-tab" data-bs-toggle="tab" data-bs-target="#category" type="button" role="tab" aria-controls="category" aria-selected="false">
                <b>View Category</b></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="feature-tab" data-bs-toggle="tab" data-bs-target="#feature" type="button" role="tab" aria-controls="feature" aria-selected="false">
                <b>View Featured</b></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="message-tab" data-bs-toggle="tab" data-bs-target="#message" type="button" role="tab" aria-controls="message" aria-selected="false">
                <b>View Message</b></button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <section class=" bg" style="min-height: 70vh;">
                <h2 style="text-align: center; margin: 20px;">Accounts Summary</h2>
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="infoT" class="table">
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

                            $total = $totalA + $totalB + $totalV;
                            ?>
                        </tbody>
                    </table>
                    <?php
                    echo '<div class="summary" style="margin-top: 20px; text-align: center;">';
                    echo "<h3>Total Admins : $totalA</h3>";
                    echo "<h3>Total Vendors : $totalV</h3>";
                    echo "<h3>Total Buyers : $totalB</h3>";
                    echo "<h3>All Users : $total</h3>";
                    echo '</div>';
                    ?>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="vendor" role="tabpanel" aria-labelledby="vendor-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="vendorT" class="table">
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
                                <th scope="col">Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $adminId = $_SESSION['id'];
                            $sql = 'SELECT id, vendorName, email, role, tinNumber, registrationDate, status FROM vendor INNER JOIN user on vendor.userId = user.id WHERE 1 ORDER BY vendorName';
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $count = 1;
                            if ($stmt->rowCount()) {
                                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                                    $id = $row[0];
                                    echo "<tr>";
                                    echo "<th scope='row'>$count</th>";
                                    echo "<td id='receiverName$id'>$row[1]</td>";
                                    echo "<td>$row[2]</td>";
                                    echo "<td>$row[3]</td>";
                                    echo "<td>$row[4]</td>";
                                    echo "<td>$row[5]</td>";
                                    if ($row[6] == 1) {
                                        echo "<td><span class='badge bg-success'>Active</span></td>";
                                        echo "<td>";
                                        echo "<a href='suspendAcc.php?id=$id'><button type='button' class='btn btn-warning'>Suspend</button></a>";
                                    } else if ($row[6] == 0) {
                                        echo "<td><span class='badge bg-info'>Waiting for Approval</span></td>";
                                        echo "<td>";
                                        echo "<a href='acceptAcc.php?id=$id'><button type='button' class='btn btn-success'>Accept</button></a>";
                                    } else if ($row[6] == 2) {
                                        echo "<td><span class='badge bg-warning'>Suspended</span></td>";
                                        echo "<td>";
                                        echo "<a href='activateAcc.php?id=$id'><button type='button' class='btn btn-success'>Activate</button></a>";
                                    }
                                    echo "</td>";
                                    echo "<td><div id='sendId'><button type='button' class='btn btn-secondary sendButton' id ='sendButton' data-toggle='modal' data-target='#sendMessage' value = '$id'>Message</button></div></td>";
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
        <div class="tab-pane fade" id="buyer" role="tabpanel" aria-labelledby="buyer-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="buyerT" class="table">
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
                            $sql = 'SELECT id, firstName, lastName, email, role, tinNumber, registrationDate, status FROM buyer INNER JOIN user on buyer.userId = user.id WHERE 1 ORDER BY firstName';
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
                                        echo "<a href='suspendAcc.php?id=$id'><button type='button' class='btn btn-warning'>Suspend</button></a>";
                                    } else if ($row[7] == 0) {
                                        echo "<td><span class='badge bg-warning'>Waiting for Approval</span></td>";
                                        echo "<td>";
                                        echo "<a href='acceptAcc.php?id=$id'><button type='button' class='btn btn-success'>Accept</button></a>";
                                    } else if ($row[7] == 2) {
                                        echo "<td><span class='badge bg-danger'>Suspended</span></td>";
                                        echo "<td>";
                                        echo "<a href='activateAcc.php?id=$id'><button type='button' class='btn btn-success'>Activate</button></a>";
                                    }
                                    echo "</td>";

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
        <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-50 mx-auto text-secondary d-flex icon-boxes">

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="formId">
                        <input style="margin-left: 30%; margin: 20px 50px;   width: 180px; float:left;" class="form-control" type="text" placeholder="Category Name" name="categoryName" id="queryV">
                        <input type='submit' class='btn btn-secondary' style="margin: 20px 5px; width: 180px; height: 35px;" value="Add New Category">
                    </form>
                    <table id="categoryT" class="table">
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
                    <table id="featureT" class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product</th>
                                <th scope="col">Category</th>
                                <th scope="col">Vendor Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalA = 0;
                            $totalV = 0;
                            $totalB = 0;

                            $sql = 'SELECT inventoryId, inventoryName, categoryName, vendorName, featured FROM inventory
                            INNER JOIN category on inventory.categoryId = category.categoryId
                            INNER JOIN vendor on inventory.vendorId = vendor.userId WHERE 1 ORDER BY featured';
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
                                    if ($row[4] == 1) {
                                        echo "<td><span class='badge bg-success'>Featured</span></td>";
                                        echo "<td>";
                                        echo "<a href='feature.php?id=$id'><button type='button' class='btn btn-danger'>Unfeature</button></a>";
                                    } else if ($row[4] == 0) {
                                        echo "<td><span class='badge bg-danger'>Not featured</span></td>";
                                        echo "<td>";
                                        echo "<a href='feature.php?id=$id'><button type='button' class='btn btn-success'>Feature</button></a>";
                                    }
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
        <div class="tab-pane fade" id="message" role="tabpanel" aria-labelledby="message-tab">
            <section class=" bg" style="min-height: 70vh;">
                <div class="row w-75 mx-auto text-secondary d-flex icon-boxes">
                    <table id="messageT" class="table">
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
                            $adminId = $_SESSION['id'];
                            $sql = 'SELECT messageId, username, email, messageTitle, messageBody, readStatus FROM message
                            INNER JOIN user on message.senderId = user.id WHERE receiverId = :receiverId ORDER BY readStatus';
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':receiverId', $adminId);
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
                                        echo "<a href='read.php?id=$id'><button type='button' class='btn btn-warning'>Mark as unread</button></a>";
                                    } else if ($row[5] == 0) {
                                        echo "<td><span class='badge bg-danger'>Unread</span></td>";
                                        echo "<td colspan='3'>";
                                        echo "<a href='read.php?id=$id'><button type='button' class='btn btn-success'>Mark as read</button></a>";
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

    <?php
    include('../src/components/footer.php');

    echo
    '<div class="modal fade" id="deleteMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Account</h5>
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

    echo '<div class="modal fade" id="sendMessage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  style="margin-top: 100px;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form id="sendMessageForm">
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Recipient:</label>
              <input type="text" class="form-control" id="recipient-name" name="recipient-name">
            </div>
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
    ?>

    <script>
        $(document).ready(function() {
            $('#vendorT, #buyerT, #categoryT, #featureT, #messageT').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
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
                var strLink = 'view.php?id=' + $messageId;
                document.getElementById("markRead").setAttribute("href", strLink);
            });

            $(document).on('click', '.deleteMsg', function() {
                $msgId = $(this).val();

                var deleteLink = 'deleteMsg.php?id=' + $msgId;
                document.getElementById("deleteM").setAttribute("href", deleteLink);
            });

            $(document).on('click', '.sendButton', function() {
                var $receiverId = $(this).val();
                var receiver = $('#receiverName' + $receiverId).text();
                $('#recipient-name').val(receiver);

                <?php
                $_SESSION['adminId'] = $adminId;
                ?>
            });

            $(document).ready(function() {
                $("#sendMessageForm").submit(function(event) {
                    submitForm();
                    return false;
                });
            });

            function submitForm() {
                $.ajax({
                    type: "POST",
                    url: "sendMessage.php",
                    cache: false,
                    data: $('form#sendMessageForm').serialize(),
                    success: function(response) {
                        $("body").html(response)
                        $("#sendMessage").modal('hide');
                    },
                    error: function() {
                        alert("Error");
                    }
                });
            }

        });
    </script>

</body>

</html>