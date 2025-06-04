<div class="back-btn">
	<a href="../index.php">Indietro</a>
</div>
<div>
	<form class="login" action="#" method="POST">
		<h2>Login</h2>
		
		<?php if(isset($templateParams["loginerror"])): ?>
			<div class="pop-up error" id="pop-up-login">     
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
				<label for="email-lg">Email:</label>
				<input id="email-lg" type="email" name="email" required autofocus/>
			</div>
			<div>
				<label for="password-lg">Password:</label>
				<input id="password-lg" type="password" name="password" required/>
			</div>
			<div class="switch">
				<label for="checkbox-lg">Mostra Password
					<input id="checkbox-lg" type="checkbox"/>
					<span class="slider"></span>
				</label>
			</div>
		</div>
		<div class="rst-sbt">
			<input type="reset" name="reset" value="Reset"/>
			<input type="submit" name="submit" value="Invia"/>
		</div>
		<div>
			<p>Non ti sei ancora registrato?</p>
			<a href=<?php echo $paths["register"] ?>>Registrati</a>
		</div>
		<?php
		$rand = rand();
		$_SESSION["login-rand"] = $rand;
		?>
		<input type="hidden" id="rand-number" name="rand" value="<?php echo $rand; ?>" />
	</form>
</div>
