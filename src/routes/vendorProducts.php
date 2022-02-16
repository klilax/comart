<?php
require_once('../../class/Inventory.php');

$vendorId = $_GET['vendorId'];

$vendorProducts = Inventory::getVendorInventory($vendorId);
session_start();
// print_r($vendorProducts);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<meta name="description" content="Sell and Buy construction materials easily with comart. A platform to improve the distribution of quality construction materials in Ethiopia. Check current prices on the largest selection of essentials and products, including cement, sand, aggregate, steel structures, rebars, ceramics, roofs, electrical pipes, paints and more.">

	<title>COMART - Quality materials for your construction</title>
	<link rel="icon" href="img/logo_icon.png">

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
	<link rel="stylesheet" href="../../css/style-responsive.css">

	<style>
		@media screen and (max-width: 500px) {

			.header-links li a {
				font-size: 0.9rem;
			}

			#vendorProducts a img {
				width: 100% !important;
				height: 255px !important;
			}
		}
	</style>
</head>

<body style="overflow-x: hidden;">
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
						<li><a href="/index.php">Home</a></li>
						<li class="active"><?php echo Inventory::vendorName($vendorId) ?></li>
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
					<div id="vendorProducts" class="row" style="display: flex; flex-wrap: wrap;">
						<?php

						foreach ($vendorProducts as $product) {
							$encoded_name = urlencode($product['inventoryName']);
							echo '
							<a href="/src/routes/product.php?inventoryId=' . $product['inventoryId'] . '">
								<div class="col-md-3 col-xs-6" style="padding-bottom: 3.5rem;">
									<div class="product">
										<div class="product-img">
											<img src="../../img/';
							if ($product['imgName'] == '') {
								if (Category::getCategoryDefaultImg($product['categoryName']) == '') {
									echo 'imgError.jpg';
								} else {
									echo Category::getCategoryDefaultImg($product['categoryName']);
								}
							} else {
								echo $product['imgName'];
							}
							echo '" style = "width: 263px; height: 175px;" alt="">

							';
							if ($product['featured'] == 1) {
								echo '
											<div class="product-label">
												<span class="new">FEATURED</span>
											</div>
								';
							}
							echo '
										</div>
										<div class="product-body">
											<p class="product-category">' . $product['categoryName'] . '</p>
											<h3 class="product-name"><a href="#">' . $product['inventoryName'] . '</a></h3>
											<h4 class="product-price">' . $product['price'] . ' Birr</h4>

							<!-- review - rating -->
											<div class="product-rating">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
											</div>

											<div class="product-btns">
                            						<a href="/src/routes/product.php?inventoryId=' . $product['inventoryId'] . '" class="quick-view">
														<i class="fa fa-eye" title="Quick View"></i>
														<span class="tooltipp"></span>
                            						</a>
											</div>
										</div>
										<div class="add-to-cart">
											<a href="/class/Cart.php?inventoryId=' . $product['inventoryId'] . '&productName=' . $encoded_name . '&price=' . $product['price'] . '">
                            					<button class="add-to-cart-btn">
													<i class="fa fa-shopping-cart"></i>
											 add to cart
                            					</button>
											</a>
										</div>
									</div>
								</div>
							</a>
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
	<script src="../../js/menu-toggle.js"></script>

</body>

</html>