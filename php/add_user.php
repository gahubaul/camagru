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
    if (($_POST['login'] || $_POST['login'] === "0") && ($_POST['passwd'] || $_POST['passwd'] === "0") && ($_POST['passwdverif'] || $_POST['passwdverif'] === "0") && ($_POST['mail'] || $_POST['mail'] === "0") && $_POST['submit'] === "OK")
	{
		$res = preg_match("/^[a-zA-Z-_0-9]{6,}$/", $_POST['login']);
		$res1 = preg_match("/^[a-zA-Z0-9]{6,}$/", $_POST['passwd']);
		$res2 = preg_match("/^[a-zA-Z0-9]{6,}$/", $_POST['passwdverif']);
		$res3 = preg_match("/^[\w.-]+@[\w.-]+\.[a-z]{2,6}$/", $_POST['mail']);
		$res4 = preg_match("/[a-z]/", $_POST['passwd']);
		$res5 = preg_match("/[A-Z]/", $_POST['passwd']);
		$res6 = preg_match("/[0-9]/", $_POST['passwd']);
		if ($res == 1 && $res1 == 1 && $res2 == 1 && $res3 == 1 && $res4 == 1 && $res5 == 1 && $res6 == 1 && $_POST['passwd'] == $_POST['passwdverif'])
		{
			$statement = $conn->prepare("SELECT * FROM user");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			$verif = 0;
			while($resultat = $statement->fetch())
			{
				if ($_POST['login'] == $resultat['login'] || $_POST['mail'] == $resultat['mail'])
					$verif = 1;
			}
			if ($verif != 0)
			{
				$_SESSION['create_session'] = FALSE;
				$_SESSION['error_info'] = "login ou mail deja existant";
				header('Location: ../page/connect');
			}
			else
			{
				$pass = hash("whirlpool", $_POST['passwd']);
				$statement = $conn->prepare("INSERT INTO `user` (id, login, pass, pass_mod, mail, img, rules) VALUES (?,?,?,?,?,?,?)");
				$statement->execute(array (NULL, $_POST['login'], $pass, 0, $_POST['mail'], '123', 0));
				$logo = "Send by Camagru project";
				$message = $logo."\nCongratulation.\nAccount created with the login: ".$_POST['login']."\n\n\n Project created by GAHUBAUL CORP";
				mail($_POST['mail'], 'Creation de Compte', $message, "Camagru");
				$_SESSION['create_session'] = TRUE;
				$_SESSION['modification_pass'] = FALSE;
				$_SESSION['mail_modif'] = $_POST['mail'];
				$_SESSION['error_info'] = "login cree";
				header('Location: ../page/home');
			}
		}
		else if ($_POST['passwd'] != $_POST['passwdverif'] || $res != 1 || $res1 != 1 || $res2 != 1 || $res3 != 1 || $res4 != 1 || $res5 != 1 || $res6 != 1)
		{
			$_SESSION['create_session'] = FALSE;
			if ($_POST['passwd'] != $_POST['passwdverif'])
				$_SESSION['error_info'] = "les mots de passe ne sont pas identiques";
			if ($res != 1)
				$_SESSION['error_info'] = "Le login doit contenir au moins 6 caracteres et ne peut etre formé que de lettres, chiffres et \"- _\"";
			if ($res1 != 1 || $res2 != 1 || $res4 != 1 || $res5 != 1 || $res6 != 1)
				$_SESSION['error_info'] = "Le mot de passe doit contenir au moins 6 caracteres et ne peut etre formé que de lettres (majuscule et minuscule) et chiffres";
			if ($res3 != 1)
				$_SESSION['error_info'] = "adresse mail non valide";
			header('Location: ../page/connect');
		}
		else
		{
			$_SESSION['create_session'] = FALSE;
			header('Location: ../page/connect');
		}
	}
	else
	{
		$_SESSION['create_session'] = FALSE;
		$_SESSION['error_info'] = "Informations Manquantes";
		header('Location: ../page/connect');
	}
		$res2 = preg_match("/^[a-zA-Z-_0-9]{6,}$/", $_POST['passwdverif']);
?>