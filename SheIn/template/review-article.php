<div class="review">
    <div class="star-container">
        <?php 
        echo '<p><strong>'.$review["username"].'</strong> - '.$review["punteggio"].'</p>';
        for($i = 0; $i < 5; $i++) {
            if ($i < $review["punteggio"]) {
                echo '<span class="fa fa-star checked"></span>';
            } else {
                echo '<span class="fa fa-star"></span>';
            }
        }
        ?>
    </div>
    <p><?php echo $review["descrizione"]; ?></p>
    <p>Recensito in data: <?php echo $review["data"]; ?></p>
</div>
