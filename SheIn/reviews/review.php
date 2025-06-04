<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "SheIn - Recensione";
$templateParams["name"] = "forms/review-form.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(!isset($_SESSION["USERNAME"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../user_management/login.php");
}

if(isset($_GET["id"]) && isset($_GET["action"])) {
    $user = $_SESSION["USERNAME"];
    $product_id = $_GET["id"];
    if($dbh->productExists($product_id)) {
        $templateParams["productID"] = $product_id;
    }
    $action = $_GET["action"];
    if($action == "modify") {
        $review = $dbh->getReviewByUsernameAndProductID($user, $product_id);
        if(count($review) != 0) {
            $templateParams["review"] = $review[0];
        }
    }
    
}

require "../common_utils/base_utils.php";
require "../template/base.php";
?>