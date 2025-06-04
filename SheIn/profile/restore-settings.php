<?php
require_once "../bootstrap.php";

if(!isset($_SESSION["USERNAME"])) {
    header("Location: ../user_management/login.php");
} else {
    $username = $_SESSION["USERNAME"];
    $user_id = $_SESSION["USER_ID"];
    if(isset($_POST["new_usr"])) {
        $username = $_POST["new_usr"];
        $validation_usr = $dbh->getUsername($username);
        if(count($validation_usr) > 0) {
            $username_msg = "Il nome utente esiste già!";
            $success = false;
        } else {
            $dbh->modifyUsername($user_id, $username);
            $_SESSION["USERNAME"] = $username;
            $username_msg = "Il nome utente è stato modificato con successo!";
            $success = true;
        }
    } else if(isset($_POST["old_psw"]) && isset($_POST["new_psw"])) {
        $old_psw = $_POST["old_psw"];
        $nw_psw = password_hash($_POST["new_psw"], PASSWORD_DEFAULT);
        if(password_verify($old_psw, $dbh->getPassword($user_id)[0]["password"])) {
            $dbh->modifyPassword($user_id, $nw_psw);
            $psw_msg = "La password è stata modificata correttamente!";
            $success = true;
        } else {
            $psw_msg = "La password precedente non è corretta!";
            $success = false;
        }
    } else {
        $error_msg = "Bad Request: invalid arguments";
    }
}

if(isset($username_msg) && isset($success)) {
    $response["username_msg"] = $username_msg;
    $response["success"] = $success;
} else if(isset($psw_msg) && isset($success)) {
    $response["password_msg"] = $psw_msg;
    $response["success"] = $success;
} else if(isset($error_msg)) {
    $response["error_msg"] = $error_msg;
    $response["success"] = false;
}

if(isset($response)) {
    echo json_encode($response);
}

?>