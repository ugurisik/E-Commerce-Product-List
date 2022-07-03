<?php
session_start();
include '../bwp-includes/settings.php';
include "../".THEMEADMIN."information.php";
if($_SESSION['loggedin']==true){
    $db->where ("email", $_SESSION["email"]);
    $userKont = $db->getOne ("users");
    if($userKont['loginID'] == $_SESSION['loginid']){
        $pageTitle = "Anasayfa Yönetimi";
        $mpage = "content";
        $maltpage = "homepage";
        $process = $_GET['process'];
        $processTitle = "Anasayfa Yönetimi";
        if($process == "edit"){
            $db->where ("id", $_GET["id"]);
            $editP = $db->getOne ("homePage");
        }

?>
<!DOCTYPE html>
<html lang="tr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8" />
    <title><?php echo $pageTitle; ?> - <?php echo $panelTitle;?></title>
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
                <img alt="Logo" src="assets/media/logos/logo-12.png" />
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
            <?php include 'inc/menu.php';?>
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <?php include 'inc/header.php';?>
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="kt-portlet kt-portlet--mobile">
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                        <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon">
                                                <i class="kt-font-brand fa fa-newspaper"></i>
                                            </span>
                                            <h3 class="kt-portlet__head-title"><?php echo $processTitle;?></h3>
                                        </div>
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="kt-portlet__head-wrapper">
                                                <div class="kt-portlet__head-actions">
                                                    <a href="?process=add" class="btn btn-brand btn-elevate btn-icon-sm"><i class="fa fa-plus"></i> Yeni Kayıt</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body tablediv">
                                        <div class="alert alert-solid-danger alert-bold d-none" role="alert">
                                            <div class="alert-icon">
                                                <i class="flaticon-warning"></i>
                                            </div>
                                            <div class="alert-text">
                                                <h4 class="alert-heading"></h4>
                                                <p></p>
                                            </div>
                                        </div>
                                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Sayfa Dili</th>
                                                <th>Slide Yazısı</th>
                                                <th>Blog Alanı -> 1</th>
                                                <th>Blog Alanı -> 2</th>
                                                <th>Yorum Alanı</th>
                                                <th>İşlemler</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <form class="userForm" enctype="multipart/form-data">
                                    <div class="kt-portlet kt-portlet--mobile">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <span class="kt-portlet__head-icon"><i class="fa fa-plus"></i></span>
                                                <h3 class="kt-portlet__head-title">
                                                    <?php if($process == "edit"){echo 'Anasayfa Düzenle';}else{echo 'Anasayfa Ekle';}?>
                                                </h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-wrapper">
                                                    <div class="kt-portlet__head-actions">
                                                        <?php if($process == "edit"){?>
                                                            <button type="button" class="btn btn-success" data-id="<?php echo $editP['id'];?>" data-type="edit" name="set"><i class="fa fa-edit"></i> Düzenle</button>
                                                        <?php }else{?>
                                                            <button type="button" class="btn btn-success"  data-type="add" name="set" ><i class="fa fa-plus"></i> Ekle</button>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__body">
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Slider Metni</label>
                                                        <textarea class="form-control" name="slidetext">
                                                            <?php echo htmlspecialchars($editP['slidetext']);?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Sayfa Dili</label>
                                                    <select class="form-control kt-selectpicker" name="langID">
                                                        <?php
                                                            $langs = $db->get('langs');
                                                            foreach ($langs as $lang) {
                                                                if($lang['id'] == $editP['langID']){
                                                                    echo '<option value="'.$lang['id'].'" selected>'.$lang['title'].'</option>';
                                                                }else{
                                                                    echo '<option value="'.$lang['id'].'">'.$lang['title'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Hizmetlerimiz Alanı</label>
                                                    <select class="form-control kt-selectpicker" name="blogcat1">
                                                        <?php
                                                        $postcats = $db->get('servicecat');
                                                        foreach ($postcats as $postcat) {
                                                            $db->where("id",$postcat['langID']);
                                                            $langs = $db->getOne('langs');
                                                            if($postcat['id'] == $editP['blogcat1']){
                                                                echo '<option value="'.$postcat['id'].'" selected>'.$langs['title'].' - '.$postcat['title'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$postcat['id'].'">'.$langs['title'].' - '.$postcat['title'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mt-4 col-md-12">
                                                    <label>Blog Alanı</label>
                                                    <select class="form-control kt-selectpicker" name="blogcat2">
                                                        <?php
                                                        $postcats = $db->get('postcat');
                                                        foreach ($postcats as $postcat) {
                                                            $db->where("id",$postcat['langID']);
                                                            $langs = $db->getOne('langs');
                                                            if($postcat['id'] == $editP['blogcat2']){
                                                                echo '<option value="'.$postcat['id'].'" selected>'.$langs['title'].' - '.$postcat['title'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$postcat['id'].'">'.$langs['title'].' - '.$postcat['title'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mt-4 col-lg-12 d-none file-prog">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">Dosya yükleme durumu</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="progress progress-bar-success mb-2">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <input type="hidden" name="resim" value="<?php echo $editP['resim'];?>">
                                                            <label>Slide Resmi</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="slide" id="customFile">
                                                                <label class="custom-file-label" for="customFile">Slide resmi seçiniz</label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            if($process == "edit"){
                                                                $gen = $db->getSetMeta("home-slide","genislik");
                                                                $yuk = $db->getSetMeta("home-slide","yukseklik");
                                                        ?>
                                                            <div class="col-lg-12">
                                                                <img src="../bwp-content/uploads/slide/<?php echo $gen;?>x<?php echo $yuk.'/'.$editP['resim'];?>" class="img-thumbnail">
                                                            </div>
                                                        <?php
                                                            }
                                                        ?>

                                                    </div>

                                                </div>
                                                <div class="mt-4 col-md-12">
                                                    <label>Yorum Alanı</label>
                                                    <select class="form-control kt-selectpicker" name="yorumlar">
                                                        <?php
                                                            foreach ($status as $key => $val) {
                                                                if($val == 1 || $val == 2){
                                                                    if($editP['yorumlar'] == $val){
                                                                        echo '<option value="'.$val.'" selected>'.$key.'</option>';
                                                                    }else{
                                                                        echo '<option value="'.$val.'">'.$key.'</option>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'inc/footer.php';?>
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
        function yetkikont(process){
            $.ajax({
                url: "../bwp-includes/ajax.php?i=yetki&process="+process+"",
                success: function(e) {
                    var obj = jQuery.parseJSON(e);
                    if(obj.type == "success"){
                        table();
                    }else {
                        var notify = $.notify({title: obj.title,message: obj.message},{type: obj.type});
                    }
                }
            });
        }
        function table(){
            var data = [];
            data.push({name : "type",value : "list"});
            $.ajax({
                url: '../bwp-includes/ajax.php?i=homepage&process=view',
                type: 'POST',
                data: data,
                success: function(e) {
                    var obj = jQuery.parseJSON(e);
                    if(obj.notify.type == "danger")
                    {
                        $(".tablediv .alert").removeClass("d-none");
                        $(".tablediv .alert .alert-text h4").html(obj.notify.title);
                        $(".tablediv .alert .alert-text p").html(obj.notify.message);
                        $(".tablediv table").addClass("d-none");
                    }
                    else if(obj.notify.type == "success")
                    {
                        $(".tablediv .alert").addClass("d-none");
                        $(".tablediv table").removeClass("d-none");
                        $('.tablediv table').DataTable({
                            data:obj.data,
                            searching: false,
                            info: false,
                            responsive: true,
                            displayLength: 50,
                            language: {url: "assets/plugins/custom/datatables/Turkish.json"}
                        });
                    }
                }
            });
        }
        function pageset(id,type){
            var data = $("form").serializeArray();
            data.push({name : "id",value : id},{name : "type",value : type});
            $.ajax({
                url: '../bwp-includes/ajax.php?i=homepage&process=set',
                type: 'POST',
                data: data,
                success: function(e) {
                    console.log(e);
                    var obj = jQuery.parseJSON(e);
                    var notify = $.notify({message: obj.message},{type: obj.type});
                    if(type == "edit") {
                        if(obj.type == "success"){
                            setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        }
                    }
                    else if(type == "add") {
                        if(obj.type == "success"){
                            setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        }
                    }
                    else if(type == "delete") {
                        if(obj.type == "success"){
                            setTimeout(function() {
                                window.location.href = "homepage.php";
                            }, 1000);
                        }
                    }
                }
            });
        }
        function pagesetTwo(id,type){
            tinymce.triggerSave();
            var formData = new FormData($('.userForm')[0]);
            if(type == "edit"){
                formData.append("id",id);
            }
            formData.append("type",type);
            $.ajax({
                url: "../bwp-includes/ajax.php?i=homepage&process=set",
                type: 'POST',
                data: formData,
                xhr: function() {
                    $(".file-prog").removeClass("d-none");
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            $(".file-prog .progress-bar").width(+ (Math.round(percentComplete * 100)) +'%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(e) {
                    console.log(e);
                    var obj = jQuery.parseJSON(e);
                    if(type == "edit") {
                        if(obj.type == "success"){
                            setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        }
                    }
                    else if(type == "add") {
                        if(obj.type == "success"){
                            setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        }
                    }
                    else if(type == "delete") {
                        if(obj.type == "success"){
                            setTimeout(function() {
                                window.location.href = "homepage.php";
                            }, 1000);
                        }
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        function tinymceset(div){
            tinymce.init({
                selector: div,
                toolbar_mode: 'wrap',
                language: 'tr',
                fontsize_formats: "13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 36px 40px 50px 60px 70px 72px",
                plugins: 'print preview paste importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons responsivefilemanager',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl responsivefilemanager | tools',
                toolbar_sticky: false,
                image_advtab: true,
                importcss_append: true,
                height: 600,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: "mceNonEditable",
                contextmenu: "link image imagetools table",
                external_filemanager_path:"assets/plugins/custom/filemanager/",
                filemanager_title:"Filemanager" ,
                external_plugins: { "filemanager" : "assets/plugins/custom/filemanager/plugin.min.js"},
                images_upload_handler : function(blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '../bwp-includes/ajax.php?i=imgup');
                    xhr.onload = function() {
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        var obj = jQuery.parseJSON(xhr.responseText);

                        success(obj.file_path);

                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                }
            });
        }
        jQuery(document).ready(function() {
            $("select").select2();
            yetkikont("homepageview");
            $("button[name=set]").on("click", function(){
                var id = $(this).data("id");
                var type = $(this).data("type");
                pagesetTwo(id,type);
            });
            <?php if($process == "delete"){?>
                pageset(<?php echo $_GET['id'];?>,"delete");
            <?php }?>
        });
    </script>
</body>
</html>
<?php
    }
}
else {
    echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
?>