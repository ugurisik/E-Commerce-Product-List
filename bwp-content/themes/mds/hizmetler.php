<?php
$db->where("langID", LANGID);
$db->where("url", $_GET['type']);
$page = $db->getOne("page");

$db->where("langID", LANGID);
$db->where("template", "hizmetcat");
$caturl = $db->getOne("page");
?>
<!DOCTYPE html>
<html lang="<?php echo mb_strtolower($_SESSION['dil']); ?>-<?php echo mb_strtoupper($_SESSION['dil']); ?>">

<head>
    <base href="<?php echo $setting['siteurl']; ?>"/>
    <meta charset="utf-8">
    <title><?php echo $page['title']; ?></title>
    <meta name="title" content="<?php echo $setting['baslik']; ?>">
    <meta name="description" content="<?php echo $setting['aciklama']; ?>">
    <meta name="keywords" content="<?php echo $setting['keywords']; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>flaticon.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>pogo-slider.min.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>magnific-popup.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>animate.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>meanmenu.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>style.css">
    <link rel="stylesheet" href="<?php echo THEMECSS ?>responsive.css">
    <link rel="shortcut icon" type="image/png" href="<?php echo THEMEIMG ?>favicon.ico">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .bullet-list a {
            font-size: 14px;
        }
    </style>
</head>

<body>
<?php include "inc/header_.php"; ?>
<div class="breadcumb-area bg-with-black">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb">
                    <h2 class="name"><?php echo $page['title']; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-blog-details-area">
    <div class="container">
        <div class="row">
            <?php
            $db->where("langID", LANGID);
            $db->where("catID", 0);
            $mainCat = $db->getOne("servicecat");

            $db->where("catID", $mainCat['id']);
            $subCat = $db->get("servicecat");
            foreach ($subCat as $item) {
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <?php echo $item['title']; ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <ul class="bullet-list">
                                        <?php
                                        $db->where("catID", $item['id']);
                                        $subCat1 = $db->get("servicecat");
                                        foreach ($subCat1 as $item1) {
                                            $db->where("catID", $item1['id']);
                                            $subCat2 = $db->get("servicecat");
                                            if (count($subCat2) > 0) {
                                                echo '<li><a class="links" href="' . $caturl['url'] . '/' . $item1['url'] . '/">' . $item1['title'] . '</a>';
                                                echo '<ul>';
                                                foreach ($subCat2 as $item2) {
                                                    $db->where("catID", $item2['id']);
                                                    $subCat3 = $db->get("servicecat");
                                                    if (count($subCat3) > 0) {
                                                        echo '<li><a class="links" href="' . $caturl['url'] . '/' . $item2['url'] . '/">' . $item2['title'] . '</a>';
                                                        echo '<ul>';
                                                        foreach ($subCat3 as $item3) {
                                                            echo '<li><a class="links" href="' . $caturl['url'] . '/' . $item3['url'] . '/">' . $item3['title'] . '</a></li>';
                                                        }
                                                        echo '</ul>';
                                                        echo '</li>';
                                                    } else {
                                                        echo '<li><a  class="links" href="' . $caturl['url'] . '/' . $item2['url'] . '/">' . $item2['title'] . '</a></li>';
                                                    }
                                                }
                                                echo '</ul>';
                                                echo '</li>';
                                            } else {
                                                echo '<li><a class="links" href="' . $caturl['url'] . '/' . $item1['url'] . '/">' . $item1['title'] . '</a></li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    asdas
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
<script src="<?php echo THEMEJS ?>jquery-3.2.0.min.js"></script>
<script src="<?php echo THEMEJS ?>jquery-ui.js"></script>
<script src="<?php echo THEMEJS ?>owl.carousel.min.js"></script>
<script src="<?php echo THEMEJS ?>jquery.pogo-slider.min.js"></script>
<script src="<?php echo THEMEJS ?>jquery.counterup.min.js"></script>
<script src="<?php echo THEMEJS ?>parallax.js"></script>
<script src="<?php echo THEMEJS ?>countdown.js"></script>
<script src="<?php echo THEMEJS ?>jquery.fancybox.min.js"></script>
<script src="<?php echo THEMEJS ?>imagesLoaded-PACKAGED.js"></script>
<script src="<?php echo THEMEJS ?>isotope-packaged.js"></script>
<script src="<?php echo THEMEJS ?>jquery.meanmenu.js"></script>
<script src="<?php echo THEMEJS ?>jquery.scrollUp.js"></script>
<script src="<?php echo THEMEJS ?>jquery.magnific-popup.min.js"></script>
<script src="<?php echo THEMEJS ?>jquery.mixitup.min.js"></script>
<script src="<?php echo THEMEJS ?>jquery.waypoints.min.js"></script>
<script src="<?php echo THEMEJS ?>popper.min.js"></script>
<script src="<?php echo THEMEJS ?>bootstrap.min.js"></script>
<script src="<?php echo THEMEJS ?>theme.js"></script>
</body>

</html>