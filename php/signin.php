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

    if (($_POST['login_co'] || $_POST['login_co'] === "0") && ($_POST['passwd_co'] || $_POST['passwd_co'] === "0") && $_POST['submit_co'] === "OK")
	{
		$res = preg_match("/^[a-zA-Z-_0-9]{6,}$/", $_POST['login_co']);
		$res1 = preg_match("/^[a-zA-Z-_0-9]{6,}$/", $_POST['passwd_co']);
		if ($res == 1 && $res1 == 1)
		{
			$statement = $conn->prepare("SELECT * FROM user");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			$verif = 0;
			$pass = hash("whirlpool", $_POST['passwd_co']);
			while($resultat = $statement->fetch())
			{
				if ($_POST['login_co'] == $resultat['login'] && $pass == $resultat['pass'])
				{
					$verif = 1;
					$_SESSION['create_session'] = TRUE;
					$_SESSION['connexion'] = TRUE;
					$_SESSION['id_user'] = $resultat['id'];
					$_SESSION['name_user'] = $resultat['login'];
					$_SESSION['error_info'] = "bienvenue";
					$_SESSION['choice_photo'] = "all";
					header('Location: ../page/home');
				}
			}
			if ($verif != 1)
			{
				$_SESSION['create_session'] = FALSE;
				$_SESSION['error_info'] = "erreur dans le login ou le mot de passe";
				header('Location: ../page/connect');
			}
		}
		else
		{
			if ($res != 1 || $res1 != 1)
				$_SESSION['error_info'] = "Le mot de passe doit contenir au moins 6 caracteres et ne peut etre formé que de lettres, chiffres et \"- _\"";
			header('Location: ../page/connect');
		}
	}
	else
	{
		$_SESSION['create_session'] = FALSE;
		$_SESSION['error_info'] = "Informations Manquantes pour la connexion";
		header('Location: ../page/connect');
	}
?>