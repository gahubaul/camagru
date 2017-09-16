<?php
	session_start();
	$_SESSION['create_session'] = "";
	$_SESSION['id_connexion'] = "";
	$_SESSION['connexion'] = FALSE;
	$_SESSION['choice_photo'] = "all";
	header("Location: page/home");
?>