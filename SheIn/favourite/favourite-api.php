<?php 
require_once "../bootstrap.php";

if(isset($_SESSION["USERNAME"]) && !$dbh->isSeller($_SESSION["USER_ID"])) {
    $response["user_login"] = true;
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];

    if(isset($_GET["id"])) {
        $product_id = $_GET["id"];
        if(count($dbh->isFavourite($user_id, $product_id)) > 0) {
            $dbh->deleteFavourite($user_id, $product_id);
            $response["message"] = "Prodotto eliminato dai preferiti!";
            $response["success"] = true;
        } else {
            $response["message"] = "Prodotto non presente tra i preferiti!";
            $response["success"] = false;
        }
        if(isset($_GET["action"]) && $_GET["action"] == "add") {
            $dbh->insertFavourite($user_id, $product_id);
            $response["message"] = "Prodotto aggiunto ai preferiti!";
            $response["success"] = true;
        }
    }
} else {
    $response["user_login"] = false;
}

echo json_encode($response);