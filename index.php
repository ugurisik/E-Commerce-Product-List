<?php
session_start();
?>
<?php
include 'bwp-includes/settings.php';

if (!isset($_GET['type'])) {
    $stiphome = 'index';
} else {
    $stiphome = $_GET['type'];
}
switch ($stiphome) {
    case 'index':
        include THEMEDIR . 'index.php';
        break;
    case 'ana-sayfa':
        include THEMEDIR . 'index.php';
        break;
    case 'urun':
        include THEMEDIR . 'product-detail.php';
        break;
    case 'kategori':
        include THEMEDIR . 'product-listing.php';
        break;
}
