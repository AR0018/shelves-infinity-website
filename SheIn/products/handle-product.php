<?php
require_once "../bootstrap.php";
require "product-utils.php";

$path_helper = new PathHelper();
$upload_dir = $path_helper->getUploadDir();

if(isset($_SESSION["USERNAME"]) && isset($_POST["action"]) && $dbh->isSeller($_SESSION["USER_ID"])) {
    $action = $_POST["action"];
    $nome = $_POST["nome"];
    $altezza = $_POST["altezza"];
    $larghezza = $_POST["larghezza"];
    $profondita = $_POST["profondita"];
    $prezzo = $_POST["prezzo"];
    $quantita = $_POST["quantita"];
    $opera_appartenenza = $_POST["opera_di_appartenenza"];
    $categoria = $_POST["categoria"];
    $descrizione = $_POST["descrizione"];

    // Get the selected genres
    $genres = $dbh->getGenres();
    $selected_genres = array();
    foreach ($genres as $genre) {
        if(isset($_POST[$genre["nome"]])) {
            array_push($selected_genres, $genre["nome"]);
        }
    }

    if($action == "add") {
        $upload_result = upload_image($_FILES["immagine"], $upload_dir);
        if($upload_result["success"]) {
            $img_name = $upload_result["message"];
            $new_id = $dbh->addProduct(
                    $nome,
                    $prezzo,
                    $quantita,
                    $img_name,
                    $descrizione,
                    $opera_appartenenza,
                    $altezza,
                    $larghezza,
                    $profondita,
                    $categoria,
                    $selected_genres);
            if($new_id) {
                $msg = "Il prodotto è stato aggiunto con successo! ID del prodotto: ".$new_id;
                $success = true;
            } else {
                $msg = "Si è verificato un errore nell'aggiunta del prodotto.";
                $success = false;
            }
            
        } else {
            $msg = "Errore nel caricamento dell'immagine: ".$upload_result["message"];
            $success = false;
        }
    } else if($action == "modify" || $action == "remove") {
        if(isset($_POST["id"])) {
            $product_id = $_POST["id"];
            if($dbh->productExists($product_id)) {
                if($action == "modify") {
                    $old_img = $_POST["old_img"];
                    $old_quantity = $_POST["old_quantity"];
                    // Handles the upload of the new image and removes the previous one
                    if($_FILES["immagine"]["name"] != "") {
                        $upload_result = upload_image($_FILES["immagine"], $upload_dir);
                        if($upload_result["success"]) {
                            $img_name = $upload_result["message"];
                            delete_image($old_img, $upload_dir);
                        } else {
                            $msg = "Errore nel caricamento dell'immagine: ".$upload_result["message"]." Il prodotto è stato comunque modificato con gli altri parametri impostati.";
                            $img_name = $old_img;
                            $success = false;
                        }
                    } else {
                        $img_name = $old_img;
                    }

                    $success = $dbh->modifyProduct(
                            $product_id,
                            $nome,
                            $prezzo,
                            $quantita,
                            $img_name,
                            $categoria,
                            $descrizione,
                            $opera_appartenenza,
                            $altezza,
                            $larghezza,
                            $profondita,
                            $selected_genres);
                    if($success) {
                        if($old_quantity == 0 && $quantita > $old_quantity) {
                            $date_time = date("Y-m-d H:i:s");
                            $cart_users = $dbh->getUsersByProductInCart($product_id);
                            foreach ($cart_users as $user) {
                                $notification_msg = "Il prodotto ".$nome." nel tuo carrello è finalmente disponibile!";
                                $dbh->sendNotification($user["codCliente"], $notification_msg, $date_time);
                            }

                            $favourites_users = $dbh->getUsersByProductInFavourites($product_id);
                            var_dump($favourites_users);
                            foreach ($favourites_users as $user) {
                                $notification_msg = "Il prodotto ".$nome." nei tuoi preferiti è finalmente disponibile!";
                                $dbh->sendNotification($user["codCliente"], $notification_msg, $date_time);
                            }
                        }
                        $msg = "Il prodotto con ID = ".$product_id." è stato modificato con successo!";
                        $success = true;
                    } else {
                        $msg = "Si è verificato un errore nella modifica del prodotto.";
                        $success = false;
                    }
                } else {
                    if($dbh->modifyQuantityProduct($product_id, 0)) {
                        $msg = "Il prodotto con ID = ".$product_id." è stato rimosso dagli scaffali con successo!";
                        $success = true;
                    } else {
                        $msg = "Si è verificato un errore nella rimozione del prodotto.";
                        $success = false;
                    }
                }

            } else {
                $msg = "Errore nell'operazione: il prodotto non esiste.";
                $success = false;
            }
        }
    }
} else if (!$dbh->isSeller($_SESSION["USER_ID"])) {
    $msg = "User pemission denied: user is not a seller.";
    $success = false;
}

if(isset($msg)) {
    header("Location: product-configuration.php?msg=".$msg."&success=".$success);
} else {
    header("Location: ../index.php");
}
?>

