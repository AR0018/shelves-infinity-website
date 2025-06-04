<?php
/**
 * Checks whether the given input data is valid, and returns a message if it's not.
 * In case there's no error, the output of this function is null.
 * @param int $product_id the ID of the product for which to write the review
 * @param int $rating the desired rating of the product
 * @return string $msg the error message, null if there is no error
 */
function checkReviewInput($product_id, $rating) {
    $msg = null;
    global $dbh;

    if(!$dbh->productExists($product_id)) {
        $msg = "Errore nell'invio del form: Il prodotto che si vuole recensire non esiste.";
    }

    if($rating < 1 || $rating > 5) {
        $msg = "Errore nell'invio del form: Il punteggio specificato non è compreso tra 1 e 5.";
    }

    return $msg;
}
?>