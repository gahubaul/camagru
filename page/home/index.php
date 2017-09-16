<?php
	session_start();

	$path = "no_cam/".$_SESSION['id_user'].".png";
	if(file_exists($path))
		unlink($path);

	if ($_SESSION['connexion'] != TRUE || $_SESSION['name_user'] == "")
		header('Location: ../connect');
	$display = "display: none;";
	if ($_SESSION['connexion'] === TRUE)
		$color = "background-color: green;";
	else if ($_SESSION['connexion'] === FALSE)
		$color = "background-color: red;";

	function base64_to_jpeg($base64_string, $output_file)
	{
    	
		$fichier = fopen($output_file, 'wb'); 

    	fwrite($fichier, base64_decode($base64_string));

    	fclose($fichier); 

    	return $output_file; 
	}
	function print_img()
	{
		$verif = scandir("../../img/png/");
		foreach($verif as $key => $elem)
		{
			if ($elem != "." && $elem != ".." && $elem != "empty.png")
			{
				$dir = "../../img/png/".$elem;
				echo "<img id=\"img_png\" onclick=\"change_img(this)\" src=\"".$dir."\" style=\"width:50px; height:50px;\"alt=\"\">";
			}
		}
	}

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
?>
<html>
	<head>
		<title>Camagru - HOME</title>
		<link href="https://fonts.googleapis.com/css?family=Bungee+Shade|Cabin|Kavoon|Cutive|Lora|Anton|Acme|PT+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bungee|Inconsolata|Hind|Rubik:900" rel="stylesheet">
		<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="home2.css">
	</head>
	<body>
		<canvas id="canvas_valid"></canvas>
		<?php include '../header/header.html'; ?>
		</div>
		<div id="div_img_png"><?php print_img();?></div>
		<h3 style="color:white;background-color: rgba(255, 0, 0, 0.6);margin-top:33px;" >PAS  DE  WEBCAM ?  <a id="click_salope" href="no_cam">Clique ICI !</a></h3>
		<video style="width:500px;height: 375px;" id="video"></video>
		<div id="video2">
			<img style="width:50px; height:50px; position:relative; top:0px; left:0px ;z-index:100;" id="yolo" src="../../img/png/empty.png" alt="">
		</div>
		<div style="color:white;" id="div_last_shot">
			<h2>Photo(s)</h2>
			<?php
				$statement = $conn->prepare("SELECT * FROM photo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$statement->execute();
				$verif = 0;
				$resultat = $statement->fetchAll();

				$i = 0;
				while ($resultat[$i])
					$i++;
				while ($i >= 0)
				{
					if ($resultat[$i]['id_user'] == $_SESSION['id_user'])
						echo "<img style=\"box-shadow: 0px 0px 23px black;width:260px; margin-bottom:20px;height:195px;\" src=\"../../save_img/".$resultat[$i]['id'].".png\" alt=\"\">";
					$i--;
				}
			?>
		</div>
		<button id="startbutton">*CLIC*</button>
		<div id="movebutton" >
			<button onclick="change_img_zoom()">ZOOM ++</button>
			<button onclick="change_img_dezoom()">ZOOM --</button>
			<button onclick="change_img_left()">LEFT</button>
			<button onclick="change_img_right()">RIGHT</button>
			<button onclick="change_img_top()">TOP</button>
			<button onclick="change_img_bot()">BOTTOM</button>
		</div>
		<canvas style="border-radius:0px;box-shadow: 0px 0px 0px black;" id="canvas_rendu"></canvas>
		<form class="form" action="../../php/base64_encode.php" method="POST" style="color: white;">
			<input id="input" style="visibility: hidden; position: absolute; top: -300px;" type="text" name="canvas_valid" value="coucou" />
			<input id="input2" style="visibility: hidden; position: absolute; top: -300px;" type="text" name="data" value="coucou" />
			<input id="click" type="submit" name="submit" value="MISE EN GALERIE" />
		</form>
 		<script type="text/javascript" src="home1.js"></script>
		<script type="text/javascript" src="png1.js"></script>
		<div style="width: 100vw; height: 30px; background-color: #1a1e21; color: whitesmoke; display: block; position: fixed; bottom: 0px; padding-top: 13px;"> CAMAGRU © GAHUBAUL</div>
 	</body>
</html>