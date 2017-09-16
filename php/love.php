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

    if ($_POST['submit_love'] != NULL)
	{
		$statement = $conn->prepare("SELECT * FROM photo");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
		$verif = 0;
		$count = FALSE;
		while(($resultat = $statement->fetch()) && $count == FALSE)
		{
			if ($_POST['submit_love'] == $resultat['id'])
			{
				$id_user = $_SESSION['id_user'];
				$id = $_POST['submit_love'];
				$tab = explode("|", $resultat['love']);
				$love = 0;
				$verif = 0;
				foreach ($tab as $key => $elem)
				{
					$love++;
					if ($elem == $id_user)
						$verif = 1;
				}
				if ($verif == 0)
					$res = $resultat['love'].$id_user."|";
				else if ($verif == 1)
				{
					$love -= 2;
					$pattern = $id_user."|";
					$tab = explode($pattern, $resultat['love']);
					$res = $tab[0].$tab[1];
				}
				try{
					$statement = $conn->prepare("UPDATE `photo` SET `love` = '$res', `nb_love` = '$love' WHERE `photo`.`id` = $id");
					$statement->execute();
				}catch (PDOException $e)
				{
					die('Error create table : ' . $e->getMessage());
					echo "connexion fail";
				}
				header('Location: ../page/all');
			}
		}
	}
	else
	{
		header('Location: ../page/all');
	}

?>