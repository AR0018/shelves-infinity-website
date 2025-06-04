<div class="back-btn">
	<a href="../index.php">Indietro</a>
</div>
<section id="profile">
    <h2><strong>Bentornato 
        <?php if(isset($_SESSION["USERNAME"])) echo $_SESSION["USERNAME"]; ?>
    </strong></h2>

    <div class="pop-up" id="pop-up-profile">
        <div class="pop-up-btn">
            <span id="pop-up-profile-title"></span>
            <button class="close">&times;</button>
        </div>
        <div class="pop-up-msg">
            <p id="pop-up-profile-message"></p>
        </div>
    </div>

    <div>
        <h2><strong>Impostazioni</strong></h2>
        <div id="section-container">
            <div id="sidenav-profile">
                <a id="generali-link" href="#">Generali</a>
                <a id="modifica-link" href="#">Modifica</a>
                <?php if($dbh->isSeller($user_id)): ?>
                    <a href="../products/product-configuration.php">Gestisci prodotti</a>
                <?php else: ?>
                    <a href="../favourite/favourite.php">Preferiti</a>
                <?php endif; ?>
                <a href="../orders/orders.php">Ordini</a>
            </div>
                        
            <div id="profile-sct">
                <section class="sct-profile" id="general-info">
                    <h3>Informazioni generali</h3>
                    <form>
                        <label for="usr">Username:</label>
                        <input id="usr" name="usr" type="text" disabled value="<?php echo $username; ?>"/>

                        <label for="email">Email:</label>
                        <input id="email" name="email" type="email" disabled value="<?php echo $email; ?>"/>

                        <label for="psw">Password:</label>
                        <input id="psw" name="psw" type="password" disabled value="<?php for($i=0; $i<$_SESSION["psw_length"]; $i++) { echo "*"; }; ?>"/>
                    </form>
                </section>
                <section class="sct-profile" id="modify-username">
                    <h3>Modifica Username</h3>
                    <form id="modify-username-form" class="usr_chg">
                        <div>
                            <label for="new_usr">Nuovo Username:</label>
                            <input id="new_usr" name="new_usr" type="text" placeholder="Inserire username" required/>
                        </div>

                        <div class="rst-sbt">
                            <input id="modify-username-submit" name="submit" type="submit" value="Invia"></input>
                            <input name="reset" type="reset" value="Reimposta"></input>
                        </div>
                    </form>
                </section>
                <section class="sct-profile" id="modify-password">
                    <h3>Modifica password</h3>
                    <form id="modify-password-form" class="psw_chg">
                        <div>
                            <label for="old_psw">Vecchia password:</label>
                            <input id="old_psw" name="old_psw" type="password" placeholder="Inserire password" required/>

                            <label for="new_psw">Nuova password:</label>
                            <input id="new_psw" name="new_psw" type="password" placeholder="Inserire password" required/>

                            <label for="confirm-psw">Conferma password:</label>
                            <input id="confirm-psw" name="confirm-psw" type="password" placeholder="Confermare password" required/>
                        </div>
                        
                        <div class="rst-sbt">
                            <input id="modify-password-submit" name="submit" type="submit" value="Invia"></input>
                            <input name="reset" type="reset" value="Reimposta"></input>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
