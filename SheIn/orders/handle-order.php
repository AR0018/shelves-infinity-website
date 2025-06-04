<?php
require_once "../bootstrap.php";

if(!isset($_SESSION["USERNAME"]) || !isset($_POST["items"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../index.php");
} else {
    $products = unserialize(htmlspecialchars_decode($_POST["items"]));

    $user_id = $dbh->getUserID($_SESSION["USERNAME"])[0]["id"];
    $date = date("Y-m-d");
    $date_time = date("Y-m-d H:i:s");
    $shipping_address = $_POST["address"];
    $total_price = $_POST["price"];
    $shipping_status = "Confermato";

    $order_id = $dbh->addOrder($user_id, $date, $shipping_address, $total_price, $shipping_status);
    $success = false;
    if($order_id != false) {
        $success = true;
        foreach ($products as $product) {
            $product_id = $product["codProdotto"];
            $quantity = $product["quantita"];
            $new_quantity = $product["quantita_disponibile"] - $quantity;
            $item_added = $dbh->addOrderItem($product_id, $order_id, $quantity);
            $quantity_modified = $dbh->modifyQuantityProduct($product_id, $new_quantity);
            if(!$item_added || !$quantity_modified) {
                $success = false;
            } else {
                if($new_quantity == 0) {
                    $product_name = $dbh->getProductNameByID($product_id)[0]["nome"];
                    $dbh->sendNotification(1, "Il prodotto ".$product_name." avente ID = ".$product_id." è esaurito."."<br>"."Puoi rifornire le scorte nella sezione Gestione prodotti del tuo profilo.", $date_time);
                }
            }
        }
    }
    if($success) {
        $dbh->emptyShoppingCart($user_id);
        $msg = "Il tuo ordine è stato registrato con successo!";
        $notification_msg = "Hai ricevuto un nuovo ordine con ID = ".$order_id.".<br>"."Puoi consultare i dettagli sull'ordine nella sezione Ordini del tuo profilo.";
        $dbh->sendNotification(1, $notification_msg, $date_time);
        header("Location: order-results.php?msg=".$msg."&id=".$order_id);
    } else {
        $msg = "Si è verificato un errore durante la gestione dell'ordine.";
        header("Location: order-results.php?msg=".$msg);
    }
}
?>