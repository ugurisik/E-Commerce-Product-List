<div class="header-area">
    <div class="container">
        <div class="row upper-nav">
            <!-- SOCIAL MEDIA -->
            <div class="col-3 nav-icon pt-3">
                
            </div>

            <!-- LOGO -->
            <div class="col-6 text-center nav-logo pt-3">
                <?php

                ?>
                <a href="<?php echo $setting['siteurl'] ?>" class="navbar-brand"><img
                            src="https://bergcandle.com/bwp-content/themes/mds/assets/img/logo.png"
                            alt="img" style="max-width: 120px"></a>
            </div>
            <div class="col-12 nav-mega">
                <header class="site-header" id="header">
                    <nav class="navbar navbar-expand-md  static-nav">
                        <div class="container position-relative megamenu-custom">
                            <a class="navbar-brand center-brand" href="<?php echo $setting['siteurl'] ?>">
                                <img src="<?php echo THEMEIMG ?>logo.jpg" alt="logo" class="logo-scrolled">
                            </a>
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav ml-auto mr-auto">
                                    <?php

                                    //                                    function multilevel_menu($db, $c, $parent_id = 0)
                                    //                                    {
                                    //
                                    //                                        $menu = "";
                                    //
                                    //                                        $db->where("CategoryID", $parent_id);
                                    //                                        $cats = $db->get("products_cat");
                                    //                                        foreach ($cats as $cat) {
                                    //
                                    //                                            $db->where("CategoryID", $cat['ID']);
                                    //                                            $catsa = $db->get("products_cat");
                                    //                                            if (count($catsa) > 0) {
                                    //                                                $menu .= '<li class="nav-item dropdown position-relative"><a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                    //                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $cat["Title"] . '</a>';
                                    //                                            } else {
                                    //                                                $menu .= '<li class="nav-item" >' . '<a class="nav-link" href="index-shop.html">' . $cat['Title'] . '</a>';
                                    //                                            }
                                    //
                                    //                                            $db->where("CategoryID", $cat['ID']);
                                    //                                            $subcats = $db->get("products_cat");
                                    //
                                    //                                            if (count($subcats) > 0) {
                                    //                                                $menu .= '<div class="dropdown-menu"><ul>' . multilevel_menu($db, $cat["ID"]) . '</ul></div>';
                                    //                                            } else {
                                    //                                                $menu .= multilevel_menu($db, $cat["ID"]);
                                    //                                            }
                                    //                                            $menu .= "</li>";
                                    //                                        }
                                    //                                        $c++;
                                    //                                        return $menu;
                                    //                                    }
                                    //
                                    //                                    echo multilevel_menu($db, 0);

                                    //                                    $cats = $db->get("products_cat");
                                    //
                                    //                                    foreach ($cats as $cat) {
                                    //                                        $db->where("CategoryID", $cat['ID']);
                                    //                                        $firstcat = $db->get("products_cat");
                                    //
                                    //                                        if (count($firstcat) > 0) {
                                    //                                            echo '<li class="nav-item dropdown position-relative">
                                    //                                                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                    //                                                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $cat['Title'] . '</a>
                                    //                                                                            <div class="dropdown-menu">
                                    //                                                                                <ul>';
                                    //                                            foreach ($firstcat as $first) {
                                    //                                                echo '<li><i class="lni-angle-double-right right-arrow"></i><a
                                    //                                                                                                class="dropdown-item" href="product-listing.html">' . $first['Title'] . ' </a></li>';
                                    //                                            }
                                    //                                            echo ' </div></li>';
                                    //                                        } else {
                                    //                                            if ($cat['CategoryID'] == 0) {
                                    //                                                echo '<li class="nav-item">
                                    //                                        <a class="nav-link" href="index-shop.html">' . $cat['Title'] . '  </a >
                                    //                                    </li > ';
                                    //                                            }
                                    //
                                    //                                        }
                                    //
                                    //                                    }


                                    $db->where("CategoryID", 0);
                                    $cats = $db->get("products_cat");

                                    foreach ($cats as $cat) {
                                        $db->where("CategoryID", $cat['ID']);
                                        $subcats = $db->get("products_cat");
                                        if (count($subcats) > 0) {
                                            echo ' <li class="nav-item dropdown position-relative">
                                        <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $cat['Title'] . '</a>
                                        <div class="dropdown-menu">
                                            <ul>';
                                            foreach ($subcats as $subcat) {
                                                echo ' <li><i class="lni-angle-double-right right-arrow"></i><a
                                                            class="dropdown-item" href="' . $setting['siteurl'] . 'kategori/' . $subcat['Slug'] . '/">' . $subcat['Title'] . '</a></li>';
                                            }
                                            echo '</ul>
                                        </div>
                                    </li>';
                                        } else {
                                            if ($cat['Slug'] == "ana-sayfa") {
                                                echo '<li class="nav-item">
                                        <a class="nav-link" href="' . $setting['siteurl'] . $cat['Slug'] . '">' . $cat['Title'] . '</a>
                                    </li>';
                                            } else {
                                                echo '<li class="nav-item">
                                        <a class="nav-link" href="' . $setting['siteurl'] . 'kategori/' . $cat['Slug'] . '/">' . $cat['Title'] . '</a>
                                    </li>';
                                            }

                                        }
                                    }

                                    ?>
                                    <!--                                    <li class="nav-item">-->
                                    <!--                                        <a class="nav-link" href="index-shop.html">HOME</a>-->
                                    <!--                                    </li>-->
                                    <!---->
                                    <!--                                    <li class="nav-item dropdown position-relative">-->
                                    <!--                                        <a class="nav-link dropdown-toggle" href="javascript:void(0)"-->
                                    <!--                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PAGES</a>-->
                                    <!--                                        <div class="dropdown-menu">-->
                                    <!--                                            <ul>-->
                                    <!--                                                <li><i class="lni-angle-double-right right-arrow"></i><a-->
                                    <!--                                                            class="dropdown-item" href="product-listing.html">Listing-->
                                    <!--                                                        One</a></li>-->
                                    <!--                                                <li><i class="lni-angle-double-right right-arrow"></i><a-->
                                    <!--                                                            class="dropdown-item" href="product-detail.html">Detail-->
                                    <!--                                                        Page</a></li>-->
                                    <!--                                                <li><i class="lni-angle-double-right right-arrow"></i><a-->
                                    <!--                                                            class="dropdown-item" href="standalone.html">StandAlone-->
                                    <!--                                                        Page</a></li>-->
                                    <!--                                            </ul>-->
                                    <!--                                        </div>-->
                                    <!--                                    </li>-->
                                    <!--                                    <li class="nav-item">-->
                                    <!--                                        <a class="nav-link" href="contact.html">CONTACT</a>-->
                                    <!--                                    </li>-->

                                </ul>
                            </div>
                        </div>
                        <!--side menu open button-->
                        <a href="javascript:void(0)" class="d-inline-block sidemenu_btn d-lg-none d-md-block"
                           id="sidemenu_toggle">
                            <span></span> <span></span> <span></span>
                        </a>
                    </nav>


                </header>
            </div>
        </div>
    </div>
</div>
