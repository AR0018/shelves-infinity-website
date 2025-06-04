<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "Profilo";
$templateParams["name"] = "profile.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(!isset($_SESSION["USERNAME"])) {
    header("Location: ../user_management/login.php");
} else {
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];
    $email = $dbh->getEmailById($user_id)[0]["email"];
    if(isset($_GET["usr_msg"])) {
        $templateParams["usr_msg"] = $_GET["usr_msg"];
    }
    if(isset($_GET["psw_msg"])) {
        $templateParams["psw_msg"] = $_GET["psw_msg"];
    }
}

array_push($templateParams["js"], "../js/profile.js");

require "../common_utils/base_utils.php";
require "../template/base.php";
?>