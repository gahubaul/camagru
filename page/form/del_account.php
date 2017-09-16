<form class="form" action="../../php/del_user.php" method="POST" style="color: white;">
    <p id="ident">Mot de passe </p><input id="box" type="password" placeholder="Rentre ton mdp" name="passwd_del" value="<?php echo ""; ?>" />
    <p id="ident">Verification </p><input id="box2" type="password" placeholder="Verification du mdp" name="passwd_del_verif" value="<?php echo ""; ?>" />
    <p id="ident2">Valider l'action&nbsp;&nbsp;<input type="checkbox" id="case_check" name="case_verif" value="1"></p>
    <br>
    <input id="click2" type="submit" name="submit_del" value="OK" />
</form>