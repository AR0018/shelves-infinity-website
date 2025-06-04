<div class="back-btn">
    <a href="./product-configuration.php">Indietro</a>
</div>

<?php
if(isset($templateParams["action"])) {
    $action = $templateParams["action"];

    if($action == "remove") {
        $disabled = true;
    }

    if(isset($templateParams["product"]) && isset($templateParams["product_genres"])) {
        $product = $templateParams["product"];

        $product_genres = array();
        foreach($templateParams["product_genres"] as $genre) {
            array_push($product_genres, $genre["genere"]);
        }
    }
}
?>

<div id="admin-form-ctn">
    <h2><?php echo $templateParams["form_title"]; ?></h2>

    <div class="pop-up error" id="popup-add-genre" style="display: none;">     
        <div class="pop-up-btn">
            <span>Errore</span>
            <button class="close" id="close-genre-popup-button">&times;</button>
        </div>
        <div class="pop-up-msg">
            <strong id="popup-genre-error-msg"></strong>           
        </div>
    </div>

    <?php if(!isset($disabled) || !$disabled): ?>
        <aside>
            <h3>Nel form non c'è il genere che cerchi?</h3>
            <form id="new-genre-form">
                <label for="new-genre-text">Nuovo genere:</label>
                <input type="text" id="new-genre-text" name="new-genre" required />
                <input type="submit" id="add-genre-button" name="add-genre" value="Aggiungi" />
            </form>
        </aside>
    <?php endif; ?>

    <?php if($action == "remove"): ?>
        <p>Rimuovendo il prodotto, questo non sarà più disponibile per l'acquisto, ma potrà comunque essere visualizzato nel negozio.</p>
    <?php endif; ?>
    <form id="product-admin-form" action="handle-product.php" method="POST" enctype="multipart/form-data">
        <h3>Form</h3>
        <div id="admin-name-products">
            <label for="nome_prodotto">Nome prodotto: </label>
            <input id="nome_prodotto" name="nome" type="text" value="<?php if(isset($product)) { echo $product["nome"]; } ?>"
            <?php if(isset($disabled)) { echo "disabled"; } ?> required/>
        </div>

        <div id="admin-height-products">
            <label for="altezza">Altezza: </label>
            <input id="altezza" name="altezza" type="number" step="0.01" min="0" value="<?php if(isset($product)) { echo $product["altezza"]; } ?>"
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> required/>
        </div>
        
        <div id="admin-length-products">
            <label for="larghezza">Larghezza: </label>
            <input id="larghezza" name="larghezza" type="number" step="0.01" min="0" value="<?php if(isset($product)) { echo $product["larghezza"]; } ?>"
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> required/>
        </div>
        
        <div id="admin-width-products">
            <label for="profondita">Profondità: </label>
            <input id="profondita" name="profondita" type="number" step="0.01" min="0" value="<?php if(isset($product)) { echo $product["profondita"]; } ?>"
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> required/>
        </div>
        
        <div id="admin-price-products">
            <label for="prezzo">Prezzo prodotto: </label>
            <input id="prezzo" name="prezzo" type="number" step="0.01" min="0" value="<?php if(isset($product)) { echo $product["prezzo"]; } ?>"
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> required/>
        </div>

        <div id="admin-quantity-products">
            <label for="quantita">Quantità prodotto: </label>
            <input id="quantita" name="quantita" type="number" min="0" value="<?php if(isset($product)) { echo $product["quantita_disponibile"]; } ?>"
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> required/>
        </div>

        <div id="admin-opera-products">
            <label for="opera_appartenenza">Opera di appartenenza: </label>
            <input id="opera_appartenenza" type="text" name="opera_di_appartenenza" value="<?php if(isset($product)) { echo $product["opera_di_appartenenza"]; } ?>"
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> required  />
        </div>

        <div id="admin-image-products">
            <label for="immagine">Scelta immagine</label>
            <input id="immagine" name="immagine" type="file"
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?>
            <?php if($action == "add") { echo "required";} ?> />
        </div>
        <?php if($action == "modify"): ?>
            <p><strong>Se non si specifica nessuna immagine, verrà mantenuta quella esistente.</strong></p>
        <?php endif; ?>
        
        <div id="admin-category-products">
            <label for="category_select">Scelta categoria:</label>
            <select id="category_select" name="categoria" <?php if(isset($disabled)) { echo "disabled"; } ?> required>
                <option value="">Scegli una categoria</option>
                <?php foreach($templateParams["categories"] as $category): ?>
                    <option id="<?php echo str_replace(" ", "", $category["nome"]); ?>" value="<?php echo htmlspecialchars($category["nome"]); ?>"
                    <?php if(isset($product) && $category["nome"] == $product["categoria"]) { echo "selected"; } ?>><?php echo $category["nome"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div id="admin-genre-products">
            <p>Scelta generi:</p>
            <div id="container-genre">
            <?php foreach($templateParams["genres"] as $genre):
                if(isset($product_genres)) {
                    $checked = in_array($genre["nome"], $product_genres);
                }?>
                <div>
                    <input type="checkbox" name="<?php echo $genre["nome"]; ?>" id="<?php echo $genre["nome"]; ?>" value="<?php echo $genre["nome"]; ?>"
                    <?php if(isset($checked) && $checked) {echo "checked"; } ?> <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> />
                    <label for="<?php echo $genre["nome"]; ?>"><?php echo $genre["nome"]; ?></label>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        
        <div id="admin-description-products">
            <label for="descrizione">Descrizione: </label>
            <textarea id="descrizione" name="descrizione" required
            <?php if(isset($disabled) && $disabled) { echo "disabled"; } ?> ><?php if(isset($product)) { echo $product["descrizione"]; } ?></textarea>
        </div>
        <button type="submit" name="submit"><?php echo $templateParams["form_title"]; ?></button>
        <input type="hidden" name="action" value="<?php echo $action; ?>" />
        <?php if(isset($product)): ?>
            <input type="hidden" name="id" value="<?php echo $product["id"]; ?>" />
            <?php if($action == "modify"): ?>
                <input type="hidden" name="old_img" value="<?php echo $product["immagine"]; ?>" />
                <input type="hidden" name="old_quantity" value="<?php echo $product["quantita_disponibile"]; ?>" />
            <?php endif; ?>
        <?php endif; ?>
    </form>
</div>