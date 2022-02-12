<?php
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
}
?>
<!-- TOP HEADER -->
<div id="top-header">
    <div class="container">
        <ul class="header-links pull-left">
            <li><a href="#"><i class="fa fa-phone"></i>+251-9-11-11-11-11</a></li>
            <li><a href="#"><i class="fa fa-envelope-o"></i>comart@gmail.com</a></li>
            <li><a href="#"><i class="fa fa-map-marker"></i>Addis Ababa, Ethiopia</a></li>
        </ul>
        <ul class="header-links pull-right">
            <li>
                <a href="
                    <?php
                    if (isset($user)) {
                        switch ($user->getRole()) {
                            case 'admin':
                                echo '/comart/admin/index.php';
                                break;
                            case 'vendor':
                                echo '/comart/vendor/index.php';
                                break;
                            case 'buyer':
                                echo '/comart/index.php';
                                break;
                        }
                    } else {
                        echo '/comart/src/routes/auth/signin.php';
                    }
                    ?>
                ">
                    <i class="fa fa-user-o"></i>
                    <?php
                    if (isset($user)) {
                        echo strtoupper($user->getUsername());
                    } else {
                        echo 'Sign In / Sign Up';
                    }
                    ?>
                </a>
            </li>'

            <?php
            if (isset($user)) {
                echo
                '<li>
                    <a href="/comart/src/routes/auth/signout.php">
                        <i class="fa fa-sign-out"></i>
                        Sign Out
                    </a>
                </li>';
            }
            ?>
        </ul>
    </div>
</div>
<!-- /TOP HEADER -->