<?php
require_once "../bootstrap.php";

$response["user-login"] = false;
if(isset($_SESSION["USERNAME"])) {
    $response["user-login"] = true;
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];

    if(isset($_GET["id"]) && isset($_GET["action"])) {
        $notify_id = $_GET["id"];
        $action = $_GET["action"];
        if($action == "read") {
            $dbh->readNotification($notify_id);
            $response["message"] = "Notifica segnata come letta!";
        }
        if($action == "delete") {
            $dbh->deleteNotification($notify_id);
            $response["message"] = "Notifica eliminata";
        }
    }

    if(isset($_GET["type"])) {
        $type = $_GET["type"];
        if($type == 0) {
            $response["notifications"] = $dbh->getUnreadNotification($user_id);
        }
        if($type == 1) {
            $response["notifications"] = $dbh->getReadNotification($user_id);;
        }     
    }
}
echo json_encode($response);
?>