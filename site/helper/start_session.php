<?php
    session_start();
    $userName = array_key_exists('userName', $_SESSION) ? $_SESSION['userName']: "";
    $userEmail = array_key_exists('userEmail', $_SESSION) ? $_SESSION['userEmail'] : ""; 
?>