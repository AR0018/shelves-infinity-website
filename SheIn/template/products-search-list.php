<div class="back-btn">
    <a href="../index.php">Indietro</a>
</div>    

<?php if(isset($category_id)): ?>
    <h2>Categoria: <?php echo $category_id; ?></h2>
<?php endif; ?>

<?php if(isset($genre_id)): ?>
    <h2>Genere: <?php echo $genre_id; ?></h2>
<?php endif; ?>

<?php if(isset($input_text) && $input_text != ""): ?>
    <h2>Chiave di ricerca: <?php echo $input_text; ?></h2>
<?php endif; ?>

<aside id="filters-inputs">
    <h3>Filtri</h3>
    <button id="open-filter-button">Apri filtri</button>
    
    <div id="filter-header">
        <h3>Filtra per:</h3>
        <button id="close-filter-button">&times;</button>
    </div>
    <form>
        <div>
            <label for="min-price-range">Prezzo minimo:</label>
            <input type="range" id="min-price-range" name="min-price" min="0" max="0" step="1" value="0" />
            <output id="min-price-output" for="min-price-range">0 €</output>
        </div>

        <div>
            <label for="max-price-range">Prezzo massimo:</label>
            <input type="range" id="max-price-range" name="max-price" min="0" max="0" value="0" step="1" />
            <output id="max-price-output" for="max-price-range">0 €</output>
        </div>

        <div>
            <label for="min-rating-range">Punteggio minimo:</label>
            <input type="range" id="min-rating-range" name="min-rating" min="0" max="4" value="0" />
            <output id="min-rating-output" for="min-rating-range" >Qualsiasi punteggio</output>
        </div>

        <div>
            <label for="availability-checkbox">Solo prodotti disponibili:</label>
            <input type="checkbox" id="availability-checkbox" name="availability" value="only-available" />
        </div>

        <?php if(!isset($category_id)): ?>
        <fieldset id="categories-filter">
            <legend>Categorie:</legend>
        </fieldset>
        <?php endif; ?>

        <fieldset id="genres-filter">
            <legend>Generi:</legend>
        </fieldset>

        <input type="button" name="apply-filters" id="apply-filters-button" value="Applica filtri" />
    </form>
</aside>

<div id="container-product-list">
    <div id="search-product-ctn">
    </div>
</div>