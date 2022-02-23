<?php
session_start();
require('../../../class/User.php');

$userRole = $_SESSION['role'];
$userId = $_SESSION['id'];

if ($userRole == 'vendor') {
    $sql = 'SELECT vendorName, tinNumber FROM vendor WHERE userId = :userId';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $row = $stmt->fetch();

    $vName = $row[0];
    $vTIn = $row[1];
} else if ($userRole == 'buyer') {
    $sql = 'SELECT firstname, lastname, tinNumber FROM buyer WHERE userId = :userId';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    $row = $stmt->fetch();

    $bFirstName = $row[0];
    $bLastName = $row[1];
    $bTin = $row[2];
} else {
    header("Location: signin.php");
}

$sql = 'SELECT username, email FROM user WHERE id = :userId';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$row = $stmt->fetch();
$uName = $row[0];
$uEmail = $row[1];

$password = '';

$password_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $password = trim($_POST['password']);
    $change = false;

    if (empty($password)) {
        $password_error = 'Please enter your password.';
    }

    if (empty($password_error)) {
        if (User::checkPassword($password, $userId)) {
            $vendorName = $firstName = $lastName = '';
            if ($userRole == 'vendor') {
                $vendorName = trim($_POST['vendorName']);
            } else if ($userRole == 'buyer') {
                $firstName = trim($_POST['firstName']);
                $lastName = trim($_POST['lastName']);
            }
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $tinNumber = trim($_POST['tinNumber']);

            $username_err = $email_err = false;
            if (!empty($username) && $username != $uName) {
                if (User::updateUsername($username, $userId)) {
                    $change = true;
                } else {
                    $username_err = true;
                }
            }
            if (!empty($email) && $email != $uEmail && !$username_err) {
                if (User::updateEmail($email, $userId)) {
                    $change = true;
                } else {
                    $email_err = true;
                }
            }

            if (!$username_err && !$email_err) {
                if ($userRole == 'vendor') {
                    if (!empty($vendorName) && $vendorName != $vName) {
                        User::updateVendorName($vendorName, $userId);
                        $change = true;
                    }

                    if (!empty($tinNumber) && $tinNumber != $vTIn) {
                        User::updateVendorTin($tinNumber, $userId);
                        $change = true;
                    }
                } else if ($userRole == 'buyer') {
                    if (!empty($firstName) && $firstName != $bFirstName) {
                        User::updateFirstName($firstName, $userId);
                        $change = true;
                    }

                    if (!empty($lastName) && $lastName != $bLastName) {
                        User::updateLastname($lastName, $userId);
                        $change = true;
                    }
                    if (!empty($tinNumber) && $tinNumber != $bTin) {
                        User::updateBuyerTin($tinNumber, $userId);
                        $change = true;
                    }
                }
            }


            if ($change && !$username_err && !$email_err) {
                $message = "Account Updated Successfully";
                $opeStatus = 0;
                $_SESSION['message'] = $message;
                $_SESSION['opeStatus'] = $opeStatus;
            } else if (!$change && !$username_err && !$email_err) {
                $message = "No change made, Please edit an attribute to update";
                $opeStatus = 1;
                $_SESSION['message'] = $message;
                $_SESSION['opeStatus'] = $opeStatus;
            } else if ($username_err) {
                $message = "User name already taken, Please try another.";
                $opeStatus = 1;
                $_SESSION['message'] = $message;
                $_SESSION['opeStatus'] = $opeStatus;
            } else if ($email_err) {
                $message = "Email is already taken, Please try another";
                $opeStatus = 1;
                $_SESSION['message'] = $message;
                $_SESSION['opeStatus'] = $opeStatus;
            }
        } else {
            $password_error = 'Wrong Password';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="../../../css/bootstrap.css">
    <script src="../../../js/bootstrap.js"></script>

    <title>comart - Quality materials for your construction</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="../../../css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="../../../css/slick.css" />
    <link type="text/css" rel="stylesheet" href="../../../css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="../../../css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="../../../css/font-awesome.min.css" />

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="../../../css/style.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
 		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 		<![endif]-->
    <link rel="stylesheet" href="../../../css/style-responsive.css">

</head>

<body style="overflow-x: hidden;">
    <!-- HEADER -->
    <header>
        <?php
        //<!-- TOP HEADER -->
        include('../../components/topHeader.php');
        //<!-- /TOP HEADER -->

        //<!-- MAIN HEADER -->
        include('../../components/mainHeader.php');
        //<!-- /MAIN HEADER -->
        ?>
    </header>
    <!-- /HEADER -->


    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
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
        } else {
            echo '
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Edit Account Details</h3>
                    <h4 style="float:right;">Edit the fields you want to update</h4>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->';
        }
        ?>
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <form action="<?php $_PHP_SELF ?>" method="POST" class="form-horizontal" role="form">
                <?php
                if ($userRole == 'vendor') {
                    echo '<div class="form-group">
                            <label for="vendorName" class="col-sm-3 control-label">Vendor Name</label>
                            <div class="col-sm-9">';
                    echo "<input type='text' id='vendorName' placeholder='Vendor Name' class='form-control' name='vendorName' value='$vName' onkeyup='enableUpdateBtn()' autofocus>
                            </div>
                        </div>";
                } else if ($userRole == 'buyer') {
                    echo '<div class="form-group">
                            <label for="firstName" class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-9"> ';
                    echo "<input type='text' id='firstName' placeholder='First Name' class='form-control' name='firstName' value='$bFirstName' onkeyup='enableUpdateBtn()' autofocus>
                            </div>";
                    echo '</div>
                            <div class="form-group">
                                <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                                <div class="col-sm-9">';
                    echo "<input type='text' id='lastName' placeholder='Last Name' class='form-control' name='lastName' value='$bLastName' onkeyup='enableUpdateBtn()' autofocus>
                                </div>
                            </div>";
                }
                ?>

                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" id="username" placeholder="username" class="form-control" name="username" value="<?php echo $uName ?>" onkeyup='enableUpdateBtn()'>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" id="email" placeholder="Email" class="form-control" name="email" value="<?php echo $uEmail ?>" onkeyup='enableUpdateBtn()'>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tinNumber" class="col-sm-3 control-label">Tin Number</label>
                    <div class="col-sm-9">
                        <input type="text" id="tinNumber" placeholder="Tin Number" class="form-control" name="tinNumber" value="<?php echo ($userRole == 'vendor') ? $vTIn : $bTin ?>" onkeyup='enableUpdateBtn()'>
                    </div>
                </div>
                <div class=" form-group">
                    <label for="password" class="col-sm-3 control-label">Password*</label>
                    <div class="col-sm-9">
                        <input type="password" id="password" placeholder="Enter Password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>" name="password" value="">
                        <span class="invalid-feedback" style="color: red;"><?php echo $password_error; ?></span>
                    </div>
                </div>
                <!-- /.form-group -->
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn primary-btn" id="updateBtn" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px" disabled>Update Account</button>
                </div>
            </form> <!-- /form -->
        </div> <!-- ./container -->
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- NEWSLETTER -->
    <div id=" newsletter" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Enter Your Email">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /NEWSLETTER -->

    <!-- FOOTER -->

    <?php include('../../components/footer.php'); ?>

    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="../../../js/jquery.min.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
    <script src="../../../js/slick.min.js"></script>
    <script src="../../../js/nouislider.min.js"></script>
    <script src="../../../js/jquery.zoom.min.js"></script>
    <script src="../../../js/main.js"></script>

    <script>
        function enableUpdateBtn() {
            document.getElementById("updateBtn").disabled = false;
        }
    </script>

</body>

</html>