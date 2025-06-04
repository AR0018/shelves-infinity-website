<?php
require_once "../bootstrap.php";

if(!isset($_SESSION["USERNAME"])) {
    $response["user_login"] = false;
} else {
    $username = $_SESSION["USERNAME"];
    $user_id = $dbh->getUserID($username)[0]["id"];
    if(!$dbh->isSeller($user_id)) {
        $response["error_msg"] = "User pemission denied: user is not a seller.";
    } else {
        if(!isset($_GET["id"]) || !isset($_GET["action"])) {
            $response["error_msg"] = "Incomplete GET request";
        } else {
            switch ($_GET["action"]) {
                case 'send':
                    $new_state = "Spedito";
                    $new_text = "Conferma consegna";
                    break;
                case 'deliver':
                    $new_state = "Consegnato";
                default:
                    break;
            }

            $order_id = $_GET["id"];

            if($dbh->updateOrderState($order_id, $new_state)) {
                $date_time = date("Y-m-d H:i:s");
                $customer_id = $dbh->getCustomerIDByOrder($order_id)[0]["codCliente"];
                $notification_msg = "Il tuo ordine con ID = ".$order_id." è stato ".$new_state.".";
                $dbh->sendNotification($customer_id, $notification_msg, $date_time);
                if(isset($new_text)) {
                    $response["new_text"] = $new_text;
                }
                $response["new_state"] = $new_state;
            }
        }
    }
}

echo json_encode($response);

?>