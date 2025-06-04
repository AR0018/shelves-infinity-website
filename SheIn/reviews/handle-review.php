<?php
require_once "../bootstrap.php";
require "review-utils.php";

if(!isset($_SESSION["USERNAME"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../user_management/login.php");
}

if(!isset($_POST["productID"])) {
    header("Location: ../index.php");
}

$username = $_SESSION["USERNAME"];
$userid = $dbh->getUserID($username)[0]["id"];
$product_id = $_POST["productID"];
$rating = $_POST["rating"];
$desc = $_POST["description"];
$date = date("Y-m-d");
$date_time = date("Y-m-d H:i:s");

$msg = checkReviewInput($product_id, $rating);

if($msg == null) {
    if($_POST["action"] == "insert") {
        $success = $dbh->addReview($userid, $product_id, $rating, $desc, $date);
        if($success) {
            $dbh->updateMediumRating($product_id);
            $product_name = $dbh->getProductNameByID($product_id)[0]["nome"];
            $notification_msg = "L'utente ".$username." ha recensito il prodotto ".$product_name." avente ID = ".$product_id.".";
            $dbh->sendNotification(1, $notification_msg, $date_time);
            $msg = "Recensione scritta con successo!";
        }
        else {
            $msg = "Errore nell'inserimento della recensione.";
        }
    }
    else if($_POST["action"] == "modify") {
        $review = $dbh->getReviewByUsernameAndProductID($username, $product_id);
        if(count($review) != 0) {
            $success = $dbh->modifyReview($userid, $product_id, $rating, $desc, $date);
            if($success) {
                $dbh->updateMediumRating($product_id);
                $msg = "Recensione modificata con successo!";
            }
            else {
                $msg = "Errore nella modifica della recensione.";
            }
        }
        else {
            $msg = "Errore: la recensione che si vuole modificare non esiste.";
        }
    }
    else {
        $msg = "Errore nell'invio del form: Azione richiesta non valida.";
    }
}

header("Location: ../products/product.php?id=".$product_id."&reviewmsg=".$msg);
?>