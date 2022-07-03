<?php

$db->where("Slug", $_GET['url']);
$kategori = $db->getOne("products_cat");
if (count($kategori) > 0) {

} else {
    header("Location:" . $setting['siteurl'] . "");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags For Seo + Page Optimization -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="İNTERNET TESCİL">
    <!-- description -->
    <meta name="description"
          content="<?php echo $product['ProductStatement']; ?>">
    <!-- keywords -->
    <meta name="keywords"
          content="">
    <!-- Page Title -->
    <title><?php echo $setting['baslik']; ?> | <?php echo $kategori['Title']; ?></title>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo $setting['siteurl'];
    echo THEMEIMG ?>favicon.ico">
    <!-- Bundle -->
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMEVENDOR ?>css/bundle.min.css">
    <!-- Plugin Css -->
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMEVENDOR ?>css>/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMEVENDOR ?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMEVENDOR ?>css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMEVENDOR ?>css/cubeportfolio.min.css">
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMEVENDOR ?>css/wow.css">
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMEVENDOR ?>css/LineIcons.min.css">
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMECSS ?>nouislider.min.css">
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMECSS ?>range-slider.css">
    <!-- Slider Setting Css  -->
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMECSS ?>settings.css">
    <!-- Mega Menu  -->
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMECSS ?>megamenu.css">
    <!-- StyleSheet  -->
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMECSS ?>style.css">
    <!-- Custom Css  -->
    <link rel="stylesheet" href="<?php echo $setting['siteurl'];
    echo THEMECSS ?>custom.css">

</head>
<body>

<a class="scroll-top-arrow" href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>

<!--START LOADER-->
<div class="loader1">
    <div class="loader-inner">
        <div id="preloader">
            <div id="loader"></div>
        </div>
    </div>
</div>
<!--END LOADER-->

<!-- START HEADER NAVIGATION -->
<?php include "inc/header.php" ?>
<!-- END HEADER NAVIGATION -->

<!--Slider Start-->
<div class="paralax-section-slide-data" style="background-image:url('<?php echo $setting['siteurl'];
echo THEMEIMG ?>/banner5.jpg')"></div>
<!--Slider End-->


<!--Product Line Up Start -->
<div class="product-listing">
    <div class="container">
        <div class="row">

            <!-- START STICKY NAV -->

            <!-- END STICKY NAV -->

            <!-- START PRODUCT COL 8 -->
            <div class="col-md-12 col-lg-12 order-1 order-lg-2">
                <div class="row">

                    <!-- START LISTING HEADING -->
                    <div class="col-12 product-listing-heading">
                        <h1 class="heading text-left"><?php echo $kategori['Title'] ?></h1>

                    </div>
                    <!-- END LISTING HEADING -->


                    <!-- START PRODUCT LISTING SECTION -->
                    <div class="col-12 product-listing-products">

                        <!-- START DISPLAY PRODUCT -->
                        <div class="product-list row">

                            <?php
                            $db->where("CategoryID", $kategori['ID']);
                            $products = $db->get("products");
                            foreach ($products as $product_) {
                                ?>
                                <div class="col-12 col-md-6 col-lg-4 manage-color-hover wow slideInUp"
                                     data-wow-delay=".2s">
                                    <div class="product-item owl-theme product-listing-carousel owl-carousel">
                                        <?php
                                        $db->where("CategoryID", $product_['ID']);
                                        $db->where("Type", "product");
                                        $imgs = $db->get("products_meta");
                                        foreach ($imgs as $img) {
                                            ?>
                                            <div class="item p-item-img mb-3">
                                                <img
                                                        src="<?php echo $setting['siteurl']; ?>bwp-content/uploads/product/<?php echo $img['Content'] ?>"
                                                        alt="images">
                                                <div
                                                        class="text-center d-flex justify-content-center align-items-center">
                                                    <a class="listing-cart-icon"
                                                       href="<?php echo $setting['siteurl']; ?>urun/<?php echo $product_['ProductSlug'] ?>/">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                    <div class="p-item-detail">
                                        <h4 class="text-center p-item-name"><a
                                                    href="<?php echo $setting['siteurl']; ?>urun/<?php echo $product_['ProductSlug'] ?>/"> <?php echo $product_['ProductName'] ?> </a>
                                        </h4>
                                        <?php if (is_null($product_['ProductDiscount']) or $product_['ProductDiscount'] == 0) {
                                            echo '<p class="text-center p-item-price">' . $product_['ProductPrice'] . '
                                        TL
                                    </p>';
                                        } else {
                                            echo '<p class="text-center p-item-price">' . $product_['ProductDiscount'] . ' TL <del>' . $product_['ProductPrice'] . '</del>
                                        TL
                                    </p>';
                                        } ?>

                                    </div>
                                </div>

                            <?php }
                            ?>


                        </div>
                        <!-- END DISPLAY PRODUCT -->


                    </div>
                    <!-- END PRODUCT LISTING SECTION -->
                </div>
            </div>
            <!-- END PRODUCT COL 8 -->

        </div>
    </div>
</div>
<!--Product Line Up End-->

<!--footer1 sec start-->
<div class="footer">
    <div class="container">
        <div class="row footer-container">
            <div class="col-sm-12 col-lg-12 f-sec1  text-center text-lg-left">
                <h4 class="high-lighted-heading">BergCandle</h4>
                <p>Eviniz için mükemmel kokuyu ve aydınlatmayı seçerek keyifli anlar yaratabilirsiniz. Dekoratif ve hoş
                    kokulu mumlarımız ile evlerinizin havasını değiştirecek... </p>


            </div>


        </div>
        <div class="row">
            <div class="col-12 footer_notes">
                <p class="whitecolor text-center w-100 wow fadeInDown">&copy; 2022 İnternet Tescil
                </p>
            </div>
        </div>
    </div>
</div>
<!--foo0ter1 sec end-->


<!-- JavaScript -->
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/bundle.min.js"></script>
<!-- Plugin Js -->
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/jquery.fancybox.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/owl.carousel.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/swiper.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/jquery.cubeportfolio.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/wow.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/bootstrap-input-spinner.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/parallaxie.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/stickyfill.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEJS ?>nouislider.min.js"></script>

<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/jquery.themepunch.revolution.min.js"></script>
<!-- SLIDER REVOLUTION EXTENSIONS -->
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.actions.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.carousel.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.migration.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.navigation.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.parallax.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="<?php echo $setting['siteurl'];
echo THEMEVENDOR ?>js/extensions/revolution.extension.video.min.js"></script>

<!-- Custom Script -->
<script src="<?php echo $setting['siteurl'];
echo THEMEJS ?>script.js"></script>
</body>
</html>