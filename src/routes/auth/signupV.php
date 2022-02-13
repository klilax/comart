<?php
// require_once '../../../class/db.php';

require('../../../class/User.php');
session_start();

$firstName = $lastName = $shopName = $username = $email = $tinNumber = $password = $confirm_password = '';

$firstName_error = $lastName_error = $shopName_error = $username_error = $email_error = $tinNumber_error = $password_error = $confirm_password_error = $agreement_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $shopName = trim($_POST['shopName']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $tinNumber = trim($_POST['tinNumber']);
    $password = trim($_POST['password']);
    $role = 'vendor';
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($shopName)) {
        $shopName_error = 'Please enter your shop name.';
    }

    if (empty($username)) {
        $username_error = 'Please enter a username.';
    } else {
        if (!User::isNewUser($username)) {
            $username_error = 'Username is already taken.';
        }
    }

    if (empty($email)) {
        $email_error = 'Please enter your email.';
    } else {
        if (!User::isNewUser($email)) {
            $email_error = 'Email is already taken.';
        }
    }

    if (empty($tinNumber)) {
        $tinNumber_error = 'Please enter your tin number.';
    }

    if (empty($password)) {
        $password_error = 'Please enter your password.';
    } else if (strlen($password) < 6) {
        $password_error = 'Passoword must be at least 6 characters.';
    }

    //validate confirm password
    if (empty($confirm_password)) {
        $confirm_password_error = 'Please confirm your password.';
    } else {
        if ($password !== $confirm_password) {
            $confirm_password_error = 'Passwords do not match.';
        }
    }

    //validate agreement checkbox
    if (!isset($_POST['agreement'])) {
        $agreement_error = 'Please click on the agreement checkbox.';
    }

    if (empty($shopName_error) && empty($username_error) && empty($email_error) && empty($tinNumber_error) && empty($password_error) && empty($confirm_password_error) && empty($agreement_error)) {
        $vendor = ['username' => $username, 'email' => $email, 'password' => $password, 'role' => $role, 'vendorName' => $shopName, 'tinNumber' => $tinNumber];
        User::register($vendor);

        $message = "Account Created Successfully";
        $opeStatus = 0;
        $_SESSION['message'] = $message;
        $_SESSION['opeStatus'] = $opeStatus;

        header("Location: signin.php");
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
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Create Account</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="signin.php">Already have account? Sign In</a></li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <form action="<?php $_PHP_SELF ?>" method="POST" class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <span class="help-block">*Required fields</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="shopName" class="col-sm-3 control-label">Shop Name*</label>
                    <div class="col-sm-9">
                        <input type="text" id="shopName" placeholder="Shop Name" class="form-control <?php echo (!empty($shopName_error)) ? 'is-invalid' : ''; ?>" name="shopName" value="<?php echo $shopName ?>" autofocus>
                        <span class="invalid-feedback" style="color: red;"><?php echo $shopName_error; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username*</label>
                    <div class="col-sm-9">
                        <input type="text" id="username" placeholder="Username" class="form-control <?php echo (!empty($username_error)) ? 'is-invalid' : ''; ?>" name="username" value="<?php echo $username ?>" autofocus>
                        <span class="invalid-feedback" style="color: red;"><?php echo $username_error; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email* </label>
                    <div class="col-sm-9">
                        <input type="email" id="email" placeholder="Email" class="form-control <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" name="email" value="<?php echo $email ?>">
                        <span class="invalid-feedback" style="color: red;"><?php echo $email_error; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tinNumber" class="col-sm-3 control-label">Tin Number*</label>
                    <div class="col-sm-9">
                        <input type="number" id="tinNumber" placeholder="Tin Number" class="form-control" name="tinNumber" value="<?php echo $tinNumber ?>">
                        <span class="invalid-feedback" style="color: red;"><?php echo $tinNumber_error; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password*</label>
                    <div class="col-sm-9">
                        <input type="password" id="password" placeholder="Password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>" name="password" value="<?php echo $password ?>">
                        <span class="invalid-feedback" style="color: red;"><?php echo $password_error; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="col-sm-3 control-label">Confirm Password*</label>
                    <div class="col-sm-9">
                        <input type="password" id="confirm_password" placeholder="Confirm Password" class="form-control <?php echo (!empty($confirm_password_error)) ? 'is-invalid' : ''; ?>" name="confirm_password" value="<?php echo $confirm_password ?>">
                        <span class="invalid-feedback" style="color: red;"><?php echo $confirm_password_error; ?></span>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-9 col-sm-offset-3">
                        <input type="checkbox" class="form-check-input <?php echo (!empty($agreement_error)) ? 'is-invalid' : ''; ?>" id="exampleCheck1" name="agreement">
                        <label class="form-check-label" for="exampleCheck1">Agree to Privacy terms and conditions</label><br>
                        <span class="invalid-feedback" style="color: red;"><?php echo $agreement_error; ?></span>
                    </div>
                </div>
                <!-- /.form-group -->
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn primary-btn" style="background-color: var(--primary-color); border-radius: 5px; padding: 10px 20px">Create Account</button>
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

</body>

</html>