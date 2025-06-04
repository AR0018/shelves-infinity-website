<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "SheIn - Dettagli Prodotto";
$templateParams["name"] = "product-details.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(isset($_GET["id"])) {
    $product_id = $_GET["id"]; 
    $templateParams["product"] = $dbh->getProductByID($product_id);
    $templateParams["reviews"] = $dbh->getReviewsByProductID($product_id);

    if(isset($_SESSION["USERNAME"])) {
        if(!$dbh->isSeller($_SESSION["USER_ID"])) {
            $review = $dbh->getReviewByUsernameAndProductID($_SESSION["USERNAME"], $product_id);
            if(count($review) != 0) {
                $templateParams["userreview"] = $review[0];
            }
        } else {
            $templateParams["seller"] = true;
        }
    }

    if(isset($_GET["reviewmsg"])) {
        $templateParams["reviewmsg"] = $_GET["reviewmsg"];
    }
}
else {
    header("Location: ../index.php");
}

array_push($templateParams["js"], "../js/product-details.js");

require "../common_utils/base_utils.php";
require "../template/base.php";
?>