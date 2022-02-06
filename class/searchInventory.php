<?php
require_once('Inventory.php');
require_once('Category.php');

if (isset($_GET['query'], $_GET['category'])) {
    $query = $_GET['query'];
    $query = "%$query%";
    $category = $_GET['category'];
    $rows = Inventory::searchInventory($category, $query);
    if ($rows) {
        foreach ($rows as $row) {
            $inventoryId = $row['inventoryId'];
            $name = $row['inventoryName'];
            $price = $row['price'];
            $category = Category::getCategoryName($row['categoryId']);
            //$qty = $row['quantity'];
            $featured = $row['featured'];

            $encoded_name = urlencode($name);

            // echo '<tr>';
            // echo '<td>' . $inventoryId . '</td>';
            // echo '<td>' . $name . '</td>';
            // echo '<td>' . $price . '</td>';
            // echo '<td>' . $qty . '</td>';
            // echo '<td><a href="../class/Cart.php?inventoryId=' . $inventoryId . '&productName=' . $encoded_name . '&price=' . $price . '"><button type="button">Add to cart</button></a></td>';

            echo '
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


            <!-- link go to product page -->
            <a href="#">
                <div class="col-md-3 col-xs-6" style="padding-bottom: 3.5rem;">
                    <div class="product">
                        <div class="product-img">

                            <!-- image path -->
                            <img src="img/product01.png" alt="">

                            <!-- featured or not -->
                            ';
            if ($featured == 1) {
                echo '
                            <div class="product-label">
                                <span class="new">FEATURED</span>
                            </div>
                    ';
            }
            echo '
                        </div>
                        <div class="product-body">
                            <p class="product-category">' . $category . '</p>
                            <h3 class="product-name"><a href="#">' . $name . '</a></h3>
                            <h4 class="product-price">' . $price . '</h4>

                            <!-- review - rating -->
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>

                            <div class="product-btns">
                                <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                view</span></button>
                            </div>
                        </div>
                        <div class="add-to-cart">
                            <a href="../class/Cart.php?inventoryId=' . $inventoryId . '&productName=' . $encoded_name . '&price=' . $price . '">
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
    } else {
        echo "<hr>";
        echo "<h2 colspan=5 style='color: var(--danger-color); text-align: center;'> The product your searched can not be found.</h2>";
        echo "<hr>";
    }

    echo '
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
    ';
}
