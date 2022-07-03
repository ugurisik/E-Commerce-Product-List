<?php
session_start();
include 'settings.php';
include 'vendor/autoload.php';
include "../" . THEMEADMIN . "information.php";
error_reporting(E_ALL & ~E_NOTICE);
function insertLog($security, $text, $db, $uid, $err)
{
    $logs = $db->get("logs");
    if (count($logs) > 1000) {
        $db->delete("logs");
    }
    if (empty($err)) {
        $err = "Başarılı işlem.";
    }
    $data = array(
        "UserID" => $uid,
        "transaction" => $text,
        "Error" => $err,
        "userIP" => "" . $security->getIP() . "",
        "userOS" => "" . $security->getOS() . "",
        "userLang" => "" . $security->getLang() . "",
        "userAgent" => "" . $security->getUserAgent() . ""
    );
    $insert = $db->insert("logs", $data);
}

$islem = $_GET["i"];
$process = $_GET["process"];
$id = $_GET['id'];
$db->where("email", $_SESSION["email"]);
$userKont = $db->getOne("users");
$tarih = date("d.m.Y");

foreach ($yetkiler as $key => $val) {
    if ($process == $val) {
        $yetkiadi = $key;
        break;
    } else {
        $yetkiadi = $process;
    }
}


$db->where("setType", "setting");
$db->where("type", "pagination");
$topPost = $db->getOne('settings_meta');

if ($islem == "yetki") {
    $yetki = $db->yetkikont($process, "" . $userKont['id'] . "");
    if ($yetki == "1") {
        $idata = array("type" => "success");
    } else {
        insertLog($security, "Yetkisiz İşlem | " . $yetkiadi, $db, $userKont['id'], $db->getLastError());
        $idata = array("title" => "Yetkisiz İşlem", "message" => "" . $userKont['name'] . " " . $yetkiadi . " işlemi için yetkin yok!", "type" => "danger", "error" => "");
    }
    $json = json_encode($idata, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    print_r($json);
} else if ($islem == "product") {
    if ($process == "kategoriview") {
        $yetki = $db->yetkikont("coinview", "" . $userKont['id'] . "");
        if ($yetki == "1") {
            $coinlist = $db->get("products_cat");
            foreach ($coinlist as $key) {
                if ($key['CategoryID'] == 0) {
                    $category = "Ana Kategori";
                } else {
                    $db->where("ID", $key['CategoryID']);
                    $subcat = $db->getOne("products_cat");
                    $category = $subcat['Title'];
                }

                $coin = array(
                    $key['ID'],
                    $category,
                    $key['Title'],
                    '<span class="dropdown">
                    <a href="?process=kategoriedit&id=' . $key['ID'] . '" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                        <i class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-error btn-sm" data-id="' . $key['ID'] . '" data-type="kategoridelete" name="set"><i class="la la-remove"></i></button>
                        
                </span>',
                );
                $darray['data'][] = $coin;
            }
            insertLog($security, "Kategori listesi getirildi.", $db, $userKont['id'], "");
            $json = json_encode($darray, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        } else {
            $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " sayfa görüntüleme işlemi için yetkin yok!", "type" => "danger", "error" => "view");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        }
    } else if ($process == "productview") {
        $coinlist = $db->get("products");
        foreach ($coinlist as $key) {
            if ($key['CategoryID'] == 0) {
                $category = "Ana Kategori";
            } else {
                $db->where("ID", $key['CategoryID']);
                $subcat = $db->getOne("products_cat");
                $category = $subcat['Title'];
            }

            $coin = array(
                $key['ID'],
                $category,
                $key['ProductName'],
                $key['ProductPrice'],
                $key['ProductDiscount'],
                $key['ProductStatement'],
                $key['ProductLink'],
                '<span class="dropdown">
                    <a href="?process=productedit&id=' . $key['ID'] . '" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                        <i class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-error btn-sm" data-id="' . $key['ID'] . '" data-type="productdelete" name="set"><i class="la la-remove"></i></button>
                        
                </span>',
            );
            $darray['data'][] = $coin;
        }
        insertLog($security, "Kategori listesi getirildi.", $db, $userKont['id'], "");
        $json = json_encode($darray, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
        print_r($json);
    } else if ($process == "set") {
        $yetki = $db->yetkikont("set", "" . $userKont['id'] . "");
        if ($yetki == "1") {
            $Title = $_POST["title"];
            $CatID = $_POST["catID"];

            $CategoryID = $_POST["CategoryID"];
            $ProductName = $_POST["ProductName"];
            $ProductPrice = $_POST["ProductPrice"];
            $ProductDiscount = $_POST["ProductDiscount"];
            $ProductStatement = $_POST["ProductStatement"];
            $ProductLink = $_POST["ProductLink"];
            $ProductStatus = 1;


            if ($_POST['type'] == "kategoriedit") {
                $data = array(
                    "Title" => $Title,
                    "CategoryID" => $CatID,
                    "Slug" => $yazi->seourl($Title)
                );


                $db->where('ID', $_POST["id"]);
                $db->update('products_cat', $data);

                if (true) {
                    insertLog($security, $Title . " güncellemesi yapıldı. ID: " . $id, $db, $userKont['id'], "");
                    $data = array("title" => "İşlem Başarılı", "message" => "" . $Title . " güncellemesi başarılı!", "type" => "success", "error" => "");
                } else {
                    insertLog($security, $CoinName . " güncellemesi yapılamadı. ID: " . $id, $db, $userKont['id'], $db->getLastError());
                    $data = array("title" => "İşlem Başarısız", "message" => "" . $CoinName . " güncellenemedi! ", "type" => "error", "error" => "" . $db->getLastError() . "");
                }
                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            } else if ($_POST['type'] == "kategoriadd") {

                $data = array(
                    "Title" => $Title,
                    "CategoryID" => $CatID,
                    "Slug" => $yazi->seourl($_POST['title'])
                );
                $id = $db->insert("products_cat", $data);
                if ($id != false) {

                    insertLog($security, $Title . " eklemesi yapıldı. ID: " . $id, $db, $userKont['id'], "");
                    $data = array("title" => "İşlem Başarılı", "message" => "" . $Title . " eklemesi başarılı!", "type" => "success", "error" => "");
                } else {
                    insertLog($security, $Title . " eklemesi yapılamadı. ID: " . $id, $db, $userKont['id'], $db->getLastError());
                    $data = array("title" => "İşlem Başarısız", "message" => "" . $Title . " eklenemedi! ", "type" => "error", "error" => "" . $db->getLastError() . "");
                }
                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            } else if ($_POST['type'] == "kategoridelete") {
                $id = $_POST["id"];
                $db->where("ID", $id);
                $coin = $db->getOne("products_cat");
                if (count($coin) > 0) {
                    $db->where("ID", $id);
                    $db->delete("products_cat");
                    insertLog($security, $coin['Title'] . " kategorisi silindi. ", $db, $userKont['id'], "");
                    $data = array("title" => "İşlem Başarılı", "message" => "" . $coin['Title'] . " kategorisi silindi!", "type" => "success", "delete" => true, "error" => "");
                } else {
                    $data = array("title" => "İşlem Hatalı", "message" => "Kategori bulunamadı", "type" => "error", "delete" => true, "error" => "");
                }

                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            } else if ($_POST['type'] == "deletemark") {
                $db->where("ID", $id);
                $coinmark = $db->getOne("coin_mark");

                $db->where("ID", $coinmark['CoinID']);
                $coin = $db->getOne("coin_info");

                $db->where("ID", $id);
                $db->delete("coin_mark");

                insertLog($security, $CoinName . " hedefi silindi. ID: " . $id, $db, $userKont['id'], "");
                $data = array("title" => "İşlem Başarılı", "message" => "" . $coin['CoinName'] . " hedefi silindi!", "type" => "success", "delete" => true, "error" => "");
                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            } else if ($_POST['type'] == "productadd") {
                $data = array(
                    "CategoryID" => $CategoryID,
                    "ProductName" => $_POST["ProductName"],
                    "ProductPrice" => $_POST["ProductPrice"],
                    "ProductDiscount" => $_POST["ProductDiscount"],
                    "ProductStatement" => $_POST["ProductStatement"],
                    "ProductLink" => $_POST["ProductLink"],
                    "ProductStatus" => 1,
                    "ProductSlug" => $yazi->seoUrl($_POST["ProductName"])
                );
                $id = $db->insert("products", $data);
                if ($id != false) {

                    insertLog($security, $ProductName . " eklemesi yapıldı. ID: " . $id, $db, $userKont['id'], "");
                    $data = array("title" => "İşlem Başarılı", "message" => "" . $ProductName . " eklemesi başarılı!", "type" => "success", "error" => "");
                } else {
                    insertLog($security, $ProductName . " eklemesi yapılamadı. ID: " . $id, $db, $userKont['id'], $db->getLastError());
                    $data = array("title" => "İşlem Başarısız", "message" => "" . $ProductName . " eklenemedi! ", "type" => "error", "error" => "" . $db->getLastError() . "");
                }
                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            } else if ($_POST['type'] == "productedit") {
                $data = array(
                    "CategoryID" => $CategoryID,
                    "ProductName" => $_POST["ProductName"],
                    "ProductPrice" => $_POST["ProductPrice"],
                    "ProductDiscount" => $_POST["ProductDiscount"],
                    "ProductStatement" => $_POST["ProductStatement"],
                    "ProductLink" => $_POST["ProductLink"],
                    "ProductStatus" => 1,
                    "ProductSlug" => $yazi->seoUrl($_POST["ProductName"])
                );
                $db->where("ID", $_POST["id"]);
                $id = $db->update("products", $data);
                if ($id != false) {

                    insertLog($security, $ProductName . " güncellemesi yapıldı. ID: " . $id, $db, $userKont['id'], "");
                    $data = array("title" => "İşlem Başarılı", "message" => "" . $ProductName . " güncellemesi başarılı!", "type" => "success", "error" => "");
                } else {
                    insertLog($security, $ProductName . " güncellemesi yapılamadı. ID: " . $id, $db, $userKont['id'], $db->getLastError());
                    $data = array("title" => "İşlem Başarısız", "message" => "" . $ProductName . " güncellenemedi! ", "type" => "error", "error" => "" . $db->getLastError() . "");
                }
                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            } else if ($_POST['type'] == "productdelete") {
                $id = $_POST["id"];
                $db->where("ID", $id);
                $coin = $db->getOne("products");
                if (count($coin) > 0) {
                    $db->where("ID", $id);
                    $db->delete("products");
                    insertLog($security, $coin['ProductName'] . " ürünü silindi. ", $db, $userKont['id'], "");
                    $data = array("title" => "İşlem Başarılı", "message" => "" . $coin['ProductName'] . " ürünü silindi!", "type" => "success", "delete" => true, "error" => "");
                } else {
                    $data = array("title" => "İşlem Hatalı", "message" => "ürünü bulunamadı", "type" => "error", "delete" => true, "error" => "");
                }

                $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            }
            print_r($json);
        }
    } else if ($process == "imgadd") {
        $storeFolder = "../bwp-content/uploads/product/";
        if (!file_exists($storeFolder) && !is_dir($storeFolder)) {
            mkdir($storeFolder);
        }
        foreach ($_FILES['file']['tmp_name'] as $key => $value) {
            $newfilename = date('dmYHis') . str_replace(" ", "", basename($_FILES["file"]["name"][$key]));
            $tempFile = $_FILES['file']['tmp_name'][$key];
            $targetFile = $storeFolder . $newfilename;
            move_uploaded_file($tempFile, $targetFile);

            $data = array(
                "CategoryID" => $_GET['id'],
                "Type" => "product",
                "Content" => $newfilename
            );
            $db->insert("products_meta", $data);
            insertLog($security, "Görsel eklemesi yapıldı. ID: " . $id, $db, $userKont['id'], "");

        }
    }
} else if ($islem == "login") {
    $tarih = date("d.m.Y");
    $email = $_POST['email'];
    $passwd = $_POST['password'];
    if (empty($email) || empty($passwd)) {
        $data = array(
            "message" => "Alanları boş bırakamazsınız",
            "type" => "danger"
        );
        insertLog($security, "Girişte başarılı olamadı, boş alan bırakıldı.  e-Posta adresi: " . $email, $db, 0, "");
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
        print_r($json);
    } else {
        $db->where("email", $email);
        $account = $db->getOne("users");
        $db->where("userID", $account['id']);
        $db->where("type", "yetki");
        $yetki = $db->getOne("users_meta");
        if (empty($account['email'])) {
            $data = array(
                "message" => "E-posta adresi kayıtlı değil!",
                "type" => "danger"
            );
            insertLog($security, "Girişte başarılı olamadı, e-posta adresi kayıtlı değil. E-Posta adresi: " . $email, $db, 0, "");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        } else {
            if (password_verify($passwd, $account['password'])) {
                if ($yetki['type_meta'] == 1 || $yetki['type_meta'] == 2 || $yetki['type_meta'] == 6 || $yetki['type_meta'] == 7) {
                    $token = md5(uniqid(mt_rand(), true));
                    $data = array(
                        'login' => 1,
                        'loginID' => $token
                    );
                    $db->where('id', $account['id']);
                    $db->update('users', $data);
                    $data = array("userID" => $account['id'], "date" => date("d.m.Y H:i:s"), "browser" => $security->getBrowser(), "os" => $security->getOS(), "ip" => $security->getIP(), "userAgent" => $security->getUserAgent());
                    $id = $db->insert('login_info', $data);

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $account['id'];
                    $_SESSION["email"] = $account['email'];
                    $_SESSION["loginid"] = $token;
                    $data = array(
                        "message" => "Giriş yapıldı. Yönlendiriliyorsunuz lütfen bekleyin!",
                        "type" => "success"
                    );
                    insertLog($security, "Başarılı bir şekilde giriş yaptı.", $db, $account['id'], "");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                } else {
                    $data = array(
                        "message" => "Yönetici paneline giriş için yetkin bulunmuyor!",
                        "type" => "danger"
                    );
                    insertLog($security, "Yönetici paneline giriş için yetkisi yok. E-Posta adresi: " . $email, $db, $account['id'], "");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            } else {
                if ($account['login'] < 3) {
                    $up = $account['login'] + 1;
                    $data = array('login' => $up);
                    $db->where('id', $account['id']);
                    $db->update('users', $data);
                    insertLog($security, "Hatalı şifre sebebiyle oturum açılamadı. E-Posta adresi: " . $email, $db, 0, "");
                    $data = array(
                        "message" => "Şifreniz hatalı! Lütfen tekrar deneyiniz.",
                        "type" => "danger"
                    );
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                } else if ($account['login'] >= 3) {
                    $data = array("startDate" => $tarih, "endDate" => date("Y.m.d H:i:s", strtotime('+15 minutes')), "ip" => $security->getIP());
                    $id = $db->insert('login_ban', $data);
                    $data = array(
                        "message" => "Çok fazla hatalı girişi denemesi sebebi ile IP Adresiniz 15 dakika engellenmiştir!",
                        "type" => "danger"
                    );
                    insertLog($security, "Oturum açma esnasında hatalı şifreden dolayı 15 DK engel yedi. E-Posta adresi: " . $email, $db, 0, "");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
                $data = array("userID" => $account['id'], "date" => $tarih, "userAgent" => $security->getUserAgent(), "browser" => $security->getBrowser(), "os" => $security->getOS(), "ip" => $security->getIP(), "username" => $email, "password" => $passwd);
                $id = $db->insert('login_error', $data);
            }
        }
    }
} else if ($islem == "user") {
    if ($process == "view") {
        $yetki = $db->yetkikont("userview", "" . $userKont['id'] . "");
        if ($yetki == "1") {
            $pagesql = $db->get("users");
            foreach ($pagesql as $key => $value) {
                $db->where("userID", $value['id']);
                $db->where("type", "register_time");
                $rt = $db->getOne("users_meta");
                $db->where("userID", $value['id']);
                $db->orderBy("id", "desc");
                $logins = $db->getOne("login_info");

                $darray["data"][] = array(
                    $value['id'],
                    $value['name'] . ' ' . $value['surname'],
                    $value['phone'],
                    $value['email'],

                    $rt['type_meta'],
                    '<span class="dropdown">
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="?process=edit&id=' . $value['id'] . '" class="dropdown-item">
                                <i class="la la-edit"></i> Düzenle
                            </a>
                            <a href="?process=delete&id=' . $value['id'] . '"class="dropdown-item">
                                <i class="la la-remove"></i> Sil
                            </a>
                        </div>
                    </span>',
                    $logins['date'],
                    $logins['ip'],
                    $logins['os'],
                    $logins['browser'],
                );
            }
            insertLog($security, "Kullanıcı listesi listelendi.", $db, $userKont['id'], "");
            $json = json_encode($darray, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        } else {
            insertLog($security, "Kullanıcı listesi için yetersiz yetki.", $db, $userKont['id'], "");
            $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " sayfa görüntüleme işlemi için yetkin yok!", "type" => "danger", "error" => "view");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        }
    } else if ($process == "set") {
        $yetki = $db->yetkikont("set", "" . $userKont['id'] . "");
        if ($yetki == "1") {
            $setID = $_POST['id'];
            $name = $_POST['isim'];
            $surname = $_POST['soyisim'];
            $email = $_POST['eposta'];
            $phone = $_POST['telefon'];
            $address = $_POST['address'];
            $company = $_POST['comp'];
            $department = $_POST['dept'];
            $aut = $_POST['yetki'];
            $status = $_POST['durum'];
            $pass = $_POST['pass'];
            $passd = $_POST['passd'];
            if ($_POST['type'] == "edit") {
                if (!empty($pass) && !empty($passd) && $pass == $passd) {
                    $hashpwd = password_hash($pass, PASSWORD_DEFAULT);
                } else {
                    $hashpwd = $_POST['passwd'];
                }
            } else if ($_POST['type'] == "add") {
                $hashpwd = password_hash($pass, PASSWORD_DEFAULT);
            }
            $data = array(
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'company' => $company,
                'department' => $department,
                'password' => $hashpwd
            );
            if ($_POST['type'] == "edit") {
                $yetki = $db->yetkikont("useredit", "" . $userKont['id'] . "");
                if ($yetki == "1") {
                    $db->where('id', $setID);
                    $ssqldrm = $db->update('users', $data);
                    if ($ssqldrm) {
                        $adata = array('type_meta' => $aut);
                        $db->where('userID', $setID);
                        $db->where('type', "yetki");
                        $db->update('users_meta', $adata);

                        $sdata = array('type_meta' => $status);
                        $db->where('userID', $setID);
                        $db->where('type', "durum");
                        $db->update('users_meta', $sdata);

                        if (isset($_POST['yetkiler'])) {
                            $authorYetki = $db->yetkikont("yetki", "" . $userKont['id'] . "");
                            $yonetici = $db->yetkikont("yetki", "" . $userKont['id'] . "");
                            $yetki = $db->yetkikont("userautedit", "" . $userKont['id'] . "");
                            if ($yetki == "1" || $yonetici['type_meta'] = 2 || $authorYetki['type_meta'] = 1) {
                                $db->where("type != 'durum'");
                                $db->where("type !='yetki'");
                                $db->where("type !='register_time'");
                                $db->where("userID", $setID);
                                $db->delete('users_meta');
                                $cats = $_POST['yetkiler'];
                                $catss = $yazi->yazibol(",", $cats);
                                $catSize = count($catss);
                                for ($i = 0; $i < $catSize; $i++) {
                                    $data = array(
                                        'userID' => $setID,
                                        'type' => $catss[$i],
                                        'type_meta' => 1
                                    );
                                    $db->insert('users_meta', $data);
                                }
                            }
                        }
                        insertLog($security, "Kullanıcı düzenlendi. E-Posta adresi: " . $email, $db, $userKont['id'], "");
                        $data = array("message" => "Kullanıcı Düzenlendi", "type" => "success", "error" => "");
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    } else {
                        insertLog($security, "Kullanıcı düzenlenemedi. E-Posta adresi: " . $email, $db, $userKont['id'], $db->getLastError());
                        $data = array("message" => "Kullanıcı Düzenlenmedi", "type" => "danger", "error" => $db->getLastError());
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    }
                } else {
                    $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " kullanıcı düzenleme işlemi için yetkin yok!", "type" => "danger", "error" => "useredit");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            } else if ($_POST['type'] == "add") {
                $yetki = $db->yetkikont("useradd", "" . $userKont['id'] . "");
                if ($yetki == "1") {
                    $ssqldrm = $db->insert('users', $data);
                    if ($ssqldrm) {
                        $db->where("email", $email);
                        $userKont = $db->getOne("users");
                        $data = array(
                            array("userID" => $userKont['id'], "type" => "durum", "type_meta" => $status),
                            array("userID" => $userKont['id'], "type" => "yetki", "type_meta" => $aut),
                            array("userID" => $userKont['id'], "type" => "register_time", "type_meta" => $tarih)
                        );
                        $db->insertMulti('users_meta', $data);
                        if (isset($_POST['yetkiler'])) {
                            $authorYetki = $db->yetkikont("yetki", "" . $userKont['id'] . "");
                            $yonetici = $db->yetkikont("yetki", "" . $userKont['id'] . "");
                            $yetki = $db->yetkikont("userautedit", "" . $userKont['id'] . "");
                            if ($yetki == "1" || $yonetici['type_meta'] = 2 || $authorYetki['type_meta'] = 1) {
                                $db->where("type != 'durum'");
                                $db->where("type !='yetki'");
                                $db->where("type !='register_time'");
                                $db->where("userID", $setID);
                                $db->delete('users_meta');
                                $cats = $_POST['yetkiler'];
                                $catss = $yazi->yazibol(",", $cats);
                                $catSize = count($catss);
                                for ($i = 0; $i < $catSize; $i++) {
                                    $data = array(
                                        'userID' => $setID,
                                        'type' => $catss[$i],
                                        'type_meta' => 1
                                    );
                                    $db->insert('users_meta', $data);
                                }
                            }
                        }
                        insertLog($security, "Kullanıcı eklendi. E-Posta adresi: " . $email, $db, $userKont['id'], "");
                        $data = array("message" => "Kullanıcı Eklendi", "type" => "success", "error" => "");
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    } else {
                        $data = array("message" => "Kullanıcı Eklenmedi", "type" => "danger", "error" => $db->getLastError());
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    }
                } else {
                    insertLog($security, "Kullanıcı eklenemedi, yetersiz yetki. E-Posta adresi: " . $email, $db, $userKont['id'], "");
                    $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " kullanıcı ekleme işlemi için yetkin yok!", "type" => "danger", "error" => "useradd");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            } else if ($_POST['type'] == "delete") {
                $yetki = $db->yetkikont("userdel", "" . $userKont['id'] . "");
                if ($yetki == "1") {
                    $db->where('id', $setID);
                    $ssqldrm = $db->delete('users');
                    if ($ssqldrm) {
                        $db->where('userID', $setID);
                        $ssqldrm = $db->delete('users_meta');
                        insertLog($security, "Kullanıcı silindi. E-Posta adresi: " . $email, $db, $userKont['id'], "");
                        $data = array("message" => "Kullanıcı Silindi", "type" => "success", "error" => "");
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    } else {
                        insertLog($security, "Kullanıcı silinemedi. E-Posta adresi: " . $email, $db, $userKont['id'], $db->getLastError());
                        $data = array("message" => "Kullanıcı Silinemedi", "type" => "danger", "error" => $db->getLastError());
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    }
                } else {
                    insertLog($security, "Kullanıcı silinemedi, yetersiz yetki. E-Posta adresi: " . $email, $db, $userKont['id'], "");
                    $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " kullanıcı silme işlemi için yetkin yok!", "type" => "danger", "error" => "userdel");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            }
        } else {
            $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " işlem yapma yetkin yok!", "type" => "danger", "error" => "set");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        }
    }
} else if ($islem == "sets") {
    if ($process == "view") {
        $yetki = $db->yetkikont("setview", "" . $userKont['id'] . "");
        if ($yetki == "1") {
            $db->orderBy("id", "desc");
            $pagesql = $db->get("settings");
            foreach ($pagesql as $key => $value) {
                $db->where("id", $value['langID']);
                $langs = $db->getOne('langs');

                $edit = $db->yetkikont("setedit", "" . $userKont['id'] . "");
                if ($edit == 1) {
                    $edtbtn = '<a href="setting.php?process=edit&id=' . $value['id'] . '" class="btn btn-dark"><i class="la la-edit "></i> Düzenle</a>';
                }
                $del = $db->yetkikont("setdel", "" . $userKont['id'] . "");
                if ($del == 1) {
                    //$delbtn = '<a href="?process=delete&id='.$value['id'].'"class="dropdown-item"><i class="la la-remove"></i> Sil</a>';
                    $delbtn = '<button type="button" class="btn btn-danger" name="set" data-id="' . $value['id'] . '" data-type="delete"><i class="la la-remove"></i> Sil</button>';
                }
                if ($edit == 1 || $del == 1) {
                    $pmenu = '<span class="dropdown">
                                <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                    <i class="la la-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ' . $edtbtn . ' 
                                </div>
                            </span>';
                } else {
                    $pmenu = "<div class='alert alert-danger'>Ayar düzenleme ve silme yetkiniz bulunmuyor</div>";
                }
                if ($value['aktif'] == 1) {
                    $btn = '<button class="btn btn-success" name="set" disabled>Varsayılan Ayar</div>';
                } else {
                    $btn = '<button type="button" class="btn btn-dark" name="set" data-id="' . $value['id'] . '" data-type="aktif">Varsayılan Yap</button>';
                }
                $darray["data"][] = array(
                    $value['id'],
                    $btn,
                    $langs['title'],
                    $value['siteurl'],
                    $value['baslik'],
                    $value['aciklama'],
                    $value['keywords'],
                    $value['adres'],
                    $edtbtn . '' . $delbtn
                );
            }
            insertLog($security, "Ayarlar görüntülendi.", $db, $userKont['id'], "");
            $json = json_encode($darray, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        } else {
            insertLog($security, "Ayarlar görüntülenemedi, yetkisiz işlem.", $db, $userKont['id'], "");
            $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " ayarları görüntülemek için yetkin yok!", "type" => "danger", "error" => "setview");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        }
    } else if ($process == "set") {
        $yetki = $db->yetkikont("set", "" . $userKont['id'] . "");
        if ($yetki == "1") {
            $setID = $_POST['id'];
            $tags = str_replace("\&quot;", '"', $_POST['kelime']);
            $kelime = json_decode($tags, true);
            $arraySize = count($kelime);
            $keywords = "";
            for ($i = 0; $i < $arraySize; $i++) {
                $keywords .= $kelime[$i]['value'] . ',';
            }
            $data = array(
                'baslik' => $_POST['baslik'],
                'aciklama' => $_POST['aciklama'],
                'keywords' => $keywords,
                'siteurl' => $_POST['siteurl'],
                'langID' => $_POST['langID'],
                'eposta' => $_POST['eposta'],
                'tel' => $_POST['tel'],
                'fax' => $_POST['fax'],
                'gsm' => $_POST['gsm'],
                'adres' => $_POST['adres'],
                'lat' => $_POST['lat'],
                'lng' => $_POST['lng'],
                'mailHost' => $_POST['mailHost'],
                'mailPort' => $_POST['mailPort'],
                'mailUser' => $_POST['mailUser'],
                'mailPass' => $_POST['mailPass']
            );
            if ($_POST['type'] == "edit") {
                $yetki = $db->yetkikont("setedit", "" . $userKont['id'] . "");
                if ($yetki == "1") {
                    $db->where('id', $setID);
                    $ssqldrm = $db->update('settings', $data);
                    if ($ssqldrm) {
                        insertLog($security, "Ayarlar düzenlendi", $db, $userKont['id'], "");
                        $jdata = array("message" => "Ayar Düzenlendi", "type" => "success", "error" => "");
                        $json = json_encode($jdata, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    } else {
                        insertLog($security, "Ayarlar düzenlenemedi.", $db, $userKont['id'], $db->getLastError());
                        $jdata = array("message" => "Ayar Düzenlenmedi", "type" => "danger", "error" => $db->getLastError());
                        $json = json_encode($jdata, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    }
                } else {
                    $jdata = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " ayar düzenleme işlemi için yetkin yok!", "type" => "danger", "error" => "setedit");
                    $json = json_encode($jdata, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            } else if ($_POST['type'] == "add") {
                $yetki = $db->yetkikont("setadd", "" . $userKont['id'] . "");
                if ($yetki == "1") {
                    $ssqldrm = $db->insert('settings', $data);
                    if ($ssqldrm) {
                        insertLog($security, "Ayar eklendi.", $db, $userKont['id'], "");
                        $data = array("message" => "Ayar Eklendi", "type" => "success", "error" => "");
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    } else {
                        insertLog($security, "Ayar eklenemedi, yetkisiz işlem.", $db, $userKont['id'], "");
                        $data = array("message" => "Ayar Eklenmedi", "type" => "danger", "error" => $db->getLastError());
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    }
                } else {
                    $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " ayar ekleme işlemi için yetkin yok!", "type" => "danger", "error" => "setadd");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            } else if ($_POST['type'] == "delete") {
                $yetki = $db->yetkikont("setdel", "" . $userKont['id'] . "");
                if ($yetki == "1") {
                    $db->where('id', $setID);
                    $ssqldrm = $db->delete('settings');
                    if ($ssqldrm) {
                        insertLog($security, "Ayar silindi.", $db, $userKont['id'], "");
                        $data = array("message" => "Ayar Silindi", "type" => "success", "error" => "");
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    } else {
                        insertLog($security, "Ayar silinemedi, yetkisiz işlem.", $db, $userKont['id'], $db->getLastError());
                        $data = array("message" => "Ayar Silinemedi", "type" => "danger", "error" => $db->getLastError());
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    }
                } else {
                    $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " Ayar silme işlemi için yetkin yok!", "type" => "danger", "error" => "setdel");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            } else if ($_POST['type'] == "aktif") {
                $yetki = $db->yetkikont("defaultset", "" . $userKont['id'] . "");
                if ($yetki == "1") {
                    $a = array('aktif' => 0);
                    $db->update('settings', $a);

                    $b = array('aktif' => 1);
                    $db->where('id', $setID);
                    $ssqldrm = $db->update('settings', $b);

                    if ($ssqldrm) {
                        $data = array("message" => "Ayar varsayılan olarak seçildi", "type" => "success", "error" => "");
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    } else {
                        $data = array("message" => "Ayar varsayılan olarak seçilemedi!", "type" => "danger", "error" => $db->getLastError());
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                        print_r($json);
                    }
                } else {
                    $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " varsayılan ayar atama yetkin yok!", "type" => "danger", "error" => "defaultset");
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
                    print_r($json);
                }
            }
        } else {
            $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " işlem yapma yetkin yok!", "type" => "danger", "error" => "postset");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        }
    }
} else if ($islem == "logs") {
    if ($process == "view") {
        $yetki = $db->yetkikont("logview", "" . $userKont['id'] . "");
        if ($yetki == "1") {

            $loglist = $db->get("logs");
            foreach ($loglist as $key) {

                $db->where("id", $key['UserID']);
                $user = $db->getOne("users");
                $logs = array(
                    $key['id'],
                    $user['name'] . " " . $user['surname'],
                    $key['date'],
                    $key['transaction'],
                    $key['Error'],
                    $key['userIP'],
                    $key['userOS'],
                    $key['userAgent'],
                );
                $darray['data'][] = $logs;
            }
            insertLog($security, "Loglar getirildi.", $db, $userKont['id'], "");
            $json = json_encode($darray, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        } else {
            $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " bu işlem için yetkin yok!", "type" => "danger", "error" => "");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
            print_r($json);
        }
    }
} else if ($islem == "bos") {
    $yetki = $db->yetkikont("", "" . $userKont['id'] . "");
    if ($yetki == "1") {
    } else {
        $data = array("title" => "Yetkişiz İşlem", "message" => "" . $userKont['name'] . " bu işlem için yetkin yok!", "type" => "danger", "error" => "");
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
        print_r($json);
    }
} else {
    $data = array("title" => "Yetkişiz İşlem", "message" => "" . print_r($_POST) . " " . $islem . " " . $process . "", "type" => "error", "error" => "could not be read a type");
    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    print_r($json);
}
