<?php
    $db->where("id",1);
    $basvuru = $db->getOne("page");
?>
<div id="preloader"></div>
<header>
    <div class="header-upper-area pb-4">
        <div class="header-upper-area p-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 text-left">
                        <?php

                            $db->where("langID",LANGID);
                            $db->where("template","basvuruyap");
                            $bpage = $db->getOne("page");
                            if ($bpage['status']==2) {
                                echo '<a href="'.$bpage['url'].'" class="btn btn-style-2 text-white">'.$bpage['title'].'</a>';
                            }
                            
                        ?>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-7 col-12 text-right">
                        <div class="address-phone">
                            <div class="ap-phone">
                                <p class="phone"><span><i class="fas fa-phone"></i></span> <?php echo $setting['gsm'];?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-sm-12 col-md-12 col-12">
                        <div class="header-social">
                            <ul style="text-align: center">
                                <?php
                                    foreach ($db->get("social") as $item) {
                                        echo '<li><a href="'.$item['url'].'" target="_blank"><i class="'.$item['icon'].'"></i></a></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 d-none d-md-block col-md-2 text-center">
                        <div class="lang-time">
                            <div class="lt-language d-none d-xl-block">
                                <p class="current" style="padding-right: 10px;"><?php echo $db->translate("sayfadili"); ?></p>
                                <ul class="list" style="right: 25%">
                                    <?php
                                    $langSql = $db->get("langs");
                                    foreach ($langSql as $lsP) {
                                        echo '<li><a class="lang" href="'.$lsP['url'].'" data-flag="'.$lsP['img'].'" data-lang="'.$lsP['subtitle'].'">'.$lsP['title'].'</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-12 col-12">
                    <div class="logo">
                        <a href="<?php echo $setting['siteurl']; ?>"><img src="<?php echo THEMEIMG ?>home1/logo.png" alt="" style="min-width: 210px;"></a>
                    </div>
                </div>
                <div class="col-lg-10 offset-lg-0 col-md-8 offset-md-2 col-sm-12 offset-sm-0 col-12">
                    <div class="menu float-right">
                        <nav id="mobile_menu_active">
                            <ul>
                                <?php
                                $db->where("menu_langID",LANGID);
                                $db->where("menu_position",1);
                                $menu = $db->getOne ("menu");
                                $json = json_decode($menu['menu_json']);
                                foreach($json as $k=>$val){
                                    if(count($val->children) > 0){
                                        
                                        echo '<li>';
                                        if ($val->type == "url") {
                                            echo '<a href="'.$val->href.'" target="'.$val->target.'">'.$val->title.' <i class="fa fa-angle-down fa-indicator"></i></a>';
                                        }else{
                                            echo '<a href="'.$db->translate("kategori").'/'.$val->href.'/" target="'.$val->target.'">'.$val->title.' <i class="fa fa-angle-down fa-indicator"></i></a>';
                                        }
                                           
                                            echo '<ul class="drop">';
                                                for ($i=0; $i < count($val->children); $i++) {
                                                if(count($val->children[$i]->children)> 0){
                                                    echo '<li><a href="'.$val->children[$i]->href.'">'.$val->children[$i]->title.'</a></li>';
                                                }
                                                else {
                                                    if($val->children[$i]->type == "sayfa"){
                                                        echo '<li><a href="'.$db->translate("page").'/'.$val->children[$i]->href.'/">'.$val->children[$i]->title.'</a></li>';
                                                    }else if($val->children[$i]->type == "kategori"){
                                                        echo '<li><a href="'.$db->translate("kategori").'/'.$val->children[$i]->href.'/">'.$val->children[$i]->title.'</a></li>';
                                                    }
                                                    else if($val->children[$i]->type == "yazi"){
                                                        echo '<li><a href="'.$db->translate("yazi").'/'.$val->children[$i]->href.'/">'.$val->children[$i]->title.'</a></li>';
                                                    }
                                                    else if($val->children[$i]->type == "url"){
                                                        echo '<li><a href="'.$val->children[$i]->href.'">'.$val->children[$i]->title.'</a></li>';
                                                    }
                                                }
                                            }
                                            echo '</ul>';
                                        echo '</li>';
                                    }
                                    else {
                                        echo '<li>';
                                        if($val->type == "sayfa"){
                                            echo '<a href="'.$val->href.'" target="'.$val->target.'">'.$val->title.' </a>';
                                        }
                                        else if($val->type == "yazi"){
                                            echo '<a href="'.$db->translate("yazi").'/'.$val->href.'/" target="'.$val->target.'">'.$val->title.' </a>';
                                        }
                                        else if($val->type == "kategori"){
                                            echo '<a href="'.$db->translate("kategori").'/'.$val->href.'/" target="'.$val->target.'">'.$val->title.'</a>';
                                        }
                                        else if($val->type == "url"){
                                            echo '<a href="'.$val->href.'" target="'.$val->target.'">'.$val->title.'</a>';
                                        }
                                        echo '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>