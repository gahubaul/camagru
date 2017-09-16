<?php
	session_start();

	$path = "../../home/no_cam/".$_SESSION['id_user'].".png";
	if(file_exists($path))
		unlink($path);

	if ($_SESSION['connexion'] != TRUE || $_SESSION['name_user'] == "")
		header('Location: ../../connect');
	$display = "display: none;";
	if ($_SESSION['connexion'] === TRUE)
		$color = "background-color: green;";
	else if ($_SESSION['connexion'] === FALSE)
		$color = "background-color: red;";

	include "../../../php/info_server.php";
	try {
		$conn = new PDO("mysql:host=$host;dbname=$name_db;port=$port", $root, $root_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
	    die('Error create table : ' . $e->getMessage());
		echo "connexion fail";
	}

	function base64_to_jpeg($base64_string, $output_file)
	{
    	
		$fichier = fopen($output_file, 'wb'); 

    	fwrite($fichier, base64_decode($base64_string));

    	fclose($fichier); 

    	return $output_file; 
	}

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
				$_SESSION['line_img'] = $resultat;
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
		<title>Camagru - COMMENT</title>
		<link href="https://fonts.googleapis.com/css?family=Bungee+Shade|Cabin|Kavoon|Cutive|Lora|Anton|Acme|PT+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bungee|Inconsolata|Hind|Rubik:900" rel="stylesheet">
		<link rel="stylesheet" href="../../../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="comment3.css">
	</head>
	<body>
		<div class="header">
			<a href="../../home" id="title">CAMAGRU</a>
			<br>
			<div class="header_menu">
				<a href="../../home" id="like_menu_header">HOME</a>
				<a href="../../all" id="like_menu_header">GALERIE</a>
				<a href="../../params" id="like_menu_header">PARAMETRES</a>
				<a href="../../../php/deco.php" id="like_menu_header">DECONNEXION</a>
			</div>
		</div>
			<?php
				$statement = $conn->prepare("SELECT * FROM photo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
				$verif = 0;
				$resultat = $statement->fetchAll();
				$i = 0;
				while ($resultat[$i] && $verif == 0)
				{
                    if ($resultat[$i]['id'] == $_GET['id'])
                        $verif = 2;
					else
						$i++;
				}
                $fichier = fopen('../../../save_img/'.$resultat[$i]['id'].'.png', 'wb'); 
    			fwrite($fichier, base64_decode($resultat[$i]['img']));
    			fclose($fichier);
				echo "<div class=\"photo\">";
				$id_photo = 0;
				$id_photo += $resultat[$i]['id'];
				echo "<img id=\"save_photo_img\" src=\"".'../../../save_img/'.$id_photo.".png \"alt=\"\">";
				$id = $resultat[$i]['id'];
				$color = like($id, $conn);
				$_SESSION['id_image_en_cours'] = $resultat[$i]['id'];
				echo "
					<form id=\"form_post\" method=\"POST\" action=\"../../../php/love_comment.php\">
						<input id=\"click\" style=\"background-color:".$color.";\" type=\"submit\" name=\"submit_love\" value=\"".$resultat[$i]['id']."\" />
					</form>";
				if ($color == "red")
					$mot = "Dislike";
				else if ($color == "green")
					$mot = "Like";						
				echo "<p id=\"like_dislike\">".$mot."</p>";
				echo "<p id=\"like_info\">".$resultat[$i]['nb_love']."</p>";
				echo "</div>";

			?>
            <div class="comment_photo">
                <?php
					$monfichier = "save_com/".$_SESSION['id_image_en_cours'];
					$verif_exist = file_exists($monfichier);
					if ($verif_exist == TRUE && ($fichier = fopen($monfichier, 'r')))
					{
						$res = fgets($fichier);
						$tab = explode("**", $res);
						$i = 0;
						while ($tab[$i] != "" && $res != "")
						{
							$res2 = explode("†", $tab[$i]);
							$name = $res2[0];
							$res2 = explode("∑", $res2[1]);
							$id_comment = $res2[0];
							$comment = $res2[1];
							$comment = htmlentities($comment);
							echo "<strong>".strtoupper(htmlentities($name))."</strong>";
							if ($_SESSION['name_user'] == $name)
								echo "<p id=\"com\" >".$comment."<a href=\"delete_com.php?id_com=".$id_comment."\" class=\"delete\"><i class=\"delete fa fa-trash\" aria-hidden=\"true\"></i></a></p>";
							else
								echo "<p id=\"com\" >".$comment."</p>";
							$i++;
							echo "<hr id=\"hr\">";
						}
						fclose($fichier);
					}
				?>
            </div>

            <form action="comment.php?id=<?php echo $_SESSION['id_image_en_cours']; ?>" method="POST" id="usrform">
                <input class="input_comment" placeholder="<?php if ($_SESSION['error_info'] != ""){ echo $_SESSION['error_info']; $_SESSION['verif_comment'] = TRUE; $_SESSION['error_info'] = "";} else echo ".......";?>
                " type="text" name="comment" value="" /><br>
                <input id="ok_button" type="submit" name="submit" value="OK" />
            </form>
			<div style="width: 100vw; height: 30px; background-color: #1a1e21; color: whitesmoke; display: block; position: fixed; bottom: 0px; padding-top: 13px;"> CAMAGRU © GAHUBAUL</div>
 	</body>
</html>