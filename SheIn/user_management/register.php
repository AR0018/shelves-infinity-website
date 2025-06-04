<?php
require_once "AccessHelper.php";
require_once "RegisterHelper.php";
$ah = new AccessHelper();
$rh = new RegisterHelper();

$path_helper = new PathHelper();
$paths = $path_helper->getBasePaths();

if (
    isset($_POST["email"]) &&
    isset($_POST["username"]) &&
    isset($_POST["password1"]) &&
    isset($_POST["password2"]) &&
    isset($_POST["rand"]) &&
    isset($_SESSION["register-rand"])
) {
    if (
        $_POST["rand"] == $_SESSION["register-rand"] &&
        $rh->isEmailUnique($_POST["email"]) &&
        $rh->isUsernameUnique($_POST["username"])
    ) {
        $hash = password_hash($_POST["password1"], PASSWORD_DEFAULT);
        if (password_verify($_POST["password2"], $hash)) {
            $dbh->addUser($_POST["username"], $_POST["email"], $hash);
            $user_id = $dbh->getUserID($_POST["username"])[0]["id"];
            $ah->setSessionInfo($_POST["username"], $_POST["email"], $user_id);
            $_SESSION["psw_length"] = strlen($_POST["password1"]);
        } else {
            $templateParams["loginerror"] = "Errore: le password non coincidono.";
        }
    }
    $_POST = [];
}
$ah->redirect("SheIn - Register", "forms/register-form.php", "../js/register.js");
require "../common_utils/base_utils.php";
require "../template/base.php";
