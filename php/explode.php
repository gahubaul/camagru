<?php
    $DB_DSN_tab = explode('mysql:', $DB_DSN);
    $DB_DSN_tab = explode(';', $DB_DSN_tab[1]);
    foreach($DB_DSN_tab as $key => $elem)
    {
        $DB_DSN_tab2 = explode('=', $elem);
        if ($DB_DSN_tab2[0] == "host")
            $host = $DB_DSN_tab2[1];
        else if ($DB_DSN_tab2[0] == "dbname")
            $name_db = $DB_DSN_tab2[1];
        else if ($DB_DSN_tab2[0] == "port")
            $port = $DB_DSN_tab2[1];
    }
    $root = $DB_USER;
    $root_password = $DB_PASSWORD;
?>