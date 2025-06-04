<div class="back-btn">
    <a href="../index.php">Indietro</a>
</div>

<section id="container-cart">
    <h2>Carrello</h2>
    <?php if(count($templateParams["shopping_products"]) == 0): ?>
        <article>
            <p>Nessun prodotto nel carrello.</p>
        </article>
    <?php else: ?>
        <div id="cart-article">
        <?php foreach($templateParams["shopping_products"] as $product): ?>
            <article id="article<?php echo $product["codProdotto"]; ?>">
                <header>
                    <h3><a href="../products/product.php?id=<?php echo $product["codProdotto"]; ?>"><?php echo $product["nome"]; ?></a></h3>
                </header>
                <div><img src="<?php echo $templateParams["upload_dir"].$product["immagine"]; ?>" alt=""/></div>

                <div class="cart-article-info">
                    <label for="quantity<?php echo $product["codProdotto"]; ?>">Quantità: </label>
                    <input id="quantity<?php echo $product["codProdotto"]; ?>" 
                        type="number" name="number" min="1" value="<?php echo $product["quantita"];?>" />               
                    <p>Quantità disponibile nello store: <strong><?php echo $product["quantita_disponibile"]; ?></strong></p>
                    <p>Costo per unità: <strong><?php echo $product["prezzo"]; ?>€</strong></p>
                </div>
                <button type="button" id="remove<?php echo $product["codProdotto"]; ?>">Rimuovi</button>
            </article>
        <?php endforeach; ?>
        </div>
        <aside>
            <form action="../orders/order-recap.php" method="GET">
                <p id="total_price"></p>
                <input id="purchase_button" type="submit" name="submit" value="Procedi all'acquisto" />
            </form>
        </aside>
    <?php endif; ?>
</section>