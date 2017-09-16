<?php
	session_start();

	if ($_SESSION['connexion'] === TRUE)
		header('Location: ../home');
	$display = "display: none;";
	if ($_SESSION['create_session'] === TRUE)
		$color = "background-color: green;";
	else if ($_SESSION['create_session'] === FALSE)
		$color = "background-color: red;";
?>
<html>
	<head>
		<title>Camagru - CONNECT</title>
		<link href="https://fonts.googleapis.com/css?family=Bungee|Inconsolata|Hind|Rubik:900" rel="stylesheet">
		<link rel="stylesheet" href="connect1.css">
	</head>
	<body>
		<div id="body">
			<div class="header">
				<a href="../connect" id="title">CAMAGRU</a>
			</div>
			<div class="alert" style="<?php if ($_SESSION['create_session'] == TRUE || $_SESSION['create_session'] == FALSE) echo $color; else echo $display;?>">
				<?php
					echo $_SESSION['error_info'];
					$_SESSION['create_session'] = "coucou";
					$_SESSION['error_info'] = "";
				?>
			</div>
			<div class="bigdiv">
				<div class="cube1">
					<h2 style="text-shadow: 5px 5px 10px black; font-size: 30px;margin-bottom: 40px;margin-top: 5px;">Creation de Compte</h2>
					<?php include('../form/add_user.php'); ?>
					<br>
				</div>
				<div class="cube2">
					<h2 style="text-shadow: 5px 5px 10px black; font-size: 30px;margin-bottom: 40px;margin-top: 5px;">Connexion au compte</h2>
					<?php include('../form/signin.php'); ?>
				</div>
				<div class="cube3">
					<h2 style="text-shadow: 5px 5px 10px black; font-size: 30px;margin-bottom: 40px;margin-top: 5px;">Mot de passe perdu</h2>
					<?php include('../form/new_pass.php'); ?>
				</div>
			</div>
			<div style="width: 100vw; height: 30px; background-color: #1a1e21; color: whitesmoke; display: block; position: fixed; bottom: 0px; padding-top: 13px;"> CAMAGRU © GAHUBAUL</div>
		</div>
	</body>
</html>