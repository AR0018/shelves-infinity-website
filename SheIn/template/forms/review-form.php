<?php if(isset($templateParams["productID"])):?>
    <div class="back-btn">
        <a href="../products/product.php?id=<?php echo $templateParams["productID"]; ?>">Indietro</a>
    </div>
<?php endif; ?>

<div class="review-form">
    <?php
    if(isset($templateParams["review"])) {
        $action_text = "Modifica";
        $review = $templateParams["review"];
    }
    else {
        $action_text = "Scrivi";
    }

    if(!isset($templateParams["productID"])):
    ?>
        <p>Spiacenti, il prodotto che si intende recensire non esiste.</p>
    <?php else: ?>
        <form action="handle-review.php" method="post" oninput="r.value=parseInt(rating.value)">
            <h2><?php echo $action_text; ?> Recensione</h2>
            <ul>
                <li>
                    <label for="rating">Punteggio:</label><output name="r" for="rating"><?php
                        if(isset($review)) {
                            echo $review["punteggio"];
                        } ?></output><input type="range" id="rating" name="rating" min="1" max="5"
                        <?php if(isset($review)): ?> value="<?php echo $review["punteggio"]; ?>"<?php endif; ?>/>
                </li>
                <li>
                    <label for="description">Descrizione:</label><textarea id="description" name="description"><?php 
                        if(isset($review)) {
                            echo $review["descrizione"];
                        } ?></textarea>
                </li>
                <li>
                    <?php
                        $go_back_url = "../products/product.php?id=".$templateParams["productID"];
                    ?>
                    <button onclick="window.location.replace(<?php echo $go_back_url?>)">Annulla</button>
                    <input type="submit" name="submit" value="Conferma"/>
                </li>
            </ul>
            <input type="hidden" name="action" value="<?php 
            if(isset($review)){
                echo "modify";
            }
            else {
                echo "insert";
            } ?>" />
            <input type="hidden" name="productID" value="<?php echo $templateParams["productID"] ?>" />
        </form>
    <?php endif; ?>
</div>