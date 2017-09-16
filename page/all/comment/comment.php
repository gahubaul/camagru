<?php
    session_start();

    include "../../../config/database.php";
    include "../../../php/explode.php";
    try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
	    die('Error create table : ' . $e->getMessage());
		echo "connexion fail";
	}

    function send_mail_notif($conn)
    {
        $statement = $conn->prepare("SELECT * FROM photo");
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();
        $count = FALSE;
        while(($resultat = $statement->fetch()))
        {
            if ($resultat['id'] == $_SESSION['id_image_en_cours'])
                $data = $resultat;
        }
        $statement = $conn->prepare("SELECT * FROM user");
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();
        $count = FALSE;
        while(($resultat = $statement->fetch()))
        {
            if ($data['id_user'] == $resultat['id'] && $data['id_user'] != $_SESSION['id_user'])
            {
                
                $logo = "Send by Camagru project";
				$message = $logo."\n\nYou have a new comment by ".$_SESSION['name_user']." for your photo [".$_SESSION['id_image_en_cours']."].\n";
                $message = $message."Check it !";
				mail($resultat['mail'], 'New Comment Photo '.$_SESSION['id_image_en_cours'], $message, "Camagru");
            }
        }
    }


    if (($_POST['comment'] || $_POST['comment'] === "0") && $_POST['submit'] === "OK")
    {
        $res = strlen($_POST['comment']);
        if ($res <= 1000)
        {
            send_mail_notif($conn);
            $monfichier = "save_com/".$_SESSION['id_image_en_cours'];
            $fichieropen = fopen($monfichier, 'a+');
            $res = fgets($fichieropen);
            $tab = explode("**", $res);
            $count = count($tab) - 1;
            $first_res = explode('†', $tab[$count -1]);
            $last_res = explode('∑', $first_res[1]);
            $new_id = $last_res[0] + 1;
            $veri = fwrite($fichieropen, $_SESSION['name_user']."†".$new_id."∑".$_POST['comment']."**");
            fclose($fichieropen);
            if ($veri == FALSE)
            {
                $_SESSION['verif_comment'] = FALSE;
                $_SESSION['error_info'] = "Commentaire non sauvegarde";
                header('Location: ../comment?id='.$_GET['id']);
            }
            else if ($veri == TRUE)
            {
                $_SESSION['verif_comment'] = TRUE;
                $_SESSION['error_info'] = "Commentaire ajoute";
                header('Location: ../comment?id='.$_GET['id']);
            }
        }
        else
        {
            $_SESSION['verif_comment'] = FALSE;
		    $_SESSION['error_info'] = "Commentaire limite a 1000 caracteres";
		    header('Location: ../comment?id='.$_GET['id']);
        }
    }
    else
    {
        $_SESSION['verif_comment'] = FALSE;
		$_SESSION['error_info'] = "Commentaire Nul";
		header('Location: ../comment?id='.$_GET['id']);
    }
?>
