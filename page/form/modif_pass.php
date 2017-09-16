<form class="form" action="../../php/modif_pass.php" method="POST" style="color: white;">
    <p id="ident">Mot de passe </p><input id="box" type="password" placeholder="Rentre ton mdp" name="passwd_mod" value="<?php echo ""; ?>" />
     <p id="ident">Nouveau mot de passe </p><input id="box" type="password" placeholder="Choisis ton mdp" name="passwd_mod_new" value="<?php echo ""; ?>" />
    <p id="ident">Verification </p><input id="box" type="password" placeholder="Choisis ton mdp" name="passwd_mod_new2" value="<?php echo ""; ?>" />
    <br>
    <input id="click" type="submit" name="submit_mod" value="OK" />
</form>