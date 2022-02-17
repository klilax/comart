<?php

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
            <div class="row">
                <div style=" display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <h2 class="h2 text-center">This page is under construction.</h2>
                    <p class="h4"><a href="../../index.php" style="text-decoration: underline; color: var(--secondary-color);">Go to Home</a></p>
                </div>
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->
    </div>

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