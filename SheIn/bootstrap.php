<?php
require_once "BootStrapHelper.php";
$bsh = new BootStrapHelper();
$bsh->sec_session_start();
define("UPLOAD_DIR", "./img/");
require_once "db/DataBaseHelper.php";
require_once "common_utils/PathHelper.php";
$dbh = new DataBaseHelper("localhost", "root", "", "shelves_infinity", 3306);
$templateParams["js"] = array();