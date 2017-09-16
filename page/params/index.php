<?php
	session_start();

	$path = "../home/no_cam/".$_SESSION['id_user'].".png";
	if(file_exists($path))
		unlink($path);
	if ($_SESSION['connexion'] != TRUE || $_SESSION['name_user'] == "")
		header('Location: ../connect');
?>
<html>
	<head>
		<title>Camagru - PARAMS</title>
		<link href="https://fonts.googleapis.com/css?family=Bungee+Shade|Cabin|Kavoon|Cutive|Lora|Anton|Acme|PT+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bungee|Inconsolata|Hind|Rubik:900" rel="stylesheet">
		<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="params.css">
	</head>
	<body>
		<?php include '../header/header.html'; ?>
		<div><?php echo $_SESSION['info_error']; $_SESSION['info_error'] = "";?></div>
		<div class="div_params1">
			<div class="div_mod">
				<h3>Modification mot de passe</h3>
				<?php include '../form/modif_pass.php'; ?>
			</div>
			<div class="div_del">
				<h3 style="margin: 22px;">Suppression du compte</h3>
				<?php include '../form/del_account.php'; ?>
			</div>
		</div>
		<div style="width: 100vw; height: 30px; background-color: #1a1e21; color: whitesmoke; display: block; position: fixed; bottom: 0px; padding-top: 13px;"> CAMAGRU © GAHUBAUL</div>
 	</body>
</html>