<?php
    session_start();
    $path = "../page/home/no_cam/".$_SESSION['id_user'].".png";
	if(file_exists($path))
		unlink($path);
    $_SESSION['create_session'] = "";
    $_SESSION['connexion'] = FALSE;
    $_SESSION['id_user'] = "";
    $_SESSION['name_user'] = "";
    header('Location: ../page/connect');
?>