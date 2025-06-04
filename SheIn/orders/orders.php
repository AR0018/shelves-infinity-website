<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "SheIn - Ordini effettuati";
$templateParams["name"] = "order-list.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(!isset($_SESSION["USERNAME"])) {
    header("Location: ../user_management/login.php");
}

$user_id = $dbh->getUserID($_SESSION["USERNAME"])[0]["id"];
if($dbh->isSeller($user_id)) {
    $templateParams["orders"] = $dbh->getOrdersReceived($user_id);
    $templateParams["is_seller"] = true;
} else {
    $templateParams["orders"] = $dbh->getOrdersByUser($user_id);
    $templateParams["is_seller"] = false;
}

// For each order, loads the list of every item in the order, associating it to the corresponding order ID
foreach($templateParams["orders"] as $order) {
    $templateParams["order_items"][$order["codOrdine"]] = $dbh->getItemsByOrder($order["codOrdine"]);
}

array_push($templateParams["js"], "../js/orders-management.js");

require "../common_utils/base_utils.php";
require "../template/base.php";
?>