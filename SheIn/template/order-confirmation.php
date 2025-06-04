<div id="order-confirm">
    <header>
        <h2><?php echo $templateParams["title_msg"]; ?></h2>
    </header>
    <div>
        <p><?php echo $templateParams["msg"]; ?></p>
        <p><?php if(isset($templateParams["id"])): ?>
            <?php echo "ID dell'ordine: ".$templateParams["id"]; ?>
        <?php endif; ?></p>
    </div>
    <div>
        <a href="orders.php">I tuoi ordini</a>
    </div>
</div>