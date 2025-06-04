<div  class="back-btn">
    <a href="../profile/profile-settings.php">Indietro</a>
</div>
<section id="favourite">
    <h2>Sezione Preferiti</h2>

    <div class="pop-up good" id="pop-up-favourite">     
        <div class="pop-up-btn">
            <span>Notifica</span>
            <button class="close">&times;</button>
        </div>
        <div class="pop-up-msg">
            <p></p>
        </div>
    </div>

    <?php if(count($templateParams["favourites"]) == 0): ?>
        <article>
            <p>Nessun prodotto nei preferiti.</p>
        </article>
    <?php else: ?>
        <div id="container-favourite">
            <?php foreach($templateParams["favourites"] as $favourite): ?>
                <div class="favourite-article" id="article<?php echo $favourite["codProdotto"]; ?>">
                    <div><img src="<?php echo $templateParams["upload_dir"].$dbh->getProductByID($favourite["codProdotto"])[0]["immagine"]; ?>" alt=""/></div>
                    <div class="info-fav-article">
                        <div class="info-title">
                            <h3><a href="../products/product.php?id=<?php echo $favourite["codProdotto"]; ?>"><?php echo $dbh->getProductByID($favourite["codProdotto"])[0]["nome"]; ?></a></h3>
                            <p><?php echo $dbh->getProductByID($favourite["codProdotto"])[0]["prezzo"]; ?> &euro;</p>
                        </div>
                        <p><?php echo $dbh->getProductByID($favourite["codProdotto"])[0]["descrizione"]; ?></p>
                    </div>
                    <button type="button" id="remove<?php echo $favourite["codProdotto"]; ?>">Rimuovi</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>