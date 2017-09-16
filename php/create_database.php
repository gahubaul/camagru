<?php

    include "../config/database.php";
    include "explode.php";
    try {
		$conn = new PDO("mysql:host=".$host.";port=".$port, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn-> exec("CREATE DATABASE IF NOT EXISTS $name_db");
	}
    catch (PDOException $e)
    {
        $i = 2;
    }
?>