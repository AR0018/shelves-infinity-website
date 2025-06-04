<?php
require_once "bootstrap.php";
require "home_utilities/HomeHelper.php";
require "common_utils/base_utils.php";

$templateParams["title"] = "SheIn";
$templateParams["name"] = "home.php";
$templateParams["css"] = "./css/shein.css";
$templateParams["index"] = "#";
$path_helper = new PathHelper("");
$paths = $path_helper->getBasePaths();
/*$templateParams["window"] = "forms/dummy-form.php";*/

$num_products = 10; //Number of products to show for each group in the home page.
// Array containing informations about all the sections that must be in the home page.
$templateParams["sections"] = array(
    new HomeSection("Più Acquistati", $dbh->getMostSoldProducts($num_products)),
    new HomeSection("Nuove Aggiunte", $dbh->getMostRecentProducts($num_products)),
    new HomeSection("Più Popolari", $dbh->getMostPopularProducts($num_products))
);

$templateParams["welcome"] = true;

array_push($templateParams["js"], "./js/home.js");
require "template/base.php";
