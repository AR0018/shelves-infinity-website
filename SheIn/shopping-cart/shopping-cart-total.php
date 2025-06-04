<?php
require_once "../bootstrap.php";

if(!isset($_SESSION["USERNAME"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    header("Location: ../user_management/login.php");
}
else {
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];
    $products = $dbh->getProductInTheCart($user_id);
    $total_price = 0;
    $can_purchase = false;
    foreach ($products as $product) {
        $total_price += $product["prezzo"] * $product["quantita"];
        if($product["quantita"] > $product["quantita_disponibile"] || $product["quantita_disponibile"] == 0) {
            $msg = "Uno o più prodotti nel carrello non sono attualmente disponibili o lo sono in quantità ridotta,
            quindi non saranno inclusi nell'ordine o saranno inclusi con una quantità inferiore a quella specificata.";
        }

        if($product["quantita_disponibile"] != 0) {
            $can_purchase = true;
        }
    }

    if(!$can_purchase) {
        $msg = "Nessun prodotto nel carrello è disponibile per l'acquisto.";
    }

    $response["total_price"] = number_format($total_price, 2);
    $response["can_purchase"] = $can_purchase;
    if(isset($msg)) {
        $response["msg"] = $msg;
    }
}

echo json_encode($response);
?>