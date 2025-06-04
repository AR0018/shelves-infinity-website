<?php
require_once "../bootstrap.php";

$userID = $_SESSION["USER_ID"];

if(isset($userID) && $dbh->isSeller($userID)) {
    if(isset($_POST["operation"])) {
        if($_POST["operation"] == "add") {
            if(isset($_POST["new_genre"])) {
                if($dbh->addGenre($_POST["new_genre"])) {
                    $info_msg = "The genre was added successfully!";
                } else {
                    $error_msg = "Non è stato possibile aggiungere il genere. "
                      . "Verificare che un genere con lo stesso nome non esista già.";
                }
            } else {
                $error_msg = "Bad request: the genre name is not specified.";
            }
        } else {
            $error_msg = "Bad request: the given operation does not exist.";
        }
    } else {
        $error_msg = "Bad request: the operation is not specified.";
    }
} else {
    $error_msg = "Can't execute operation: user is not logged in or is not authorized to access.";
}

if(isset($error_msg)) {
    $response["error_msg"] = $error_msg;
}
if(isset($info_msg)) {
    $response["info_msg"] = $info_msg;
}

echo json_encode($response);
?>
