<?php
	session_start();
	include "../config/database.php";
    include "explode.php";
    try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
		$i = 2;
	}
	
	$user =  "CREATE TABLE IF NOT EXISTS `$name_db`.`user` ( 
			 `id` INT NOT NULL AUTO_INCREMENT , 
			 `login` VARCHAR(255) NOT NULL , 
			 `pass` VARCHAR(255) NOT NULL , 
			 `pass_mod` INT NOT NULL DEFAULT '0' ,
			 `mail` VARCHAR(255) NOT NULL , 
			 `img` VARCHAR(255) NOT NULL , 
			 `rules` INT NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
	$photo = "CREATE TABLE IF NOT EXISTS `$name_db`.`photo` ( 
			 `id` INT NOT NULL AUTO_INCREMENT ,
			 `id_user` INT NOT NULL ,
			 `img` LONGTEXT NOT NULL ,
			 `love` VARCHAR(255) NOT NULL ,
			 `com` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
			 
	$photo_2 = "ALTER TABLE `photo` ADD `nb_love` INT NOT NULL AFTER `love`;";

	try{
		$res = $conn-> exec($user);
		$res2 = $conn-> exec($photo);
		$res3 = $conn-> exec($photo_2);
	} catch (PDOException $e) {
		$i = 2;
	}
?>