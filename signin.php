<?php
require_once 'db.php';

getConnection();

require('User.php');

$username = $password = '';

$username_error = $password_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (empty($username)) {
		$username_error = 'Please enter your username.';
	}

	if (empty($password)) {
		$password_error = 'Please enter your password.';
	}

	$user = array('username' => $username, 'password' => $password);

	//validate

	if (empty($username_error) && empty($password_error)) {

		// $password_error = 'Incorrect password. Please try again.';
		// $username_error = 'This account has been deactivated, Please contact the Administrator.';
		// $username_error = 'No account found with that username.';

		User::auth($username, $password);
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
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css" />

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />

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
		include('src\components\topHeader.php');
		//<!-- /TOP HEADER -->

		//<!-- MAIN HEADER -->
		include('src\components\mainHeader.php');
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
					<h3 class="breadcrumb-header">Sign In</h3>
					<ul class="breadcrumb-tree">
						<li><a href="" data-toggle='modal' data-target='#exampleModalCenter'>Dont't have account? Create Now</a></li>
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
		<div id="main-wrapper" class="container">
			<div class="row justify-content-center">
				<div class="col-xl-10">
					<div class="card border-0">
						<div class="card-body p-0">
							<div class="row no-gutters">
								<div class="col-lg-6">
									<div class="p-5">

										<h4 class="h4 mb-0">Welcome back!</h4>
										<p class="text-muted mt-2 mb-5">Enter your email address and password to access
											your account.</p>

										<form action="<?php $_PHP_SELF ?>" method="POST">
											<div class="form-group">
												<label for="username">Username</label>
												<input type="username" class="form-control" id="username" name="username" placeholder="Username">
												<span class="invalid-feedback" style="color: red;"><?php echo $username_error; ?></span>
											</div>
											<div class="form-group mb-5">
												<label for="password">Password</label>
												<input type="password" class="form-control" id="password" name="password" placeholder="Password">
												<span class="invalid-feedback" style="color: red;"><?php echo $password_error; ?></span>
											</div>
											<button type=" submit" class="btn primary-btn rounded">Sign In</button>
										</form>
										<p class="text-muted text-center mt-3 mb-0">Don't have an account? <a href="" class="text-primary ml-1" data-toggle='modal' data-target='#exampleModalCenter'>Create Account</a></p>
									</div>
								</div>

								<div class="col-lg-6 d-none d-lg-inline-block">
									<div class="account-block rounded-right">
										<div class="overlay rounded-right"></div>
										<div class="account-testimonial text-center">
											<h4 class="text-white mb-4">Shop and Sell Quality materials for your construction!</h4>
											<p class="lead text-white">"Best investment I made for a long time. Can only recommend it for other users."</p>
											<p>- comart team head</p>
										</div>
									</div>
								</div>
							</div>

						</div>
						<!-- end card-body -->
					</div>
					<!-- end card -->

					<!-- end row -->

				</div>
				<!-- end col -->
			</div>
			<!-- Row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->

	<?php
	echo
	'<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div style="display: flex; justify-content: center; align-items: center; padding: 1.2rem 0;">
					<h4 class="modal-title" id="exampleModalLongTitle">Choose your account type</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="color: red; font-size: 30px; position: absolute; right: 2%; top: 5%;">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h5 class="text-center">Do you want to create account as a customer or create your shop?</h5>
				</div>
				<div style="display: flex; justify-content: center; align-items: center; padding-bottom: 1.2rem;">
					<a href="signupC.php"><button class="btn secondary-btn" id="customer">Create as a customer</button></a>
					<a href="signupV.php"><button class ="btn secondary-btn" id="vendor" style="background-color: var(--primary-color); margin-left: 1rem;">Create my shop</button></a>
				</div>
			</div>
		</div>
	</div>';
	?>

	<!-- NEWSLETTER -->
	<div id="newsletter" class="section">
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

	<?php include('src/components/footer.php'); ?>

	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
</body>


</html>