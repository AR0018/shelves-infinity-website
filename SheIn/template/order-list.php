<div class="back-btn">
    <a href="../profile/profile-settings.php">Indietro</a>
</div>
<section id="list-order">
    <header>
        <?php if($templateParams["is_seller"]): ?>
            <h2>Ordini ricevuti</h2>  
        <?php else: ?>
            <h2>Ordini effettuati</h2>
        <?php endif; ?>
    </header>
    <?php if(count($templateParams["orders"]) == 0): ?>
        <p>Nessun ordine effettuato</p>
    <?php else:
        foreach ($templateParams["orders"] as $order):
            $items = $templateParams["order_items"][$order["codOrdine"]];
            if($templateParams["is_seller"]) {
                $footer = true;
                switch ($order["stato_spedizione"]) {
                    case 'Confermato':
                        $action = "send";
                        $button_msg = "Spedisci";
                        break;
                    case 'Spedito':
                        $action = "deliver";
                        $button_msg = "Conferma consegna";
                        break;
                    default:
                        $footer = false;
                        break;
                }
            }
        ?>
        <article>
            <header>
                <h3>Ordine #<?php echo $order["codOrdine"]; ?></h3>
                <ul>
                    <li><strong>Data: </strong><?php echo $order["data"]; ?></li>
                    <li><strong>Prezzo totale: </strong><?php echo $order["prezzo_totale"]; ?>€</li>
                    <li id="order_status<?php echo $order["codOrdine"]; ?>"><strong>Stato: </strong><?php echo $order["stato_spedizione"];?></li>
                </ul>
            </header>
            <div class="container-table">
                <?php require "tables/order-items-table.php"; ?>
            </div>
            <?php if(isset($action) && isset($button_msg) && $footer): ?>
                <button class="order_button" id="order_button<?php echo $order["codOrdine"]; ?>"><?php echo $button_msg; ?></button>
                <input type="hidden" id="action<?php echo $order["codOrdine"]; ?>" name="action" value="<?php echo $action;?>" />
            <?php endif; ?>
        </article>
    <?php endforeach; endif; ?>
</section>