<?php
	session_start();

	function chaine_aleatoire($nb_car)
	{
		$chaine = 'azertyuiopqsdfghjklmwxcvbn0123456789';
    	$nb_lettres = strlen($chaine) - 1;
    	$generation = '';
		$i = 0;
		while ($i < $nb_car)
		{
        	$pos = mt_rand(0, $nb_lettres);
        	$car = $chaine[$pos];
        	$generation .= $car;
			$i++;
    	}
    	return $generation;
	}

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

    if (($_POST['mail_verif'] || $_POST['mail_verif'] === "0") && $_POST['submit_res'] === "OK")
	{
		$res = preg_match("/^[\w.-]+@[\w.-]+\.[a-z]{2,6}$/", $_POST['mail_verif']);
		if ($res == 1)
		{
			$statement = $conn->prepare("SELECT * FROM user");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			$verif = 0;
			while ($verif == 0)
			{
				$resultat = $statement->fetch();
				if ($resultat['id'] && $_POST['mail_verif'] == $resultat['mail'])
				{
					$_SESSION['mail_modif'] = $_POST['mail_verif'];
					$new_pass = chaine_aleatoire(8);
					$logo = "Send by Camagru project";
					$message = $logo."\nNew password.\nDon't forget it please\nNew pass: ".$new_pass."\n\n\n Project created by GAHUBAUL CORP";
					mail($resultat['mail'], 'Modification Mot de passe test', $message, "Camagru");
					$pass = hash("whirlpool", $new_pass);
					$id = $resultat['id'];
					$statement = $conn->prepare("UPDATE `user` SET `pass` = '$pass' WHERE `user`.`id` = $id");
					$statement->execute();
					$verif++;
				}
				else if (!($resultat['id']))
					$verif = 2;
			}
			if ($verif == 2)
			{
				$_SESSION['create_session'] = FALSE;
				$_SESSION['modification_pass'] = FALSE;
				$_SESSION['mod_pass'] = FALSE;
				$_SESSION['error_info'] = "mail inexistant";
				header('Location: ../page/connect');
			}
			else
			{
				$_SESSION['create_session'] = TRUE;
				$_SESSION['modification_pass'] = TRUE;
				$_SESSION['mod_pass'] = TRUE;
				$_SESSION['error_info'] = "mot de passe modifié et envoyé par mail <br>".$_SESSION['mail_modif'];
				header('Location: ../page/connect');
			}
		}
		else
		{
			$_SESSION['create_session'] = FALSE;
			$_SESSION['modification_pass'] = FALSE;
			$_SESSION['mod_pass'] = FALSE;
			$_SESSION['error_info'] = "mail invalide";
			header('Location: ../page/connect');
		}
	}
	else
	{
		$_SESSION['create_session'] = FALSE;
		$_SESSION['modification_pass'] = FALSE;
		$_SESSION['mod_pass'] = FALSE;
		$_SESSION['error_info'] = "la case mail est vide";
		header('Location: ../page/connect');
	}
?>