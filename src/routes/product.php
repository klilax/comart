<?php
//require_once('../../class/Inventory.php');
require_once ('../../class/Order.php');
session_start();

$productId = $_GET['inventoryId'];

$product = new Inventory($productId);

$productName = $product->getProductName();
$encoded_name = urlencode($productName);
$productPrice = $product->getPrice();
$productQty = $product->getQuantity();
$productFeatured = $product->getFeatured();
$productCategory = Category::getCategoryName($product->getCategoryId());
$productVendorId = $product->getVendorId();
$productVendorName = $product->getVendorName();
$productDesc = $product->getDescription();
$productImg = $product->getImgName();
$categoryImg = Category::getCategoryDefaultImg($productCategory);
$productRating = $product->getRating();
$reviews = $product->getReviews();
// print_r($reviews);
$numOfReviews = count($reviews);

function renderStars($rating) {
	for ($i = 0; $i < floor($rating); $i++) {
		echo '<i class="fa fa-star" style="margin: 0.1rem"></i>';
	}
	for ($i = 0; $i < 5 - $rating; $i++) {
		echo '<i class="fa fa-star-o" style="margin: 0.1rem"></i>';
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

	<meta name="description" content="Sell and Buy construction materials easily with comart. A platform to improve the distribution of quality construction materials in Ethiopia. Check current prices on the largest selection of essentials and products, including cement, sand, aggregate, steel structures, rebars, ceramics, roofs, electrical pipes, paints and more.">

	<title>COMART - Quality materials for your construction</title>
	<link rel="icon" href="../../img/logo_icon.png">

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

			.container>.row {
				flex-direction: column !important;
			}

			.container>.row>div.img-div,
			.container>.row>div.details-div {
				width: 100% !important;
			}

			.logo img {
				position: relative !important;
				left: -18rem;
			}

			.menu-toggle {
				display: none !important;
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

	<!-- SECTION -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row" style="display: flex;">
				<!-- Product main img -->
				<div class="img-div col-md-5 col-md-2" style="width: 50%">
					<div id="product-main-img">
						<div class="product-preview">
							<img src="../../img/
							<?php
							if ($productImg == '' || is_null($productImg)) {
								if (Category::getCategoryDefaultImg($productCategory) == '' || is_null(Category::getCategoryDefaultImg($productCategory))) {
									echo 'imgError.jpg';
								} else {
									echo Category::getCategoryDefaultImg($productCategory);
								}
							} else {
								echo $productImg;
							}
							?>
							">
						</div>
					</div>
				</div>
				<!-- /Product main img -->

				<!-- Product details -->
				<div class="details-div col-md-5" style="width: 50%; padding: 3rem;">
					<div class="product-details">
						<h5 class="h5 text-muted"><?php echo $productCategory; ?></h5>
						<h2 class="product-name" style="display: inline;"><?php echo $productName; ?></h2>
						<?php
						if ($productFeatured) {
							echo '
								<div style="border: 1px solid var(--secondary-color); color: var(--secondary-color); padding: 0.3rem; display: inline; margin-left: 2rem;">
									<span class="h6 new">FEATURED</span>
								</div>';
						}
						?>
						<h5 class="h5 text-muted p-3">View Seller - <a href="<?php echo '/comart/src/routes/vendorProducts.php?vendorId=' . $productVendorId . ''; ?>" style=" text-decoration: underline; color: var(--secondary-color);"> <?php echo $productVendorName; ?></a></h5>
						<div style="padding: 2rem 0;">
							<div class="product-rating">
								<?php
								renderStars($productRating);
								?>
							</div>
							<a class="review-link" href="#"><?php echo $numOfReviews; ?> Review(s) | Add your review</a>
						</div>
						<div>
							<h3 class="product-price"><?php echo $productPrice; ?> Birr</h3>
							<span class="product-available" <?php echo $productQty == 0 ? 'style = "color: var(--danger-color);"' : "" ?>><?php echo $productQty > 0 ? 'In Stock' : 'Out of Stock'; ?></span>
						</div>
						<p><?php echo $productDesc; ?></p>

						<div class="add-to-cart">
							<div class="qty-label">
								Qty
								<div class="input-number">
									<input id="cartQuantity" type="number" value="1">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
							</div>

							<button class="add-to-cart-btn" onclick="sendCart()"><i class="fa fa-shopping-cart"></i> add to cart</button>

						</div>

						<ul class="product-links">
							<li>Category:</li>
							<li><a href="#"><?php echo $productCategory ?></a></li>
						</ul>

						<!-- <ul class="product-links">
							<li>Share:</li>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-envelope"></i></a></li>
						</ul> -->

					</div>
				</div>
				<!-- /Product details -->
				<script>
					function sendCart() {
						let qty = document.getElementById("cartQuantity").value;
						window.location.href = "<?php echo '../../class/Cart.php?inventoryId=' . $productId . '&productName=' . $encoded_name . '&price=' . $productPrice . '&quantity='; ?>" + qty;
					}
				</script>
			</div>
			<!-- /row -->
			<!-- Product tab -->
			<div class="col-md-12">
				<div id="product-tab">
					<!-- product tab nav -->
					<ul class="tab-nav">
						<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
						<li><a data-toggle="tab" href="#tab3">Reviews (<?php echo $numOfReviews; ?>)</a></li>
					</ul>
					<!-- /product tab nav -->

					<!-- product tab content -->
					<div class="tab-content">
						<!-- tab1  -->
						<div id="tab1" class="tab-pane fade in active">
							<div class="row">
								<div class="col-md-12">
									<p><?php echo $productDesc; ?></p>
								</div>
							</div>
						</div>
						<!-- /tab1  -->

						<!-- tab3  -->
						<div id="tab3" class="tab-pane fade in">
							<div class="row">
								<!-- Rating -->
								<div class="col-md-3">
									<div id="rating">
										<div class="rating-avg">
											<span>4.5</span>
											<div class="rating-stars">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star-o"></i>
											</div>
										</div>
										<ul class="rating">
											<li>
												<div class="rating-stars">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="rating-progress">
													<div style="width: 80%;"></div>
												</div>
												<span class="sum">3</span>
											</li>
											<li>
												<div class="rating-stars">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</div>
												<div class="rating-progress">
													<div style="width: 60%;"></div>
												</div>
												<span class="sum">2</span>
											</li>
											<li>
												<div class="rating-stars">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												</div>
												<div class="rating-progress">
													<div></div>
												</div>
												<span class="sum">0</span>
											</li>
											<li>
												<div class="rating-stars">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												</div>
												<div class="rating-progress">
													<div></div>
												</div>
												<span class="sum">0</span>
											</li>
											<li>
												<div class="rating-stars">
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												</div>
												<div class="rating-progress">
													<div></div>
												</div>
												<span class="sum">0</span>
											</li>
										</ul>
									</div>
								</div>
								<!-- /Rating -->

								<!-- Reviews -->
								<div class="col-md-6">
									<div id="reviews">
										<ul class="reviews">
											<?php
											foreach ($reviews as $review) {
												echo '
													<li>
														<div class="review-heading">
															<h5 class="name">' . $review['firstname'] . '</h5>
															<p class="date">' . $review['date'] . '</p>
															<div class="review-rating">
																';
												for ($i = 0; $i < floor($review['rating']); $i++) {
													echo '<i class="fa fa-star" style="margin: 0.1rem"></i>';
												}
												for ($i = 0; $i < 5 - $review['rating']; $i++) {
													echo '<i class="fa fa-star-o" style="margin: 0.1rem"></i>';
												}
												echo '
															</div>
														</div>
														<div class="review-body">
															<p>' . $review['review'] . '</p>
														</div>
													</li>
												';
											}
											?>
										</ul>
										<!-- <ul class="reviews-pagination">
											<li class="active">1</li>
											<li><a href="#">2</a></li>
											<li><a href="#">3</a></li>
											<li><a href="#">4</a></li>
											<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
										</ul> -->
									</div>
								</div>
								<!-- /Reviews -->

								<!-- Review Form -->
								<div class="col-md-3">
									<div id="review-form">
										<form class="review-form">
											<textarea class="input" placeholder="Your Review"></textarea>
											<div class="input-rating">
												<span>Your Rating: </span>
												<div class="stars">
													<input id="star5" class="review-stars" name="rating" value="5" type="radio"><label for="star5"></label>
													<input id="star4" class="review-stars" name="rating" value="4" type="radio"><label for="star4"></label>
													<input id="star3" class="review-stars" name="rating" value="3" type="radio"><label for="star3"></label>
													<input id="star2" class="review-stars" name="rating" value="2" type="radio"><label for="star2"></label>
													<input id="star1" class="review-stars" name="rating" value="1" type="radio"><label for="star1"></label>
												</div>
											</div>
											<button class="primary-btn" type="button" onclick="sendReview()">Submit</button>
										</form>
									</div>
								</div>
								<!-- /Review Form -->
								<script>
									let ratingStars = document.querySelectorAll('.review-stars');
									let review = document.querySelector('.review-form textarea');

									ratingStars.forEach(star => {
										star.addEventListener('click', e => {
											rating = e.target.value;
										})
									})

									function sendReview() {
										let reviewMsg = review.value;
										let encodedReviewMsg = encodeURIComponent(reviewMsg);
										// console.log(rating);
										// console.log(reviewMsg);
										// console.log(encodedReviewMsg);
										window.location.href = "<?php echo '../../class/addReview.php?inventoryId=' . $productId . '&review='; ?>" + encodedReviewMsg + "<?php echo '&rating='; ?>" + rating;
									}
								</script>
							</div>
						</div>
						<!-- /tab3  -->
					</div>
					<!-- /product tab content  -->
				</div>
			</div>
			<!-- /product tab -->
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
	<script src="js/menu-toggle.js"></script>
</body>

</html>