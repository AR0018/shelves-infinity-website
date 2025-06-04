<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "SheIn - Riepilogo dell'Ordine";
$templateParams["name"] = "order-recap-page.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(!isset($_SESSION["USERNAME"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../index.php");
}

$user_id = $dbh->getUserID($_SESSION["USERNAME"])[0]["id"];
$products = $dbh->getProductInTheCart($user_id);

$order_items = array();
$total_price = 0;

foreach ($products as $product) {
    if($product["quantita_disponibile"] == 0) {
        $msg = "Uno o più prodotti presenti nel carrello non sono attualmente disponibili oppure sono
            disponibili in quantità ridotta, e dunque sono stati rimossi dall'ordine o sono stati inclusi
            con una quantità inferiore a quella specificata nel carrello.";
    } else {
        if($product["quantita"] > $product["quantita_disponibile"]) {
            $product["quantita"] = $product["quantita_disponibile"];
            $msg = "Uno o più prodotti presenti nel carrello non sono attualmente disponibili oppure sono
                disponibili in quantità ridotta, e dunque sono stati rimossi dall'ordine o sono stati inclusi
                con una quantità inferiore a quella specificata nel carrello.";
        }
        $order_items[] = $product;
        $total_price += $product["quantita"] * $product["prezzo"];
    }
}

$templateParams["order_items"] = $order_items;
$templateParams["total_price"] = $total_price;

if(isset($msg)) {
    $templateParams["info_msg"] = $msg;
}

require "../common_utils/base_utils.php";
require "../template/base.php";
?>