<?php for($i=0; $i < count($templateParams["sections"]); $i++): $section=$templateParams["sections"][$i]?>
    <section class="home-section">
        <header>
            <h2><?php echo $section->getTitle(); ?></h2>
        </header>
        <?php if(count($section->getData()) != 0): ?>
        <div class="sections">
            <a class="prev" onclick="showSlides(-1, <?php echo $i; ?>)"><div class="left-arrow"></div></a>
            <div class="container-slides<?php echo $i; ?>">
                <ul>
                    <?php foreach($section->getData() as $product): ?>
                    <li>
                        <div class="slides<?php echo $i; ?>">
                            <a href="products/product.php?id=<?php echo $product["id"]; ?>">
                                <img src="<?php echo UPLOAD_DIR.$product["immagine"]; ?>" alt="Visualizza dettagli di <?php echo $product["nome"]; ?>"/>
                                <h3><?php echo $product["nome"];?></h3>        
                            </a>
                            <div>
                                <p>Categoria: <span><?php echo $product["categoria"]; ?></span></p>
                                <span><?php echo $product["prezzo"]; ?>€</span>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a class="next" onclick="showSlides(1, <?php echo $i; ?>)"><div class="right-arrow"></div></a>
        </div>
        <?php else: ?>
        <p>Spiacenti, nessun prodotto disponibile.</p>
        <?php endif; ?>
    </section>  
<?php endfor; ?>