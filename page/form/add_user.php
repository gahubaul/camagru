<form class="form" action="../../php/add_user.php" method="POST" style="color: white;">
	<p id="ident">Identifiant </p><input id="box" placeholder="Choisis un pseudo" type="text" name="login" value="<?php echo ""; ?>" />
	<p id="ident">Mot de passe </p><input id="box" type="password" placeholder="Choisis ton mdp" name="passwd" value="<?php echo ""; ?>" />
	<p id="ident1">Mot de passe vérification </p><input id="box" type="password" placeholder="Retape ton mdp" name="passwdverif" value="<?php echo ""; ?>" />
	<p id="ident2">Email </p><input id="box" placeholder="Donne ton mail !" type="text" name="mail" value="<?php echo ""; ?>" />
	<br><br><input id="click" type="submit" name="submit" value="OK" />
</form>