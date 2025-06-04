<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "SheIn - Stato dell'ordine";
$templateParams["name"] = "order-confirmation.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(!isset($_SESSION["USERNAME"]) || !isset($_GET["msg"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../index.php");
}

$templateParams["msg"] = $_GET["msg"];

if(isset($_GET["id"])) {
    $templateParams["title_msg"] = "Ordine confermato";
    $templateParams["id"] = $_GET["id"];
} else {
    $templateParams["title_msg"] = "Spiacenti: errore nell'ordine";
}

require "../common_utils/base_utils.php";
require "../template/base.php";
?>