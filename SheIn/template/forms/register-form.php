<div class="back-btn">
    <a href="../index.php">Indietro</a>
</div>
<form class="register" action="#" method="POST">
    <h2>Register</h2>

    <?php if(isset($templateParams["loginerror"])): ?>
        <div class="pop-up error" id="pop-up-register">     
            <div class="pop-up-btn">
                <span>Errore login</span>
                <button class="close">&times;</button>
            </div>
            <div class="pop-up-msg">
                <strong><?php echo $templateParams["loginerror"]; ?></strong>         
            </div>
        </div>
    <?php endif; ?>

    <div class="inputs-forms">
        <div>
            <label for="email-rg">Inserisci email:</label>
            <input id="email-rg" type="email" name="email" required autofocus/>
        </div>
        <div>
            <label for="username-rg">Inserisci username:</label>
            <input id="username-rg" type="text" name="username" required maxlength="50"/>
        </div>
        <div>
            <label for="psw1-rg">Inserisci password:</label>
            <input id="psw1-rg" type="password" name="password1" required/>
        </div>
        <div>
            <label for="psw2-rg">Reinserisci password:</label>
            <input id="psw2-rg" type="password" name="password2" required/>
        </div>
    </div>
    <div class="rst-sbt">
        <input type="reset" name="reset" value="Reimposta"/>
        <input type="submit" name="submit" value="Invia"/>
    </div>

    <div>
	    <p>Ti sei già iscritto?</p>
	    <a href=<?php echo $paths["login"] ?>>Accedi</a>
    </div>
    <?php
    $rand = rand();
    $_SESSION["register-rand"] = $rand;
    ?>
    <input type="hidden" id="rand-number" name="rand" value="<?php echo $rand; ?>" />
</form>
