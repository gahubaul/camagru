<?php
    session_start();

    if (($_GET['id_com'] || $_GET['id_com'] !== ""))
    {
        $monfichier = "save_com/".$_SESSION['id_image_en_cours'];
        $fichieropen = fopen($monfichier, 'a+');
        
        $res = fgets($fichieropen);
        $tab = explode("**", $res);
        
        
        foreach($tab as $key => $elem)
        {
            $tab1 = explode('†', $elem);
            $name_user = $tab1[0];
            $tab2 = explode('∑', $tab1[1]);
            $verif = 0;
            if ($tab2[0] == $_GET['id_com'] && $name_user == $_SESSION['name_user'] && $verif == 0)
            {
                unset($tab[$key]);
                $verif = 1;
                $_SESSION['error_info'] = "Suppression du commentaire reussie";
            }
            else if ($tab2[0] == $_GET['id_com'] && $name_user != $_SESSION['name_user'] && $verif == 0)
            {
                $_SESSION['verif_comment'] = FALSE;
                $verif = 1;
		        $_SESSION['error_info'] = $tab1[0]."---".$_SESSION['name_user']."Suppression Interdite, pas ton commentaire";
		        header('Location: ../comment?id='.$_SESSION['id_image_en_cours']);
            }
            if ($tab[$key] == "")
                unset($tab[$key]);
        }
        
        foreach($tab as $key => $elem)
        {
           $line = $line.$elem."**";
        }
        fclose($fichieropen);
        $fichieropen = fopen($monfichier, 'w+');
        $veri = fwrite($fichieropen, $line);
        fclose($fichieropen);
        header('Location: ../comment?id='.$_SESSION['id_image_en_cours']);
    }
    else
    {
        $_SESSION['verif_comment'] = FALSE;
		$_SESSION['error_info'] = "Suppression Interdite";
		header('Location: ../comment?id='.$_SESSION['id_image_en_cours']);
    }
?>