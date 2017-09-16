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

    if (($_GET['id'] || $_GET['id'] != ""))
    {
        $statement = $conn->prepare("SELECT * FROM photo");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
		$verif = 0;
		while ($verif == 0)
		{
			$resultat = $statement->fetch();
			if ($resultat['id'] && $_GET['id'] == $resultat['id'])
			{
                if ($resultat['id_user'] == $_SESSION['id_user'])
				    $verif = 1;
				else
				    $verif = 2;
			}
			else if (!($resultat['id']))
				$verif = 3;
		}
        if ($verif == 1)
        {
            $id = $_GET['id'];
            $statement = $conn->prepare("DELETE FROM `photo` WHERE `photo`.`id` = $id");
            $statement->execute();
            $img = "../save_img/".$id.".png";
            $com = "../page/all/comment/save_com/".$id;
            if (file_exists($img))
                unlink($img);
            if (file_exists($com))
                unlink($com);
            header('Location: ../page/all');
        }
        else if ($verif == 2 || $verif == 3)
        {
            header('Location: ../page/all');
        }
    }
    else
        header('Location: ../page/all');
?>