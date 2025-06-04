<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "Shopping Cart";
$templateParams["name"] = "cart.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(!isset($_SESSION["USERNAME"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../user_management/login.php");
}
else {
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];
    $templateParams["shopping_products"] = $dbh->getProductInTheCart($user_id);
}

array_push($templateParams["js"], "../js/shopping-cart.js");

require "../common_utils/base_utils.php";
require "../template/base.php";
?>