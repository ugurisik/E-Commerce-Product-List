<?php

$url = $_GET['url'];
$db->where("ProductSlug", $url);
$product = $db->getOne("products");
if (count($product) > 0) {

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
    <title><?php echo $setting['baslik']; ?> | <?php echo $product['ProductName']; ?></title>
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

<!-- START HEADING SECTION -->
<div class="about_content">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="product-body">

                    <div class="pro-detail-sec row">
                        <div class="col-12">
                            <h4 class="pro-heading text-center text-lg-left"><?php echo $product['ProductName']; ?></h4>

                        </div>
                    </div>
                    <div class="row product-list product-detail">

                        <div class="col-12 col-lg-6 product-detail-slider">
                            <div class="wrapper">
                                <div class="Gallery swiper-container img-magnifier-container" id="gallery">
                                    <div class="swiper-wrapper myimgs">
                                        <?php
                                        $db->where("CategoryID", $product['ID']);
                                        $db->where("Type", "product");
                                        $imgs = $db->get("products_meta");
                                        $c = 0;
                                        foreach ($imgs as $img) {
                                            $c++;

                                            ?>
                                            <div class="swiper-slide"><a
                                                        href="<?php echo $product['ProductLink'] ?>"
                                                        data-fancybox="<?php echo $c; ?>"
                                                        title="Zoom In"><img class="myimage"
                                                                             src="<?php echo $setting['siteurl']; ?>bwp-content/uploads/product/<?php echo $img['Content'] ?>"
                                                                             alt="gallery"/></a></div>
                                        <?php }
                                        ?>

                                    </div>
                                </div>
                                <div class="Thumbs swiper-container" id="thumbs">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $db->where("CategoryID", $product['ID']);
                                        $db->where("Type", "product");
                                        $imgs = $db->get("products_meta");
                                        $c = 0;
                                        foreach ($imgs as $img) {
                                            $c++;

                                            ?>
                                            <div class="swiper-slide"><img
                                                        src="<?php echo $setting['siteurl']; ?>bwp-content/uploads/product/<?php echo $img['Content'] ?>"
                                                        alt="thumnails"/>
                                            </div>
                                        <?php }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 text-center text-lg-left">
                            <div class="product-single-price">
                                <?php
                                if (is_null($product['ProductDiscount']) or $product['ProductDiscount'] == 0) {
                                    echo '<h4><span class="real-price">' . $product['ProductPrice'] . ' TL</span></h4>';
                                } else {
                                    echo '<h4><span class="real-price">' . $product['ProductDiscount'] . ' TL</span> <span><del>' . $product['ProductPrice'] . ' TL</del></span></h4>';
                                }
                                ?>

                                <p class="pro-description"><?php echo $product['ProductStatement']; ?></p>
                            </div>

                            <div class="row product-quantity input_plus_mins no-gutters">
                                <div class="col-12 col-lg-9">
                                    <a href="<?php echo $product['ProductLink']; ?>">
                                        <button class="btn pink-gradient-btn-into-black">Satın Al</button>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>

                            <div class="product-tags-list">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">

                                        <li class="breadcrumb-item">
                                            <span class="d-inline">Kategori: <a
                                                        href="#"><?php $db->where("ID", $product['CategoryID']);
                                                    $category = $db->getOne("products_cat");
                                                    echo $category['Title']; ?></a></span>
                                        </li>

                                    </ol>
                                </nav>
                            </div>


                        </div>


                    </div>


                </div>

            </div>
        </div>
    </div>

</div>
<!-- END HEADING SECTION -->


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