<?php
require_once "../bootstrap.php";
/**
 * Manages some common elements between registration and login.
 */
class AccessHelper
{
    /**
     * Sets the cookies for the current logged session.
     * @param mixed $username
     * @param mixed $email
     * @return void
     */
    public function setSessionInfo($username, $email, $user_id)
    {
        $_SESSION["USERNAME"] = $username;
        $_SESSION["EMAIL"] = $email;
        $_SESSION["USER_ID"] = $user_id;
    }

    /**
     * Chooses where to redirect after login or registration.
     * @param mixed $title
     * @param mixed $file
     * @param string $javascriptPath the path of the Javascript file used by the page.
     *  If an empty string is passed, no file is included.
     * @return void
     */
    public function redirect($title, $file, $javascriptPath)
    {
        global $dbh;
        global $templateParams;
        if (isset($_SESSION["EMAIL"])) {
            header("Location: ../index.php");
        } else {
            $templateParams["title"] = $title;
            $templateParams["name"] = $file;
            if($javascriptPath != "") {
                array_push($templateParams["js"], $javascriptPath);
            }
        }
    }
}