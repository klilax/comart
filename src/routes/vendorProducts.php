<?php
$vendorId = $_GET['vendorId'];
echo $vendorId;
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
	<link type="text/css" rel="stylesheet" href="../../css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="../../css/slick.css" />
	<link type="text/css" rel="stylesheet" href="../../css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="../../css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="../../css/font-awesome.min.css" />

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="../../css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
 		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 		<![endif]-->

	<script>
		function searchItem() {
			let query = document.getElementById("searchItem").value;
			const ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					document.getElementById("main").innerHTML = this.responseText;
				}
			};
			ajax.open("GET", "../class/searchInventory.php?query=" + query + "&category=all", true);
			ajax.send();
			console.log(query);
		}
	</script>
</head>

<body>
	<!-- HEADER -->
	<header>
		<?php
		//<!-- TOP HEADER -->
		include('../components/topHeader.php');
		//<!-- /TOP HEADER -->

		//<!-- MAIN HEADER -->
		include('../components/mainHeader.php');
		//<!-- /MAIN HEADER -->
		?>
	</header>
	<!-- /HEADER -->

	<!-- NAVIGATION -->
	<?php include('../components/navigation.php'); ?>
	<!-- /NAVIGATION -->

	<!-- BREADCRUMB -->
	<div id="breadcrumb" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb-tree">
						<li><a href="#">Home</a></li>
						<li><a href="#">All Categories</a></li>
						<li><a href="#">Accessories</a></li>
						<li class="active">Headphones (227,490 Results)</li>
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
			<!-- row -->
			<div class="row">
				<!-- STORE -->
				<div id="store" class="col-md-9" style="width: 100%; margin: 0 auto;">
					<!-- store products -->
					<div class="row" style="display: flex; flex-wrap: wrap; justify-content: center;">
						<?php

						for ($i = 0; $i < 9; $i++) {
							echo '
							<!-- product -->
							<div class="col-md-3 col-xs-6" style="padding-bottom: 3.5rem;">
								<div class="product">
									<div class="product-img">
										<img src="../../img/product01.png" alt="">
										<div class="product-label">
											<span class="sale">-30%</span>
											<span class="new">NEW</span>
										</div>
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href="#">product name goes here</a></h3>
										<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										<div class="product-btns">
											<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
											<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
											<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick
							view</span></button>
										</div>
									</div>
									<div class="add-to-cart">
										<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to
							cart</button>
									</div>
								</div>
							</div>
							<!-- /product -->
							';
						}
						?>
					</div>
					<!-- /store products -->

					<!-- store bottom filter -->
					<div class="store-filter clearfix">
						<span class="store-qty">Showing 20-100 products</span>
						<ul class="store-pagination">
							<li class="active">1</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
						</ul>
					</div>
					<!-- /store bottom filter -->
				</div>
				<!-- /STORE -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->

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

	<?php include('../components/footer.php'); ?>

	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
	<script src="../../js/slick.min.js"></script>
	<script src="../../js/nouislider.min.js"></script>
	<script src="../../js/jquery.zoom.min.js"></script>
	<script src="../../js/main.js"></script>

</body>

</html>