<?php
const EMAIL_ALREADY_PRESENT = 1;
const USERNAME_ALREADY_PRESENT = 2;
/**
 * Provides some utility functions to register.php.
 */
class RegisterHelper
{
    private function setError($error)
    {
        global $templateParams;
        switch($error) {
            case EMAIL_ALREADY_PRESENT:
                $templateParams["loginerror"] = "Errore: questa email è già stata registrata.";
                break;
            case USERNAME_ALREADY_PRESENT:
                $templateParams["loginerror"] = "Errore: questo username è già stato registrato.";
                break;
        }
    }

    private function isUnique($instances, $error)
    {
        if (count($instances) != 0) {
            $this->setError($error);
            return false;
        }
        return true;
    }

    public function isEmailUnique($email)
    {
        global $dbh;
        return $this->isUnique($dbh->getEmail($email), EMAIL_ALREADY_PRESENT);
    }

    public function isUsernameUnique($username)
    {
        global $dbh;
        return $this->isUnique($dbh->getUsername($username), USERNAME_ALREADY_PRESENT);
    }
}