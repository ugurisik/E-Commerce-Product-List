<?php
session_start();
include '../bwp-includes/settings.php';
if ($_SESSION['loggedin'] == true) {
    $db->where("email", $_SESSION["email"]);
    $userKont = $db->getOne("users");
    if ($userKont['loginID'] == $_SESSION['loginid']) {
        $pageTitle = "Ürün Yönetimi";
        $mpage = "coinlist";
        $processTitle = "Liste";
        $process = $_GET['process'];
        $id = $_GET['id'];
        $markid = $_GET['markid'];
        if (isset($id)) {
            $db->where("ID", $id);
            $coininfo = $db->getOne("coin_info");

            if (isset($markid)) {
                $db->where("ID", $markid);
                $db->delete("coin_mark");
            }
        }

        if ($_GET['delete']) {
            $db->where("ID", $_GET['metaid']);
            $db->delete("products_meta");
        }
        ?>

        <!DOCTYPE html>
        <html lang="tr">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>

        <head>
            <meta charset="utf-8"/>
            <title><?php echo $pageTitle; ?> - <?php echo $panelTitle; ?></title>
            <meta name="description" content="No subheader example">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet"
                  href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
            <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
            <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
            <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
        </head>

        <body class="kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-aside--enabled kt-aside--fixed kt-page--loading">
        <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
            <div class="kt-header-mobile__logo">
                <a href="index.html">
                    <img alt="Logo" src="assets/media/logos/logo-12.png" style="max-width: 100px;"/>
                </a>
            </div>
            <div class="kt-header-mobile__toolbar">
                <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left"
                        id="kt_aside_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                            class="flaticon-more"></i></button>
            </div>
        </div>
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
                <?php include 'inc/menu.php'; ?>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    <?php include 'inc/header.php'; ?>
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            <?php if ($process == "edit") { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="coinUpdate">
                                            <div class="kt-portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">
                                                            <?= $coininfo['CoinName'] ?>
                                                        </h3>
                                                        <input type="hidden" name="CoinName"
                                                               value=" <?= $coininfo['CoinName'] ?>">
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="form-group">
                                                        <label>Alım Yeri</label>
                                                        <input type="text" class="form-control" name="CoinPurchase"
                                                               maxlength="65"
                                                               value="<?php echo $coininfo['CoinPurchase']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Stop Yeri</label>
                                                        <input type="text" class="form-control" name="CoinStop"
                                                               maxlength="154"
                                                               value="<?php echo $coininfo['CoinStop']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Satış Hedefleri</label>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <button type="button" class="btn btn-dark"
                                                                        name="addMark"><i class="fa fa-add"></i> Hedef
                                                                    Ekle
                                                                </button>
                                                            </div>
                                                            <div class="col-md-12 marks ">
                                                                <?php

                                                                $db->where("CoinID", $coininfo['ID']);
                                                                $coinmark = $db->get("coin_mark");

                                                                foreach ($coinmark as $key) {


                                                                    ?>
                                                                    <div class="row mark_ mb-3">
                                                                        <div class="col-md-6">
                                                                            <input type="text"
                                                                                   class="form-control float"
                                                                                   name="CoinMarks[]" maxlength="15"
                                                                                   value="<?= $key['CoinValue'] ?>">
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <select class="form-control kt-selectpicker"
                                                                                    name="status[]">
                                                                                <?php
                                                                                $db->where("StatusType", "status");
                                                                                $status = $db->get('coin_status');
                                                                                foreach ($status as $statu) {
                                                                                    if ($key['CoinStatus'] == $statu['ID']) {
                                                                                        echo '<option value="' . $statu['ID'] . '" selected>' . $statu['StatusName'] . '</option>';
                                                                                    } else {
                                                                                        echo '<option value="' . $statu['ID'] . '">' . $statu['StatusName'] . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <!-- <a href="?process=edit&id=<?= $coininfo['ID'] ?>&markid=<?= $key['ID'] ?>" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-remove"></i></a> -->
                                                                            <button type="button"
                                                                                    class="btn btn-error btn-sm"
                                                                                    data-id="<?= $key['ID'] ?>"
                                                                                    data-type="deletemark" name="set"><i
                                                                                        class="la la-remove"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <!-- <input id="kt_tagify_1" name="CoinMarks" placeholder="Hedefler..." autofocus value="">  -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kullanıcı Tipi</label>
                                                        <select class="form-control kt-selectpicker" name="price">
                                                            <?php
                                                            $db->where("StatusType", "price");
                                                            $status = $db->get('coin_status');
                                                            foreach ($status as $statu) {
                                                                if ($coininfo['StatusID'] == $statu['ID']) {
                                                                    echo '<option value="' . $statu['ID'] . '" selected>' . $statu['StatusName'] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $statu['ID'] . '">' . $statu['StatusName'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Oluşturulma Tarihi</label>
                                                        <input type="text" class="form-control" name="CreateDate"
                                                               maxlength="154" disabled
                                                               value="<?php echo $coininfo['CreateDate']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Güncelleme Tarihi</label>
                                                        <input type="text" class="form-control" name="UpdateDate"
                                                               maxlength="154" disabled
                                                               value="<?php echo $coininfo['UpdateDate']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-dark"
                                                                data-id="<?php echo $coininfo['ID']; ?>"
                                                                data-type="edit" name="set"><i class="fa fa-edit"></i>
                                                            Kaydet
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } else if ($process == "kategori") { ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon">
                                                <i class="kt-font-brand fa fa-newspaper"></i>
                                            </span>
                                                    <h3 class="kt-portlet__head-title"><?php echo $processTitle; ?></h3>
                                                </div>

                                            </div>
                                            <div class="kt-portlet__body">
                                                <table class="table table-striped- table-bordered table-hover table-checkable"
                                                       id="kt_table_1">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Kategori Tipi</th>
                                                        <th>Kategori Başlığı</th>
                                                        <th>İşlemler</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <form id="userForm" enctype="multipart/form-data">
                                            <div class="kt-portlet kt-portlet--mobile">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon"><i
                                                                class="fa fa-plus"></i></span>
                                                        <h3 class="kt-portlet__head-title">
                                                            <?php echo 'Kategori Ekle'; ?>
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-wrapper">
                                                            <div class="kt-portlet__head-actions">
                                                                <button type="button" class="btn btn-success"
                                                                        data-type="kategoriadd" name="set"><i
                                                                            class="fa fa-plus"></i> Ekle
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Kategori Başlığı</label>
                                                                <input type="text" class="form-control" name="title"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Kategori Tipi</label>
                                                                <select class="form-control kt-selectpicker"
                                                                        name="catID">
                                                                    <option value="0">Ana Kategori</option>
                                                                    <?php
                                                                    $anaKat = $db->get("products_cat");
                                                                    foreach ($anaKat as $p) {
                                                                        echo '<option value="' . $p['ID'] . '">' . $p['Title'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } else if ($process == "kategoriedit") {
                                $db->where("ID", $id);
                                $kategori = $db->getOne("products_cat");
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form id="userForm" enctype="multipart/form-data">
                                            <div class="kt-portlet kt-portlet--mobile">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon"><i
                                                                class="fa fa-plus"></i></span>
                                                        <h3 class="kt-portlet__head-title">
                                                            <?php echo 'Kategori Düzenle'; ?>
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-wrapper">
                                                            <div class="kt-portlet__head-actions">
                                                                <button type="button" class="btn btn-success"
                                                                        data-type="kategoriedit"
                                                                        data-id="<?= $kategori['ID']; ?>"
                                                                        name="set"><i
                                                                            class="fa fa-plus"></i> Düzenle
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Kategori Başlığı</label>
                                                                <input type="text" class="form-control" name="title"
                                                                       value="<?= $kategori['Title']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Kategori Tipi</label>
                                                                <select class="form-control kt-selectpicker"
                                                                        name="catID">
                                                                    <option value="0">Ana Kategori</option>
                                                                    <?php
                                                                    $anaKat = $db->get("products_cat");
                                                                    foreach ($anaKat as $p) {
                                                                        if ($p['ID'] == $kategori['ID']) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        }
                                                                        echo '<option ' . $selected . ' value="' . $p['ID'] . '">' . $p['Title'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } else if ($process == "product") { ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon">
                                                <i class="kt-font-brand fa fa-newspaper"></i>
                                            </span>
                                                    <h3 class="kt-portlet__head-title"><?php echo $processTitle; ?></h3>
                                                </div>

                                            </div>
                                            <div class="kt-portlet__body">
                                                <table class="table table-striped- table-bordered table-hover table-checkable"
                                                       id="kt_table_1">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Kategori</th>
                                                        <th>Ürün Adı</th>
                                                        <th>Ürün Fiyatı</th>
                                                        <th>İndirimli Fiyatı</th>
                                                        <th>Ürün Açıklaması</th>
                                                        <th>Ürün Linki</th>
                                                        <th>İşlem</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <form id="userForm" enctype="multipart/form-data">
                                            <div class="kt-portlet kt-portlet--mobile">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon"><i
                                                                class="fa fa-plus"></i></span>
                                                        <h3 class="kt-portlet__head-title">
                                                            <?php echo 'Ürün Ekle'; ?>
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-wrapper">
                                                            <div class="kt-portlet__head-actions">
                                                                <button type="button" class="btn btn-success"
                                                                        data-type="productadd" name="set"><i
                                                                            class="fa fa-plus"></i> Ekle
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Ürün Başlığı</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductName"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Eklenecek Kategori</label>
                                                                <select class="form-control kt-selectpicker"
                                                                        name="CategoryID">
                                                                    <?php
                                                                    $anaKat = $db->get("products_cat");
                                                                    foreach ($anaKat as $p) {
                                                                        echo '<option value="' . $p['ID'] . '">' . $p['Title'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Satış Fiyatı</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductPrice"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>İndirimli Fiyatı</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductDiscount"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Açıklama Alanı</label>
                                                                <textarea name="ProductStatement"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Ürün Linki</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductLink"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } else if ($process == "productedit") {
                                $db->where("ID", $id);
                                $product = $db->getOne("products");
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <form id="userForm" enctype="multipart/form-data">
                                            <div class="kt-portlet kt-portlet--mobile">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon"><i
                                                                class="fa fa-plus"></i></span>
                                                        <h3 class="kt-portlet__head-title">
                                                            <?php echo 'Ürün Ekle'; ?>
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-wrapper">
                                                            <div class="kt-portlet__head-actions">
                                                                <button type="button" class="btn btn-success"
                                                                        data-type="productedit"
                                                                        data-id="<?= $_GET['id'] ?>" name="set"><i
                                                                            class="fa fa-plus"></i> Düzenle
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Seo Link</label>
                                                                <input disabled type="text" class="form-control"
                                                                       name="ProductSlug"
                                                                       value="<?= $product['ProductSlug'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Ürün Başlığı</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductName"
                                                                       value="<?= $product['ProductName'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Eklenecek Kategori</label>
                                                                <select class="form-control kt-selectpicker"
                                                                        name="CategoryID">
                                                                    <?php
                                                                    $anaKat = $db->get("products_cat");
                                                                    foreach ($anaKat as $p) {
                                                                        if ($p['ID'] == $product['CategoryID']) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        }
                                                                        echo '<option ' . $selected . ' value="' . $p['ID'] . '">' . $p['Title'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Satış Fiyatı</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductPrice"
                                                                       value="<?= $product['ProductPrice'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>İndirimli Fiyatı</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductDiscount"
                                                                       value="<?= $product['ProductDiscount'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Açıklama Alanı</label>
                                                                <textarea
                                                                        name="ProductStatement"><?= $product['ProductStatement'] ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Ürün Linki</label>
                                                                <input type="text" class="form-control"
                                                                       name="ProductLink"
                                                                       value="<?= $product['ProductLink'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-sm-6">
                                        <form id="userForm" enctype="multipart/form-data">
                                            <div class="kt-portlet kt-portlet--mobile">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon"><i
                                                                class="fa fa-plus"></i></span>
                                                        <h3 class="kt-portlet__head-title">
                                                            <?php echo 'Görsel Ekle'; ?>
                                                        </h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-wrapper">
                                                            <div class="kt-portlet__head-actions">
                                                                <button type="button" class="btn btn-success"
                                                                        data-type="productadd" name="set"><i
                                                                            class="fa fa-plus"></i> Ekle/Düzenle
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <input type="hidden" multiple name="resim[]"
                                                                   value="<?php echo $image['type_meta']; ?>">
                                                            <div class="dropzone dropzone-default" id="kt_dropzone_1">
                                                                <div class="dropzone-msg dz-message needsclick">
                                                                    <h3 class="dropzone-msg-title">Değiştirmek için
                                                                        sürükle yada tıkla</h3><br>


                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-12">
                                                            <?php
                                                            $db->where("CategoryID", $_GET['id']);
                                                            $db->where("Type", "product");
                                                            $images = $db->get("products_meta");
                                                            foreach ($images as $image) {
                                                                echo ' <div class="row mb-3">
                                                                <div class="col-md-10"><img class="w-10" style="max-width:150px" src="../bwp-content/uploads/product/' . $image['Content'] . '" ></div>
                                                                <div class="col-md-2 text-end"><a href="kategori.php?process=productedit&id=' . $_GET['id'] . '&metaid=' . $image['ID'] . '&delete=true">Sil</a></div>
                                                            </div>
                                                        </div>  ';
                                                            }
                                                            ?>
                                                        </div>

                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            } ?>
                        </div>
                    </div>
                    <?php include 'inc/footer.php'; ?>
                </div>
            </div>
        </div>
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>
        <script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
        <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
        <script src="assets/js/main.js" type="text/javascript"></script>
        <script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
        <script src="assets/plugins/custom/tinymce/tinymce.min.js"></script>
        <script>

            function dropzonejs(urltxt, id) {
                $("#kt_dropzone_1").dropzone({
                    url: urltxt,
                    params: {
                        id: id
                    },
                    paramName: "file",
                    maxFilesize: 5, maxFiles: 7, uploadMultiple: true, // uplaod files in a single request
                    parallelUploads: 100,
                    addRemoveLinks: true,
                    dictFileTooBig: "Dosya boyutu çok yüksek ({{filesize}}mb). Max yükleme boyutu {{maxFilesize}}mb",
                    dictInvalidFileType: "Geçersiz dosya tipi",
                    dictResponseError: 'Server not Configured',
                    acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.webp",
                    init: function () {
                        var self = this;
                        self.options.addRemoveLinks = true;
                        self.options.dictRemoveFile = "Delete";
                        //New file added
                        self.on("addedfile", function (file) {
                            console.log('new file added ', file);

                        });
                        self.on("sending", function (file) {
                                $('.meter').show();
                            }
                        );
                        self.on("totaluploadprogress", function (progress) {
                            console.log("progress ", progress);
                            $('.roller').width(progress + '%');
                        });
                        self.on("queuecomplete", function (progress) {
                            $('.meter').delay(999).slideUp(999);
                        });
                        self.on("removedfile", function (file) {
                            console.log(file);
                        });
                    }, success: function (file, response) {
                        console.log(response);
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 2000);

                    }
                });
            }

            function yetkikont(process) {
                $.ajax({
                    url: "../bwp-includes/ajax.php?i=yetki&process=" + process + "",
                    success: function (e) {
                        var obj = jQuery.parseJSON(e);
                        console.log(obj);
                        if (obj.type == "success") {
                            pagelist();
                        } else {
                            var notify = $.notify({
                                title: obj.title,
                                message: obj.message
                            }, {
                                type: obj.type
                            });
                        }
                    }
                });
            }

            function pageset(id, type) {
                var data = $("#userForm").serializeArray();
                data.push({
                    name: "type",
                    value: type
                }, {
                    name: "id",
                    value: id
                });
                if (type == "kategoriedit" || type == "productedit" || type == "product") {
                    data.push({
                        name: "ProductStatement",
                        value: tinymce.activeEditor.getContent()
                    })
                }
                $.ajax({
                    url: '../bwp-includes/ajax.php?i=product&process=set',
                    type: 'POST',
                    data: data,
                    success: function (e) {
                        console.log(e);
                        console.log(id);
                        var obj = jQuery.parseJSON(e);
                        swal.fire("" + obj.title + "", "" + obj.message + "<br>" + obj.error + "", "" + obj.type + "");
                        if (obj.delete == true) {
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 2000);
                        } else {
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 2000);
                        }
                    }
                });
            }

            function pagelist() {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                let type = urlParams.get("process") + "view";
                var table = $('#kt_table_1').DataTable({
                    ajax: "../bwp-includes/ajax.php?i=product&process=" + type,
                    paging: true,
                    responsive: true,
                    displayLength: 10,
                    language: {
                        url: "assets/plugins/custom/datatables/Turkish.json"
                    }
                });
            }

            jQuery(document).ready(function () {

                yetkikont("coinview");
                var input = document.querySelector('input[name=CoinMarks]');
                new Tagify(input)
                $("select").select2();

                tinymce.init({
                    mode: "textareas",
                    selector: "textarea",
                    toolbar_mode: 'wrap',
                    language: 'tr',
                    fontsize_formats: "13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 36px 40px 50px 60px 70px 72px",
                    plugins: 'fullpage print preview paste importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons responsivefilemanager',
                    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl responsivefilemanager | tools',
                    toolbar_sticky: false,
                    image_advtab: true,
                    importcss_append: true,
                    height: 600,
                    image_caption: true,
                    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                    noneditable_noneditable_class: "mceNonEditable",
                    contextmenu: "link image imagetools table",
                    element_format: 'html',
                    convert_urls: false,
                    fullpage_default_doctype: '<!DOCTYPE html>'
                });

                dropzonejs("../bwp-includes/ajax.php?i=product&process=imgadd&id=<?php echo $_GET['id'] ?>", "0");
            });
            $(document).on("click", "button[name=set]", function () {
                var id = $(this).data("id");
                var type = $(this).data("type");
                pageset(id, type);
            });
            $('input.float').on('input', function () {
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });

        </script>
        </body>

        </html>
        <?php
    } else {
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }
}
?>