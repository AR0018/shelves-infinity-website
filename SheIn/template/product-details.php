<div class="back-btn">
    <a href="../index.php">Indietro</a>
</div>

<?php $product = $templateParams["product"][0]; ?>

<article class="product-details">

    <div class="pop-up" id="pop-up-product">
        <div class="pop-up-btn">
            <span>Notifica operazione</span>
            <button class="close">&times;</button>
        </div>
        <div class="pop-up-msg">
        <?php if(isset($templateParams["reviewmsg"])): ?>
            <p><?php echo $templateParams["reviewmsg"]; ?></p>
        <?php endif; ?>
        </div>
    </div>

    <h2><?php echo $product["nome"]; ?></h2>
    <div class="ctn-product-details">
        <div><img src="<?php echo $templateParams["upload_dir"].$product["immagine"]; ?>" alt=""/></div>
        <aside>
            <p>Prezzo: <strong><?php echo $product["prezzo"]; ?> €</strong></p>
            <p>Valutazione: 
                <?php 
                if($product["punteggio_medio"] == null ) {
                    echo "Nessuna recensione";
                } else {
                    echo number_format($product["punteggio_medio"], 1)." ";
                } ?> </p>
            <div class="mean-stars">
                <?php if($product["punteggio_medio"] != null ) {
                    for ($i=0; $i<5; $i++) {
                        if ($i < $product["punteggio_medio"]) {
                            echo '<span class="fa fa-star checked"></span>';
                        } else {
                            echo '<span class="fa fa-star"></span>';
                        }
                    }
                } ?>
            </div>
            <p>Quantità disponibile: <strong><?php echo $product["quantita_disponibile"];?></strong></p>
            <?php if(!isset($templateParams["seller"])): ?>
                <form id="buttons_form">
                    <?php if($product["quantita_disponibile"] != 0): ?>
                    <label for="quantity">Quantità da acquistare:</label><input type="number" id="quantity" name="quantity" min="1" max="<?php echo $product["quantita_disponibile"]; ?>" value="1"/>
                    <input type="button" name="cart" id="cartButton" value="Aggiungi al Carrello"/>
                    <?php endif; ?>
                    <input type="button" name="favourite" id="favouriteButton" value="Aggiungi ai Preferiti"/>
                </form>
            <?php endif; ?>
        </aside>
    </div>
    <section>
        <h3>Informazioni sul prodotto</h3>
        <p><strong>Categoria: </strong><?php echo $product["categoria"]; ?></p>
        <p><strong>Generi: </strong><?php echo $product["generi"]; ?></p>
        <p><strong>Opera di appartenenza: </strong><?php echo $product["opera_di_appartenenza"]; ?></p>
        <h4>Dimensioni:</h4>
        <ul>
            <li>Altezza: <?php echo $product["altezza"]; ?> cm</li>
            <li>Larghezza: <?php echo $product["larghezza"]; ?> cm</li>
            <li>Profondità: <?php echo $product["profondita"]; ?> cm</li>
        </ul>
        <h4>Descrizione</h4>
        <p><?php echo $product["descrizione"]; ?></p>
    </section>

    <!--<hr/>-->

    <section>
        <h3>Recensioni</h3>
        <?php if(isset($templateParams["userreview"])):
                $review = $templateParams["userreview"] ?>
            <article>
                <h4>La tua recensione</h4>
                <?php require "review-article.php"; ?>
                <div>
                    <a href="../reviews/review.php?id=<?php echo $product["id"]; ?>&action=modify">Modifica</a>
                </div>
            </article>
        <?php else: ?>
            <?php if(!isset($templateParams["seller"])): ?>
            <article>
                <h4>Vuoi recensire il prodotto?</h4>
                <a href="../reviews/review.php?id=<?php echo $product["id"]; ?>&action=insert">Scrivi una recensione</a>
            </article>
            <?php endif; ?>
        <?php endif; ?>
        <article>
            <h4>Recensioni degli utenti</h4>
            <p>Numero di recensioni: <?php echo $product["num_recensioni"]; ?></p>
            <?php foreach($templateParams["reviews"] as $review): ?>
                <?php require "review-article.php"; ?>
            <?php endforeach; ?>
        </article>
    </section>
    <input type="hidden" id="articleID_input" name="articleID" value="<?php echo $product['id']; ?>" />
</article>