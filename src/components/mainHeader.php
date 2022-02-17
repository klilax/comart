<?php
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
}
?>
<!-- MAIN HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row d-flex" style="display:flex; flex-wrap:wrap;">
            <!-- LOGO -->
            <div class="col-md-6" style="flex: 2;">
                <div class=" header-logo">
                    <a href="\index.php" class="logo">
                        <img src="\img\logo.svg" alt="">
                    </a>
                </div>
            </div>
            <!-- /LOGO -->
            <!-- SEARCH BAR -->
            <?php
            if (!isset($user)) {
                echo
                '<div class="col-md-6" style="flex: 3;">
                    <div class="header-search" style="min-width: 520px;">
                        <form>
                            <input class="input" placeholder="Search here" style="border-radius: 2rem 0 0 2rem;">
                            <button class="search-btn">Search</button>
                        </form>
                    </div>
                </div>';
            } else {
                if ($user->getRole() == 'admin') {
                    echo
                    '<div class="col-md-6" style="flex: 3;">
                        <h2 style= "padding-top: 1rem; color: var(--secondary-color); margin-top: 10px; margin-left: 15%;">Admin Dashboard</h2>
                    </div>';
                } else if ($user->getRole() == 'vendor') {
                    echo
                    '<div class="col-md-6" style="flex: 3;">
                        <h2 style= "padding-top: 1rem; color: var(--secondary-color); margin-top: 10px; margin-left: 15%;">Vendor Dashboard</h2>
                    </div>';
                }
            }
            ?>
            <!-- /SEARCH BAR -->

            <!-- ACCOUNT -->
            <div class="col-md-3 clearfix" style="flex: 1;">
                <div class="header-ctn">
                    <!-- Cart -->
                    <?php
                    $itemQty = 0;
                    if (isset($_SESSION['cartId'])) {
                        $itemQty = $_SESSION['cart']['count'];
                    }
                    if (!isset($user) || $user->getRole() == 'buyer') {
                        echo '
                        <div class="dropdown">
                            <a href="../routes/checkout.php">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your Cart</span>
                                <div class="qty">'. $itemQty . '</div>
                            </a>
                        </div>';
                    } else if ($user->getRole() != 'admin') {
                        echo '
                        <div>
                            <a href="/src/routes/auth/account.php">
                                <i class="fa fa-cog"></i>
                                <span>Edit Profile</span>
                            </a>
                        </div>';
                    }
                    ?>
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
<!-- /MAIN HEADER -->