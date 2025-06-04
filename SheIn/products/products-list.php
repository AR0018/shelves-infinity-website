<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$templateParams["title"] = "Lista Prodotti";
$templateParams["name"] = "products-search-list.php";
$templateParams["upload_dir"] = $path_helper->getUploadDir();

$paths = $path_helper->getBasePaths();

if(isset($_GET["categoria"])) {
    $category_id = $_GET["categoria"]; 
}
if(isset($_GET["genere"])) {
    $genre_id = $_GET["genere"];
}
if(isset($_GET["nome"])) {
    $input_text = $_GET["nome"];
}

array_push($templateParams["js"], "../js/products-list.js");

require "../common_utils/base_utils.php";
require "../template/base.php";
?>