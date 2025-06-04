<?php
// File contains some function used by multiple documents
$templateParams["categories"] = $dbh->getCategories();
$templateParams["genres"] = $dbh->getGenres();

$current_page = basename(strtok($_SERVER["REQUEST_URI"], '?'));
if($current_page == "index.php" || $current_page == "SheIn") {
    $prefix = "./";
} else {
    $prefix = "../";
}
array_push($templateParams["js"], $prefix."js/base.js");
$templateParams["css"] = $prefix."css/shein.css";
$templateParams["index"] = $prefix."index.php";
?>