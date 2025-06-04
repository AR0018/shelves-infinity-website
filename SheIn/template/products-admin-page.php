<div class="back-btn">
    <a href="../profile/profile-settings.php">Indietro</a>
</div>

<section id="admin-products-page">
    <h2>Gestisci i tuoi prodotti</h2>

    <?php if(isset($templateParams["msg"])):
        $popup_class = "";
        if(isset($templateParams["success"])) {
            if($templateParams["success"]) {
                $popup_class = "good";
            } else {
                $popup_class = "error";
            }
        }
        ?>
        <div class="pop-up <?php echo $popup_class ?>" id="pop-up-admin">
            <div class="pop-up-btn">
                <span>Notifica operazione</span>
                <button class="close">&times;</button>
            </div>
            <div class="pop-up-msg">
                <p><?php echo $templateParams["msg"]; ?></p>
            </div>
        </div>
    <?php endif; ?>

    <section id="add-products">
        <h3>Aggiunta nuovi prodotti</h3>
        <a href="product-operation.php?action=add">Aggiungi prodotto</a>
    </section>
    <section id="db-products">
        <h3>Prodotti esistenti</h3>
        <div id="container-admin-products">
        <?php foreach($templateParams["products"] as $product):?>
            <article>
                <h4><?php echo $product["nome"]; ?></h4>
                <ul>
                    <li><p><strong>Codice prodotto: </strong><?php echo $product["codProdotto"]; ?></p></li>
                    <li><p><strong>Prezzo: </strong><?php echo $product["prezzo"]; ?>€</p></li>
                    <li><p><strong>Quantità disponibile: </strong><?php echo $product["quantita_disponibile"]; ?></p></li>
                </ul>
                <div>
                    <img src="<?php echo $templateParams["upload_dir"].$product["immagine"]; ?>" alt="" />
                </div>
                <a class="mdfy-product" href="product-operation.php?id=<?php echo $product["codProdotto"]; ?>&action=modify">Modifica prodotto</a>
                <a class="rm-product" href="product-operation.php?id=<?php echo $product["codProdotto"]; ?>&action=remove">Rimuovi dagli scaffali</a>
            </article>
        <?php endforeach; ?>
        </div>
    </section>
</section>
