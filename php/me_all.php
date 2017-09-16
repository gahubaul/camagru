<?php
    session_start();
    if ($_SESSION['choice_photo'] == "all")
        $_SESSION['choice_photo'] = "me";
    else if ($_SESSION['choice_photo'] == "me")
        $_SESSION['choice_photo'] = "all";
    header('Location: ../page/all');
?>