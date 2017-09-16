<?php

    session_start();

    include "../config/database.php";
    include "explode.php";
    try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
	    die('Error create table : ' . $e->getMessage());
		echo "connexion fail";
	}

    if (($_POST['passwd_mod'] || $_POST['passwd_mod'] === "0") && ($_POST['passwd_mod_new'] || $_POST['passwd_mod_new'] === "0") && ($_POST['passwd_mod_new2'] || $_POST['passwd_mod_new2'] === "0") && $_POST['submit_mod'] === "OK")
    {
        $res = preg_match("/^[a-zA-Z-_0-9]{6,}$/", $_POST['passwd_mod_new']);
        if ($_POST['passwd_mod_new'] == $_POST['passwd_mod_new2'] && $res == 1)
        {
            $statement = $conn->prepare("SELECT * FROM user");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			$verif = 0;
			while ($verif == 0)
			{
				$resultat = $statement->fetch();
				if ($resultat['id'] && $resultat['id'] == $_SESSION['id_user'])
				{
                    $old_pass = hash("whirlpool", $_POST['passwd_mod']);
                    $new_pass = hash("whirlpool", $_POST['passwd_mod_new']);
                    if ($old_pass == $resultat['pass'])
                    {
                        $id = $resultat['id'];
					    $statement = $conn->prepare("UPDATE `user` SET `pass` = '$new_pass' WHERE `user`.`id` = $id");
					    $statement->execute();
					    $verif = 1;
                    }
                    else
                        $verif = 2;
				}
				else if (!($resultat['id']))
					$verif = 3;
			}
            if ($verif == 1)
                $_SESSION['info_error'] = "<h2 style=\"color: GREEN; margin-top:65px;\">Mot de passe modifié</h2>";
            else if ($verif == 2)
                $_SESSION['info_error'] = "<h2 style=\"color: RED;margin-top:65px;\">Ancien Mot de passe incorrect</h2>";
            else if ($verif == 3)
                $_SESSION['info_error'] = "<h2 style=\"color: RED;margin-top:65px;\">ID utilisateur Introuvable</h2>";
        }
        else if ($_POST['passwd_mod_new'] != $_POST['passwd_mod_new2'])
            $_SESSION['info_error'] = "<h2 style=\"color: RED;margin-top:65px;\">Les nouveaux mots de passe ne correspondent pas</h2>";
        else
            $_SESSION['info_error'] = "<h2 style=\"color: RED;margin-top:65px;\">Les nouveaux mots de passe doivent faire minimum 6 caracteres avec - _ 0-9 aA-zZ<br></h2>";
    }
    else
        $_SESSION['info_error'] = "<h2 style=\"color: RED;margin-top:65px;\">Remplir correctement le Formulaire en entier</h2>";
    
    header('Location: ../page/params');

?>