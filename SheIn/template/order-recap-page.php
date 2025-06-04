<div class="back-btn">
    <a href="../shopping-cart/shopping-cart.php">Indietro</a>
</div>

<?php
if(isset($templateParams["order_items"])) {
    $send_data = htmlspecialchars(serialize($templateParams["order_items"]));
    $items = $templateParams["order_items"];
    $caption = "Prodotti nell'ordine:";
}
?>
<div id="container-order-recap">
    <header>
        <h2>Riepilogo ordine</h2>
    </header>
    <div class="container-table">
        <?php require "tables/order-items-table.php"; ?>
    </div>
    <?php if(isset($templateParams["info_msg"])): ?>
        <p><?php echo $templateParams["info_msg"]; ?></p>
    <?php endif; ?>
    <aside>
        <p>Prezzo totale: <strong><?php echo $templateParams["total_price"] ?>€</strong></p>
        <form action="handle-order.php" method="POST">
            <fieldset>
                <legend>Informazioni sulla spedizione:</legend>
                <label for="address">Indirizzo di spedizione:</label>
                <input type="text" id="address" name="address" required />
            </fieldset>
            <input type="submit" name="submit" value="Conferma Acquisto" />
            <input type="hidden" name="items" value="<?php echo $send_data; ?>" />
            <input type="hidden" name="price" value="<?php echo $templateParams["total_price"]; ?>" />
        </form>
    </aside>
</div>