<?php
	session_start();


	$path = "../home/no_cam/".$_SESSION['id_user'].".png";
	if(file_exists($path))
		unlink($path);

	if ($_SESSION['connexion'] != TRUE || $_SESSION['name_user'] == "")
		header('Location: ../connect');
	$display = "display: none;";
	if ($_SESSION['connexion'] === TRUE)
		$color = "background-color: green;";
	else if ($_SESSION['connexion'] === FALSE)
		$color = "background-color: red;";
	$_SESSION['error_info']= "";
	include "../../config/database.php";
    include "../../php/explode.php";
    try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
	    die('Error create table : ' . $e->getMessage());
		echo "connexion fail";
	}

	function like($id, $conn)
	{
		$statement = $conn->prepare("SELECT * FROM photo");
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$statement->execute();
		$verif = 0;
		$count = FALSE;
		while(($resultat = $statement->fetch()) && $count == FALSE)
		{
			if ($id == $resultat['id'])
			{
				$id_user = $_SESSION['id_user'];
				$tab = explode("|", $resultat['love']);
				$love = 0;
				$verif = 0;
				foreach ($tab as $key => $elem)
				{
					if ($elem == $id_user)
						$verif = 1;
				}
				if ($verif == 0)
					$color = 'green';
				else if ($verif == 1)
					$color = 'red';
				return ($color);
			}
		}
	}



?>
<html>
	<head>
		<title>Camagru - ALL</title>
		<link href="https://fonts.googleapis.com/css?family=Bungee+Shade|Cabin|Kavoon|Cutive|Lora|Anton|Acme|PT+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bungee|Inconsolata|Hind|Rubik:900" rel="stylesheet">
		<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="all7.css">
	</head>
	<body>
		<?php include '../header/header.html'; ?>
		<?php 	echo "<div style=\"margin-top:65px;\" ><a id=\"change_photo\" href=\"../../php/me_all.php\">";
				if ($_SESSION['choice_photo'] == "all")
					echo "Photos Personnelles";
				else if ($_SESSION['choice_photo'] == "me")
					echo "Voir toutes Photos";
				echo "</a></div>";?>
		<br>
			<?php
				$statement = $conn->prepare("SELECT * FROM photo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
				$verif = 0;
				$resultat = $statement->fetchAll();
				
				$i = 0;
				while ($resultat[$i])
				{
					$i++;
				}
				$i--;
				while($i >= 0)
				{
					if (($_SESSION['id_user'] == $resultat[$i]['id_user'] && $_SESSION['choice_photo'] == "me") || $_SESSION['choice_photo'] == "all")
					{
						echo "<div class=\"photo\">";
						echo "<b style=\"position: relative;color: white;top: 12px;left: 16px;\">".$resultat[$i]['id']."</b>";
						if ($resultat[$i]['id_user'] == $_SESSION['id_user'])
							echo "<a href=\"../../php/delete_img.php?id=".$resultat[$i]['id']."\"><i id=\"delete_img\" class=\"fa fa-times\" aria-hidden=\"true\"></i></a>";
						echo "<a href=\"comment?id=".$resultat[$i]['id']."\">
						<img id=\"save_photo_img\" style=\"width:270px; height:202px;\" src=\"".'../../save_img/'.$resultat[$i]['id'].".png \"alt=\"\">
						</a>";
						$id = $resultat[$i]['id'];
						$color = like($id, $conn);
						$_SESSION['id_image_en_cours'] = $resultat[$i]['id'];
						if ($color == "red")
							$mot = "Dislike";
						else if ($color == "green")
							$mot = "Like";	
						echo "
							<form id=\"form_post\" method=\"POST\" action=\"../../php/love.php\">
								<input id=\"click\" style=\"background-color:".$color.";\" type=\"submit\" name=\"submit_love\" value=\"".$resultat[$i]['id']."\" />
							</form>";
						echo "<p id=\"like_dislike\">".$mot."</p>";
						if (file_exists("comment/save_com/".$resultat[$i]['id']))
						{
							$open = fopen("comment/save_com/".$resultat[$i]['id'], "r");
							if ($open != FALSE)
								$gets = fgets($open);
							if ($gets != "")
							{
								echo "<i id=\"messenger_icon\" class=\"fa fa-comments\" aria-hidden=\"true\"></i>";
								echo "<p style=\"position:relative; left:-13px;\" id=\"like_info\">".$resultat[$i]['nb_love']."</p>";
							}
							else
								echo "<p id=\"like_info\">".$resultat[$i]['nb_love']."</p>";
						}
						else
							echo "<p id=\"like_info\">".$resultat[$i]['nb_love']."</p>";
						echo "</div>";
					}
					$i--;
				}
			?>
 		<script type="text/javascript" src="home.js"></script>
		 <div style="height:150px;"></div>
		 <div style="width: 100vw; height: 30px; background-color: #1a1e21; color: whitesmoke; display: block; position: fixed; bottom: 0px; padding-top: 13px;"> CAMAGRU © GAHUBAUL</div>
 	</body>
</html>
