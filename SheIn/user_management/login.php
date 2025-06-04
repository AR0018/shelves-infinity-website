<?php
require_once "AccessHelper.php";
require_once "LoginHelper.php";

const ATTEMPTS_LIMIT = 10;

$ah = new AccessHelper();
$lh = new LoginHelper();
$path_helper = new PathHelper();
$paths = $path_helper->getBasePaths();
if (
    isset($_POST["email"]) &&
    isset($_POST["password"]) &&
    isset($_POST["rand"]) &&
    isset($_SESSION["login-rand"]) &&
    isset($_COOKIE["sec_session_id"])
) {
    if($_POST["rand"] == $_SESSION["login-rand"]) {
        $lh->initLoginSession();
        if (!$lh->hasLoginFailedTooManyTimes()) {
            $username_array = $dbh->getUsernameByEmail($_POST["email"]);
            $user_exists = count($username_array) > 0;
            if($user_exists) {
                $username = $username_array[0]["username"];
                $loginResult = $dbh->checkLogin($username, $_POST["email"]);
            } else {
                $loginResult = [];
            }

            if ($lh->isLoginAttemptSuccessful($loginResult)) {
                $user_id = $dbh->getUserID($username)[0]["id"];
                $lh->resetOutdatedHash($loginResult[0]["password"]);
                $ah->setSessionInfo($username, $_POST["email"], $user_id);
                unset($_SESSION["login_ID"]);
                unset($_SESSION["num_failed_attempts"]);

                $_SESSION["psw_length"] = strlen($_POST["password"]);
            } else {
                $_SESSION["num_failed_attempts"] += 1;
                if($_SESSION["num_failed_attempts"] >= ATTEMPTS_LIMIT) {
                    $dbh->registerFailedAttempt($_SESSION["login_ID"], time());
                    unset($_SESSION["num_failed_attempts"]);
                }
                $templateParams["loginerror"] = "La mail o la password sono errate.";
            }
        } else {
            $templateParams["loginerror"] = "È stato raggiunto il limite di tentativi concessi.";
        }
        $_POST = [];
    }
}
$ah->redirect("SheIn - Login", "forms/login-form.php", "../js/login.js");

require "../common_utils/base_utils.php";
require "../template/base.php";
