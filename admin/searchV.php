<?php
    require('../class/User.php');
    $query=$_REQUEST['query'];
    $query = "%$query%";
?>

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
                    $sql = 'SELECT id, vendorName, email, role, tinNumber, registrationDate, status FROM vendor INNER JOIN user u on vendor.userId = u.id WHERE vendorName like :vendorName ORDER BY vendorName';
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':vendorName', $query);
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
                        echo "<tr>";
                        echo "<td colspan=8 style='color:red'>No vendor account found with that name.</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>             