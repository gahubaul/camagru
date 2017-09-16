<?php 
	session_start();
	function base64_encode_image($filename=string,$filetype=string)
	{
    	if ($filename)
		{
        	$imgbinary = fread(fopen($filename, "r"), filesize($filename));
			$base64 = base64_encode($imgbinary);
			return $base64;		
        	
		}
	}

	function base64_to_jpeg($base64_string, $output_file)
	{
    	
		$fichier = fopen($output_file, 'wb'); 

    	fwrite($fichier, base64_decode($base64_string));

    	fclose($fichier); 

    	return $output_file; 
	}

    include "../config/database.php";
    include "explode.php";
    try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
	    die('Error create table : ' . $e->getMessage());
		echo "connexion fail";
	}

    if (($_POST['canvas_valid'] || $_POST['canvas_valid'] === "0") && ($_POST['data'] || $_POST['data'] === "0") && $_POST['submit'] === "MISE EN GALERIE")
	{
		$test = preg_replace("/^data:image\/png;base64,/", "", $_POST['canvas_valid']);
		$res = preg_match("/^[a-zA-Z\/+=0-9]{100,}$/", $test);
		if ($res == 1)
		{
			$fichier = fopen('save/tmp.png', 'wb'); 
    		fwrite($fichier, base64_decode($test));
    		fclose($fichier);
			$tab = explode(" ", $_POST['data']);
			$TailleImage = getimagesize("../img/png/".$tab[4]);
			$dest = imagecreatefrompng("save/tmp.png");
			$src = imagecreatefrompng("../img/png/".$tab[4]);
			imagecopyresized($dest, $src, $tab[0], $tab[1], 0, 0, $tab[2], $tab[3], $TailleImage[0], $TailleImage[1]);
			imagepng($dest, "save/tmp.png");
			$test = base64_encode_image("save/tmp.png", "png");
			$statement = $conn->prepare("SELECT * FROM photo");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			$verif = 0;
			while($resultat = $statement->fetch())
			{
				;
			}
			$statement = $conn->prepare("INSERT INTO `photo` (id, id_user, img, love, nb_love, com) VALUES (?,?,?,?,?,?)");
			$statement->execute(array (NULL, $_SESSION['id_user'], $test, "", 0, 0));
			$statement = $conn->prepare("SELECT * FROM photo");
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$statement->execute();
			$verif = 0;
			while(($resultat = $statement->fetch()))
				$verif = $resultat['id'];
			rename("save/tmp.png", "../save_img/".$verif.".png");
			header('Location: ../page/home/no_cam');
		}
		else
		{
			$_SESSION['error_info'] = "image non reconnue";
			header('Location: ../page/home/no_cam');
		}
	}
	else
	{
		$_SESSION['error_info'] = "image non reconnue";
		header('Location: ../page/home/no_cam');
	}

 ?>