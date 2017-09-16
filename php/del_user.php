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

    function ft_suppr_user_all($conn)
    {
        $statement = $conn->prepare("SELECT * FROM photo");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
        $path = "";
        $verif = 0;
        while ($verif == 0)
		{
			$resultat = $statement->fetch();
            if ($resultat == FALSE)
                $verif = 2;
            else if ($resultat['id_user'] == $_SESSION['id_user'])
			{
                $img = "../save_img/".$resultat['id'].".png";
                if(file_exists($img))
                    unlink($img);
                $com = "../page/all/comment/save_com/".$resultat['id'];
                if(file_exists($com))
                    unlink($com);
                $path = $path."DELETE FROM `photo` WHERE `photo`.`id` = ".$resultat['id'].";";
            }
		}
        if ($path != "")
        {
            $statement = $conn->prepare($path);
		    $statement->execute();
        }
    }

    if (($_POST['passwd_del'] || $_POST['passwd_del'] === "0") && ($_POST['passwd_del_verif'] || $_POST['passwd_del_verif'] === "0") && ($_POST['case_verif'] == 1) && $_POST['submit_del'] === "OK")
    {
        if ($_POST['passwd_del_verif'] == $_POST['passwd_del'])
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
                    $verif_pass = hash("whirlpool", $_POST['passwd_del']);

                    if ($verif_pass == $resultat['pass'])
                    {
                        $id = $resultat['id'];
					    $statement = $conn->prepare("DELETE FROM `user` WHERE `user`.`id` = $id");
					    $statement->execute();
					    $verif = 1;
                        $path = "../page/home/no_cam/".$_SESSION['id_user'].".png";
	                    if(file_exists($path))
		                    unlink($path);
                        ft_suppr_user_all($conn);
                        $_SESSION['create_session'] = "";
                        $_SESSION['connexion'] = FALSE;
                        $_SESSION['id_user'] = "";
                        $_SESSION['name_user'] = "";
                        header('Location: ../page/connect');
                    }
                    else
                        $verif = 2;
				}
				else if (!($resultat['id']))
					$verif = 3;
			}
        }
    }
    header('Location: ../page/params');
?>