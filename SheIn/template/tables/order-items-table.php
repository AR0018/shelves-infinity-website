<table class="order-items-table">
    <?php if(isset($caption)): ?>
    <caption><?php echo $caption; ?></caption>
    <?php endif; ?>
    <thead>
        <tr>
            <th id="id<?php if(isset($order)) echo $order["codOrdine"]; ?>">Codice</th>
            <th id="name<?php if(isset($order)) echo $order["codOrdine"]; ?>">Nome</th>
            <th id="image<?php if(isset($order)) echo $order["codOrdine"]; ?>">Immagine</th>
            <th id="price<?php if(isset($order)) echo $order["codOrdine"]; ?>">Prezzo Unitario</th>
            <th id="quantity<?php if(isset($order)) echo $order["codOrdine"]; ?>">Quantità</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($items as $item): ?>
        <tr>
            <td headers="id<?php if(isset($order)) echo $order["codOrdine"]; ?>"><?php echo $item["codProdotto"] ?></td>
            <td headers="name<?php if(isset($order)) echo $order["codOrdine"]; ?>"><?php echo $item["nome"] ?></td>
            <td headers="image<?php if(isset($order)) echo $order["codOrdine"]; ?>"><img src="<?php echo $templateParams["upload_dir"].$item["immagine"]; ?>" alt=""/></td>
            <td headers="price<?php if(isset($order)) echo $order["codOrdine"]; ?>"><?php echo $item["prezzo"] ?>€</td>
            <td headers="quantity<?php if(isset($order)) echo $order["codOrdine"]; ?>"><?php echo $item["quantita"] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>