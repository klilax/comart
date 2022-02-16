<?php
session_start();
require('../../../class/User.php');

$password = '';

$password_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['id'];
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $password = trim($_POST['password']);
    $change = false;

    if (empty($password)) {
        $password_error = 'Please enter your password.';
    }

    if (empty($password_error)) {
        $vendorName = $firstName = $lastName = '';
        if ($_SESSION['role'] == 'vendor') {
            $vendorName = trim($_POST['vendorName']);
        } else if ($_SESSION['role'] == 'buyer') {
            $firstName = trim($_POST['firstName']);
            $lastName = trim($_POST['lastName']);
        }
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $tinNumber = trim($_POST['tinNumber']);

        if ($_SESSION['role'] == 'vendor') {
            if (!empty($vendorName)) {
                User::updateVendorName($vendorName, $userId);
                $change = true;
            }

            if (!empty($tinNumber)) {
                User::updateVendorTin($tinNumber, $userId);
                $change = true;
            }
        } else if ($_SESSION['role'] == 'buyer') {
            if (!empty($firstName)) {
                User::updateFirstName($firstName, $userId);
                $change = true;
            }

            if (!empty($lastName)) {
                User::updateLastname($lastName, $userId);
                $change = true;
            }
            if (!empty($tinNumber)) {
                User::updateBuyerTin($tinNumber, $userId);
                $change = true;
            }
        }
        if (!empty($username)) {
            User::updateUsername($username, $userId);
            $change = true;
        }
        if (!empty($email)) {
            User::updateEmail($email, $userId);
            $change = true;
        }
        if ($change) {
            $message = "Account Updated Successfully";
            $opeStatus = 0;
            $_SESSION['message'] = $message;
            $_SESSION['opeStatus'] = $opeStatus;
        } else {
            $message = "Please fill an attribute to update";
            $opeStatus = 1;
            $_SESSION['message'] = $message;
            $_SESSION['opeStatus'] = $opeStatus;
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

</head>

<body>
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
                    <h4 style="float:right;">Fill the fields you want to update</h4>
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
                $userRole = $_SESSION['role'];
                if ($userRole == 'vendor') {
                    echo '<div class="form-group">
                            <label for="vendorName" class="col-sm-3 control-label">Vendor Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="vendorName" placeholder="Vendor Name" class="form-control" name="vendorName" value="" autofocus>
                            </div>
                        </div>';
                } else if ($userRole == 'buyer') {
                    echo '<div class="form-group">
                            <label for="firstName" class="col-sm-3 control-label">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="firstName" placeholder="First Name" class="form-control" name="firstName" value="" autofocus>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                                <div class="col-sm-9">
                                    <input type="text" id="lastName" placeholder="Last Name" class="form-control" name="lastName" value="" autofocus>
                                </div>
                            </div>';
                }
                ?>

                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" id="username" placeholder="username" class="form-control" name="username" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" id="email" placeholder="Email" class="form-control" name="email" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tinNumber" class="col-sm-3 control-label">Tin Number</label>
                    <div class="col-sm-9">
                        <input type="text" id="tinNumber" placeholder="Tin Number" class="form-control" name="tinNumber">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password*</label>
                    <div class="col-sm-9">
                        <input type="password" id="password" placeholder="Password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>" name="password" value="">
                        <span class="invalid-feedback" style="color: red;"><?php echo $password_error; ?></span>
                    </div>
                </div>
                <!-- /.form-group -->
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn primary-btn" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px">Update Account</button>
                </div>';
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

</body>

</html>