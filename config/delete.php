<?php
	
	include "database.php";
    include "../php/explode.php";
    try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("DROP DATABASE IF EXISTS $name_db");
        $folder = "../save_img/";
            $dossier = opendir($folder);
            while ($fichier = readdir($dossier))
            {
                if ($fichier != "." && $fichier != "..")
                    unlink($folder.$fichier);
            }
            closedir($dossier);
            $folder = "../page/all/comment/save_com/";
            $dossier = opendir($folder);
            while ($fichier = readdir($dossier))
            {
                if ($fichier != "." && $fichier != "..")
                    unlink($folder.$fichier);
            }
            closedir($dossier);
	}
    catch (PDOException $e)
    {
        die("DB ERROR: ". $e->getMessage());
    }
?>