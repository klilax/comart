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

            echo
            '
            <a href="/comart/src/routes/product.php?inventoryId=' . $inventoryId . '&productName=' . $encoded_name . '&price=' . $price . '">
                <div class="col-md-3 col-xs-6" style="padding-bottom: 3.5rem;">
                    <div class="product" ';
            if ($featured == 1) {
                echo ' style="border: 2px solid var(--secondary-color);"';
            }
            echo '>
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
                            <h4 class="product-price">' . $price . ' Birr</h4>

                            <!-- review - rating -->
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>

                            <div class="product-btns">
                                <a href="/comart/src/routes/product.php?inventoryId=' . $inventoryId . '&productName=' . $encoded_name . '&price=' . $price . '" class="quick-view">
                                    <i class="fa fa-eye" title="Quick View"></i>
                                    <span class="tooltipp"></span>
                                </a>
                            </div>
                        </div>
                        <div class="add-to-cart">
                            <a href="/comart/class/Cart.php?inventoryId=' . $inventoryId . '&productName=' . $encoded_name . '&price=' . $price . '">
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
        echo '<hr>';
        echo '<h2 style="color: var(--danger-color); margin-top: 3rem; text-align: center;"> The product you searched can not be found.</h2>';
        echo '<hr>';
    }
}
