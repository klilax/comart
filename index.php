<?php
require('class/Cart.php');
require('class/Inventory.php');

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
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	<link rel="stylesheet" href="css/style-responsive.css">

	<style>
		@media screen and (max-width: 500px) {
			.header-links li a {
				font-size: 1rem;
			}

			#products a {
				width: 25% !important;
			}

			#featuredProducts a {
				width: 15%;
				padding: 0;
			}
		}
	</style>

	<script>
		window.onload = function() {
			renderInvenotry();
			renderFeaturedInventory();
		};

		function renderInvenotry() {
			let query = '';
			const ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					document.getElementById("products").innerHTML = this.responseText;
				}
			};
			ajax.open("GET", "class/searchInventory.php?query=" + query + "&category=all", true);
			ajax.send();
			console.log(query);
		}

		function renderFeaturedInventory() {
			let query = '';
			const ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					document.getElementById("featuredProducts").innerHTML = this.responseText;
				}
			};
			ajax.open("GET", "class/searchInventory.php?query=" + query + "&category=all&featuredOnly=yes", true);
			ajax.send();
			console.log(query);
		}

		function searchItem() {
			let query = document.getElementById("search").value;
			const ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					document.getElementById("products").innerHTML = this.responseText;
				}
			};
			ajax.open("GET", "class/searchInventory.php?query=" + query + "&category=all", true);
			ajax.send();
		}

		function getCategory(link) {
			let category = link.innerText;
			let query = '';
			const ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					document.getElementById("products").innerHTML = this.responseText;
				}
			};
			ajax.open("GET", "class/searchInventory.php?query=" + query + "&category=" + category, true);
			ajax.send();
		}
	</script>
</head>

<body style="overflow-x: hidden;">
	<!-- HEADER -->
	<header>
		<?php
		//<!-- TOP HEADER -->
		include('src/components/topHeader.php');
		//<!-- /TOP HEADER -->
        $itemQty = 0;
        if (isset($_SESSION['cartId'])) {
            $itemQty = $_SESSION['cart']['count'];
        }
		if (!isset($_SESSION['id']) || $user->getRole() == 'buyer') {
			echo '
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row" style="display:flex; flex-wrap:wrap;">
						<!-- LOGO -->
						<div class="col-md-6" style="flex: 2;">
							<div class="header-logo">
								<a href="\index.php" class="logo">
									<img src="\img\logo.svg" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->
						<!-- SEARCH BAR -->
						<div class="col-md-6" style="flex: 3;">
							<div class="header-search" style="min-width: 520px;">
								<form>
									<input class="input" placeholder="Search here" id="search" onkeyup="searchItem()" style="border-radius: 2rem 0 0 2rem;">
									<button type="button" class="search-btn" onclick="searchItem()">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix" style="flex: 1;">
							<div class="header-ctn">
							<!-- Cart -->
								<div class="dropdown">
									<a href="/src/routes/checkout.php">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										
										<div class="qty">'. $itemQty. '</div>
									</a>
								</div>
								<!-- /Cart -->
								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span></span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
		';
		} else {
			include('src/components/mainHeader.php');
		}
		?>
	</header>
	<!-- /HEADER -->

	<!-- Main -->

	<!-- NAVIGATION -->
	<nav id="navigation">
		<!-- container -->
		<div class="container">
			<!-- responsive-nav -->
			<div id="responsive-nav">
				<!-- NAV -->
				<ul class="main-nav nav navbar-nav">
					<li class="active"><a href="/index.php">Home</a></li>
					<?php
					foreach (Category::getAllCategories() as $row) {
						echo '<li><a href="#" onclick="getCategory(this)">' . $row['categoryName'] . '</a></li>';
					}
					?>
				</ul>
				<!-- /NAV -->
			</div>
			<!-- /responsive-nav -->
		</div>
		<!-- /container -->
	</nav>
	<!-- /NAVIGATION -->

	<main>
		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row" style="display: flex; flex-direction: row;">
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Featured</h3>
							<div class="checkbox-filter">
								<!-- product -->
								<div id="featuredProducts" class="row" style="display: flex; width: 100%; flex-direction: column;">

								</div>
								<!-- /product -->
							</div>
						</div>
						<!-- /aside Widget -->
					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div class="col-md-9">
						<!-- store top filter -->
						<div class="store-filter clearfix">
							<div class="store-sort">
								<label>
									Sort By:
									<select class="input-select">
										<option value="0">All</option>
										<option value="1">Featured</option>
									</select>
								</label>

								<label>
									Show:
									<select class="input-select">
										<option value="0">20</option>
										<option value="1">50</option>
									</select>
								</label>
							</div>
						</div>
						<!-- /store top filter -->

						<!-- store products -->
						<div id="products" class="row" style="display: flex; flex-wrap: wrap;">

						</div>
						<!-- /store products -->

						<!-- store bottom filter -->
						<div class="store-filter clearfix" style="margin: 5rem 0;">
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

		<?php include('src/components/footer.php'); ?>

		<!-- /FOOTER -->

		<!-- AJAX -->



		<!-- /AJAX -->

		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/menu-toggle.js"></script>

</body>

</html>