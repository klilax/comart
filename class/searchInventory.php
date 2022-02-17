<?php
require_once('Inventory.php');
require_once('Category.php');

if (isset($_GET['query'], $_GET['category'], $_GET['featuredOnly'])) {
    $category = $_GET['category'];
    $featuredRows = Inventory::getAllFeatured($category);
    if ($featuredRows) {
        foreach ($featuredRows as $row) {
            $inventoryId = $row['inventoryId'];
            $name = $row['inventoryName'];
            $price = $row['price'];
            $category = Category::getCategoryName($row['categoryId']);
            //$qty = $row['quantity'];
            $featured = $row['featured'];
            $featuredOnly = true;
            $imgName = $row['imgName'];

            $encoded_name = urlencode($name);

            displayProduct($inventoryId, $name, $encoded_name, $price, $imgName, $category, $featured, $featuredOnly);
        }
    }
} else if (isset($_GET['query'], $_GET['category'])) {
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
            $featuredOnly = false;
            $imgName = $row['imgName'];
            $encoded_name = urlencode($name);

            displayProduct($inventoryId, $name, $encoded_name, $price, $imgName, $category, $featured, $featuredOnly);
        }
    } else {
        echo '<hr>';
        echo '<h3 style="color: var(--danger-color); margin-top: 3rem; text-align: center;">No product found.</h3>';
        echo '<hr>';
    }
}

function displayProduct($inventoryId, $name, $encoded_name, $price, $imgName, $category, $featured, $featuredOnly) {
    echo
    '
        <a href="/comart/src/routes/product.php?inventoryId=' . $inventoryId . '" style="position: relative;">
            <div class="col-md-3 col-xs-6" ';
    if ($featuredOnly) {
        echo 'style = "display: flex; padding-bottom: 3.5rem; width: 100%;"';
    } else {
        echo 'style = "display: flex; padding-bottom: 3.5rem;"';
    }
    echo '>
                <div class="product" ';
    if ($featured == 1) {
        if ($featuredOnly) {
            echo ' style="border: 2px solid var(--secondary-color);"';
        } else {
            // echo ' style="border: 0 solid var(--secondary-color);"';
        }
    }
    echo    '>
                    <div class="product-img">

                        <!-- image path -->
                        <img src="img/';
    if ($imgName == '' || is_null($imgName)) {
        if (Category::getCategoryDefaultImg($category) == '') {
            echo 'imgError.jpg';
        } else {
            echo Category::getCategoryDefaultImg($category);
        }
    } else {
        echo $imgName;
    }
    echo '" ';
    if ($featuredOnly) {
        echo 'style = "width: 263px; height: 175px;"';
    } else {
        echo 'style = "width: 189px; height: 126px;"';
    }
    echo 'alt="">

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
                            <a href="/comart/src/routes/product.php?inventoryId=' . $inventoryId . '" class="quick-view">
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
