<?php

/**
 * Provides some utility functions to login.php.
 */
class LoginHelper
{
    /**
     * Initializes information about the current login session.
     */
    public function initLoginSession() {
        if(!isset($_SESSION["login_ID"])) {
            $_SESSION["login_ID"] = $_COOKIE["sec_session_id"];
        }
        if(!isset($_SESSION["num_failed_attempts"])) {
            $_SESSION["num_failed_attempts"] = 0;
        }
    }

    /**
     * Checks if someone that is trying to login has reached the limit of permitted attempts.
     * @return bool True when the number of attempts surpasses the limit, false otherwise.
     */
    public function hasLoginFailedTooManyTimes()
    {
        global $dbh;
        return count($dbh->getFailedLoginAttempts($_SESSION["login_ID"], time())) > 0;
    }

    /**
     * Checks the success of the login.
     * @param mixed $loginResult The array containing the password.
     * @return bool
     */
    public function isLoginAttemptSuccessful($loginResult)
    {
        return (count($loginResult) != 0) &&
            (password_verify($_POST["password"], $loginResult[0]["password"]));
    }

    /**
     * Updates the password hash when the hash algorithm that PHP uses changes and puts the new hash into the database.
     * @param mixed $password
     * @return void
     */
    public function resetOutdatedHash($password)
    {
        global $dbh;
        if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
            $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $dbh->setPassword($_POST["email"], $_POST["password"]);
        }
    }
}