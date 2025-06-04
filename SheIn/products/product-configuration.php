<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "SheIn - Gestione Prodotti";
$templateParams["name"] = "products-admin-page.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

$templateParams["products"] = $dbh->getProducts();
$templateParams["form"] = "../template/forms/products-form.php";
if(isset($_GET["msg"])) {
    $templateParams["msg"] = $_GET["msg"];
}
if(isset($_GET["success"])) {
    $templateParams["success"] = $_GET["success"];
}

array_push($templateParams["js"], "../js/product-configuration.js");
require "../common_utils/base_utils.php";
require "../template/base.php";
?>
