<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["name"] = "forms/product-form.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

$actions["add"] = "Aggiungi prodotto";
$actions["modify"] = "Modifica prodotto";
$actions["remove"] = "Rimuovi prodotto";

if(!isset($_SESSION["USERNAME"])) {
    header("Location: ../user_management/login.php");
}

if(!$dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../index.php");
}

if(isset($_GET["action"])) {
    $action = $_GET["action"];
    if(!array_key_exists($action, $actions)) {
        header("Location: ../index.php");
    }
    $templateParams["action"] = $action;
    $templateParams["form_title"] = $actions[$action];
    $templateParams["title"] = "SheIn - ".$templateParams["form_title"];

    if(isset($_GET["id"])) {
        $product_id = $_GET["id"];
        if($dbh->productExists($product_id)) {
            $templateParams["product"] = $dbh->getProductByID($product_id)[0];
            $templateParams["product_genres"] = $dbh->getGenresByProductID($product_id);
        }
    }
} else {
    header("Location: ../index.php");
}

array_push($templateParams["js"], "../js/product-operation.js");

require "../common_utils/base_utils.php";
require "../template/base.php";
?>