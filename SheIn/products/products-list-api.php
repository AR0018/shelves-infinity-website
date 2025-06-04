<?php
require_once "../bootstrap.php";
$path_helper = new PathHelper();
$upload_dir = $path_helper->getUploadDir();

$products = [];

if(isset($_GET["categoria"])) {
    $category_id = $_GET["categoria"];
    $products = $dbh->getProductsByCategory($category_id);
} else if(isset($_GET["genere"])) {
    $genre_id = $_GET["genere"];
    $products = $dbh->getProductsByGenre($genre_id);
} else if(isset($_GET["nome"])) {
    $input_text = $_GET["nome"];
    $text = strtolower($input_text);
    $products = $dbh->getSearchProducts($text);
} else {
    $products = $dbh->getSearchProducts("");
}

for($i = 0; $i < count($products); $i++) {
    $products[$i]["generi"] = $dbh->getGenresByProductID($products[$i]["id"]);
    $products[$i]["immagine"] = $upload_dir.$products[$i]["immagine"];
}

echo json_encode($products);
?>
