<?php
session_start();
include '../bwp-includes/settings.php';
if ($_SESSION['loggedin'] == true) {
    $db->where("email", $_SESSION["email"]);
    $userKont = $db->getOne("users");
    if ($userKont['loginID'] == $_SESSION['loginid']) {
        $pageTitle = "Coin Yönetimi";
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
?>

        <!DOCTYPE html>
        <html lang="tr">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

        <head>
            <meta charset="utf-8" />
            <title><?php echo $pageTitle; ?> - <?php echo $panelTitle; ?></title>
            <meta name="description" content="No subheader example">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
            <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
            <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
            <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        </head>

        <body class="kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-aside--enabled kt-aside--fixed kt-page--loading">
            <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
                <div class="kt-header-mobile__logo">
                    <a href="index.html">
                        <img alt="Logo" src="assets/media/logos/logo-12.png" style="max-width: 100px;" />
                    </a>
                </div>
                <div class="kt-header-mobile__toolbar">
                    <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
                    <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
                    <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
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
                                                            <input type="hidden" name="CoinName" value=" <?= $coininfo['CoinName'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="kt-portlet__body">
                                                        <div class="form-group">
                                                            <label>Alım Yeri</label>
                                                            <input type="text" class="form-control" name="CoinPurchase" maxlength="65" value="<?php echo $coininfo['CoinPurchase']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Stop Yeri</label>
                                                            <input type="text" class="form-control" name="CoinStop" maxlength="154" value="<?php echo $coininfo['CoinStop']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Satış Hedefleri</label>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <button type="button" class="btn btn-dark" name="addMark"><i class="fa fa-add"></i> Hedef Ekle </button>
                                                                </div>
                                                                <div class="col-md-12 marks ">
                                                                    <?php

                                                                    $db->where("CoinID", $coininfo['ID']);
                                                                    $coinmark = $db->get("coin_mark");

                                                                    foreach ($coinmark as $key) {


                                                                    ?>
                                                                        <div class="row mark_ mb-3">
                                                                            <div class="col-md-6">
                                                                                <input type="text" class="form-control float" name="CoinMarks[]" maxlength="15" value="<?= $key['CoinValue'] ?>">
                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                <select class="form-control kt-selectpicker" name="status[]">
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
                                                                                <button type="button" class="btn btn-error btn-sm" data-id="<?= $key['ID'] ?>" data-type="deletemark" name="set"><i class="la la-remove"></i></button>
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
                                                            <input type="text" class="form-control" name="CreateDate" maxlength="154" disabled value="<?php echo $coininfo['CreateDate']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Güncelleme Tarihi</label>
                                                            <input type="text" class="form-control" name="UpdateDate" maxlength="154" disabled value="<?php echo $coininfo['UpdateDate']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-dark" data-id="<?php echo $coininfo['ID']; ?>" data-type="edit" name="set"><i class="fa fa-edit"></i> Kaydet </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php } else if ($process == "add") { ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="coinUpdate">
                                                <div class="kt-portlet">
                                                    <div class="kt-portlet__head">
                                                        <div class="kt-portlet__head-label">
                                                            <h3 class="kt-portlet__head-title">
                                                                Yeni Kayıt
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="kt-portlet__body">
                                                        <div class="form-group">
                                                            <label>Coin Adı</label>
                                                            <input type="text" class="form-control" name="CoinName" maxlength="65" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Alım Yeri</label>
                                                            <input type="text" class="form-control float" name="CoinPurchase" maxlength="65" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Stop Yeri</label>
                                                            <input type="text" class="form-control float" name="CoinStop" maxlength="154" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Satış Hedefleri</label>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <button type="button" class="btn btn-dark" name="addMark"><i class="fa fa-add"></i> Hedef Ekle </button>
                                                                </div>
                                                                <div class="col-md-12 marks ">
                                                                    <div class="row mark_">
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control float" name="CoinMarks[]" maxlength="15" value="">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <select class="form-control kt-selectpicker" name="status[]">
                                                                                <?php
                                                                                $db->where("StatusType", "status");
                                                                                $status = $db->get('coin_status');
                                                                                foreach ($status as $statu) {
                                                                                    if ($coininfo['Type'] == $statu['ID']) {
                                                                                        echo '<option value="' . $statu['ID'] . '" selected>' . $statu['StatusName'] . '</option>';
                                                                                    } else {
                                                                                        echo '<option value="' . $statu['ID'] . '">' . $statu['StatusName'] . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
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
                                                            <button type="button" class="btn btn-dark" data-id="<?php echo $coininfo['ID']; ?>" data-type="add" name="set"><i class="fa fa-edit"></i> Ekle </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="kt-portlet kt-portlet--mobile">
                                                <div class="kt-portlet__head kt-portlet__head--lg">
                                                    <div class="kt-portlet__head-label">
                                                        <span class="kt-portlet__head-icon">
                                                            <i class="kt-font-brand fa fa-fog"></i>
                                                        </span>
                                                        <h3 class="kt-portlet__head-title"><?php echo $processTitle; ?></h3>
                                                    </div>
                                                    <div class="kt-portlet__head-toolbar">
                                                        <div class="kt-portlet__head-wrapper">
                                                            <div class="kt-portlet__head-actions">
                                                                <a href="?process=add" class="btn btn-brand btn-elevate btn-icon-sm"><i class="fa fa-plus"></i> Yeni Kayıt</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-portlet__body">
                                                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Coin Adı</th>
                                                                <th>Alım Yeri</th>
                                                                <th>Satım Yerleri</th>
                                                                <th>Stop Yeri</th>
                                                                <th>Kullanıcı Tipi</th>
                                                                <th>Oluşturulma Tarihi</th>
                                                                <th>Güncelleme Tarihi</th>
                                                                <th>İşlem</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
            <script>
                function yetkikont(process) {
                    $.ajax({
                        url: "../bwp-includes/ajax.php?i=yetki&process=" + process + "",
                        success: function(e) {
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
                    var data = $("#coinUpdate").serializeArray();
                    data.push({
                        name: "type",
                        value: type
                    }, {
                        name: "id",
                        value: id
                    });
                    $.ajax({
                        url: '../bwp-includes/ajax.php?i=coin&process=set',
                        type: 'POST',
                        data: data,
                        success: function(e) {
                            console.log(e);
                            var obj = jQuery.parseJSON(e);
                            swal.fire("" + obj.title + "", "" + obj.message + "<br>" + obj.error + "", "" + obj.type + "");
                            if (obj.delete == true) {
                                setTimeout(() => {
                                    window.location.reload(true);
                                }, 2000);
                            }
                        }
                    });
                }

                function pagelist() {
                    var table = $('#kt_table_1').DataTable({
                        ajax: "../bwp-includes/ajax.php?i=coin&process=view",
                        paging: true,
                        responsive: true,
                        displayLength: 10,
                        language: {
                            url: "assets/plugins/custom/datatables/Turkish.json"
                        }
                    });
                }
                jQuery(document).ready(function() {
                    yetkikont("coinview");
                    var input = document.querySelector('input[name=CoinMarks]');
                    new Tagify(input)
                    $("select").select2();
                });
                $(document).on("click", "button[name=set]", function() {
                    var id = $(this).data("id");
                    var type = $(this).data("type");
                    pageset(id, type);
                });
                $('input.float').on('input', function() {
                    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
                });
                $(document).on("click", "button[name=addMark]", function() {
                    let marks = $(".marks");

                    marks.append('<div class="row mark_ mt-3"><div class="col-md-6"><input type="text" class="form-control float" name="CoinMarks[]" maxlength="15" value=""></div><div class="col-md-6"><select class="form-control kt-selectpicker" name="status[]"><?php $db->where("StatusType", "status");
                                                                                                                                                                                                                                                                        $status = $db->get('coin_status');
                                                                                                                                                                                                                                                                        foreach ($status as $statu) {
                                                                                                                                                                                                                                                                            if ($coininfo['Type'] == $statu['ID']) {
                                                                                                                                                                                                                                                                                echo '<option value="' . $statu['ID'] . '" selected>' . $statu['StatusName'] . '</option>';
                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                echo '<option value="' . $statu['ID'] . '">' . $statu['StatusName'] . '</option>';
                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                        } ?></select></div></div>');
                });
            </script>
        </body>

        </html>
<?php
    }
} else {
    echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
?>