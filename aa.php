<?php 
session_start();
$_SESSION['dil'] = "TR";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'bwp-includes/vendor/autoload.php';
include 'bwp-includes/settings.php';
include 'bwp-includes/classes/sender.php';

$dil = $_SESSION['dil'];

function spamControl($db, $ip, $useragent, $browser, $os, $minute)
{

    $time = new DateTime(date("Y-m-d H:i:s"));
    $time->modify($minute . ' minutes');
    $stamp = $time->format('Y-m-d H:i:s');

    $db->where("userIP", $ip);
    $db->where("userOS", $os);
    $db->where("userAgent", $useragent);
    $db->where("date",$stamp,"<");    
    $logs = $db->get("logs");
    $a =  array("title" => "" . "AA" . "", "message" => " Sayı : " . count($logs) . "", "type" => "error");
    return $a;
}


//$idata = spamControl($db,$security->getIP(),$security->getUserAgent(),$security->getBrowser(),$security->getOS(),5);

$data = array(
    "transaction" => "asdasd",
    "userIP" => "" . $security->getIP() . "",
    "userOS" => "" . $security->getOS() . "",
    "userLang" => "" . $security->getLang() . "",
    "userAgent" => "" . $security->getUserAgent() . ""
);
$insert = $db->insert("logs", $data);

$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
print_r($json);
?>