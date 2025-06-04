<?php
require_once "../bootstrap.php";
require "cart-utils.php";

if(!isset($_SESSION["USERNAME"]) || $dbh->isSeller($_SESSION["USER_ID"])) {
    $response["user_login"] = false;
} else {
    $response["user_login"] = true;
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];
    if(isset($_GET["id"]) && isset($_GET["action"]) && $dbh->productExists($_GET["id"])) {
        $product_id = $_GET["id"];
        $available_quantity = $dbh->getAvailableQuantityByProduct($product_id)[0]["quantita_disponibile"];
        $action = $_GET["action"];
        $product = $dbh->isProductInTheCart($user_id, $product_id);
        if($action == "add" && isset($_GET["quantity"])) {
            $added_quantity = $_GET["quantity"];
            if (count($product) != 0) {
                $product = $product[0];
                $new_quantity = $product["quantita"] + $added_quantity;
                if(isQuantityValid($available_quantity, $new_quantity)) {
                    $dbh->updateQuantityProductInTheCart($user_id, $product_id, $new_quantity);
                    $response["message"] = "Prodotto aggiunto al carrello!";
                    $response["success"] = true;
                } else {
                    $response["message"] = "Impossibile aggiungere il prodotto al carrello: la disponibilità del prodotto è limitata.";
                    $response["success"] = false;
                }
            } else {
                if(isQuantityValid($available_quantity, $added_quantity)) {
                    $dbh->insertNewProductInTheCart($user_id, $product_id, $added_quantity);
                    $response["message"] = "Prodotto aggiunto al carrello!";
                    $response["success"] = true;
                }
                else {
                    $response["message"] = "Impossibile aggiungere il prodotto al carrello: il prodotto non è disponibile";
                    $response["success"] = false;
                }
            }
        } else if ($action == "remove") {
            if(count($product) != 0) {
                $dbh->deleteProductFromShoppingCart($user_id, $product_id);
                $response["success"] = true;
            } else {
                $response["success"] = false;
            }
        } else if ($action == "update" && isset($_GET["quantity"]) && count($product) != 0) {
            $product = $product[0];
            $new_quantity = $_GET["quantity"];
            $old_quantity = $product["quantita"];
            if(isQuantityValid($available_quantity, $new_quantity) || canDecreaseQuantity($new_quantity, $old_quantity)) {
                $dbh->updateQuantityProductInTheCart($user_id, $product_id, $new_quantity);
                $response["success"] = true;
            } else {
                $response["success"] = false;
                $response["old_quantity"] = $old_quantity;
            }
        } else {
            $response["request_error"] = "Invalid request to cart-api.php";
        }
    }
}

echo json_encode($response);

?>