<?php
require_once('../../class/User.php');
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
}
?>
<!-- MAIN HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class="col-md-3">
                <div class="header-logo">
                    <a href="\comart\index.php" class="logo">
                        <img src="\comart\img\logo.svg" alt="">
                    </a>
                </div>
            </div>
            <!-- /LOGO -->
            <!-- SEARCH BAR -->
            <?php
            if (!isset($user)) {
                echo '<div class="col-md-6">
                        <div class="header-search">
                            <form>
                                <select class="input-select">
                                    <option value="0">All Categories</option>
                                    <option value="1">Category 01</option>
                                    <option value="1">Category 02</option>
                                </select>
                                <input class="input" placeholder="Search here">
                                <button class="search-btn">Search</button>
                            </form>
                        </div>
                    </div>';
            } else {
                if ($user->getRole() == 'admin') {
                    echo '<h1 style= "color: var(--secondary-color);
                        margin-top: 10px;
                        margin-left: 15%;">
                        Admin Dashboard
                    </h1>';
                }
                // else if ($user->getRole() == 'vendor') {
                //     echo '<h1 style= "color: green;
                //         margin-top: 10px;
                //         margin-left: 15%;">
                //         Vendor Dashboard
                //     </h1>';
                // }
            }
            ?>
            <!-- /SEARCH BAR -->



            <!-- ACCOUNT -->
            <div class="col-md-3 clearfix">
                <div class="header-ctn">
                    <!-- Cart -->
                    <?php
                    if (!isset($user) || $user->getRole() == 'buyer') {
                        echo '
                        <div class="dropdown">
                            <a href="../routes/checkout.php" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your Cart</span>
                                <div class="qty">3</div>
                            </a>
                        </div>';
                    }
                    ?>
                    <!-- /Cart -->

                    <!-- Menu Toogle -->
                    <div class="menu-toggle">
                        <a href="#">
                            <i class="fa fa-bars"></i>
                            <span>Menu</span>
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
<!-- /MAIN HEADER -->