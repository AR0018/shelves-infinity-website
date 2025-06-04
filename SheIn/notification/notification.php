<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "Notifiche";
$templateParams["name"] = "notification-section.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(isset($_SESSION["USERNAME"])) {
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];
}
else {
    header("Location: ../user_management/login.php");
}

array_push($templateParams["js"], "../js/notification.js");
require "../common_utils/base_utils.php";
require "../template/base.php";
?>