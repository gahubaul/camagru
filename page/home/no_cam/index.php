<?php
	session_start();


	$path = $_SESSION['id_user'].".png";

	if ($_SESSION['connexion'] != TRUE || $_SESSION['name_user'] == "")
		header('Location: ../../connect');
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
		$verif = scandir("../../../img/png/");
		foreach($verif as $key => $elem)
		{
			if ($elem != "." && $elem != ".." && $elem != "empty.png")
			{
				$dir = "../../../img/png/".$elem;
				echo "<img id=\"img_png\" onclick=\"change_img(this)\" src=\"".$dir."\" style=\"width:50px; height:50px;\"alt=\"\">";
			}
		}
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
?>
<html>
	<head>
		<title>Camagru - HOME</title>
		<link href="https://fonts.googleapis.com/css?family=Bungee+Shade|Cabin|Kavoon|Cutive|Lora|Anton|Acme|PT+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bungee|Inconsolata|Hind|Rubik:900" rel="stylesheet">
		<link rel="stylesheet" href="../../../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="home1.css">
	</head>
	<body>
		<canvas id="canvas_valid"></canvas>
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
		<form class="form1" action="../../../php/upload.php" method="POST" enctype="multipart/form-data">
    		Select image to upload:<input type="file" name="fileToUpload" id="fileToUpload"> <input type="submit" value="Upload Image" name="submit_upload">
		</form>
		<div id="div_img_png"><?php print_img();?></div>
		<img id="no_video" width="500px" height="375px" style="background-image: url('<?php echo $_SESSION['id_user'].".png";?>'); background-size: 500px 375px;" src="<?php if(file_exists($path))echo $_SESSION['id_user'].".png";?>" alt="">
		<div id="video2">
			<img style="width:50px; height:50px; position:relative; top:0px; left:0px ;z-index:100;" id="yolo" src="../../../img/png/empty.png" alt="">
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
				$nb = 0;
				while ($i >= 0)
				{
					if ($resultat[$i]['id_user'] == $_SESSION['id_user'])
					{
						echo "<img style=\"width:260px; margin-bottom:20px;height:195px;\" src=\"../../../save_img/".$resultat[$i]['id'].".png\" alt=\"\">";
						$nb++;
					}
					if ($nb == 3)
						$i = -1;
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
		<canvas id="canvas_rendu" style="background-image: url(../../../img/no_photo.png); background-size: 500px 375px;"></canvas>
		
		<form class="form" action="../../../php/base64_encode_no_cam.php" method="POST" style="color: white;">
			<input id="input" style="visibility: hidden; position: absolute; top: -300px;" type="text" name="canvas_valid" value="coucou" />
			<input id="input2" style="visibility: hidden; position: absolute; top: -300px;" type="text" name="data" value="coucou" />
			<input id="click" type="submit" name="submit" value="MISE EN GALERIE" />
		</form>
 		<script type="text/javascript" src="home.js"></script>
		<script type="text/javascript" src="png.js"></script>
		<div style="width: 100vw; height: 30px; background-color: #1a1e21; color: whitesmoke; display: block; position: fixed; bottom: 0px; padding-top: 13px;"> CAMAGRU © GAHUBAUL</div>
 	</body>
</html>
