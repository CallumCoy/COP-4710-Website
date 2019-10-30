<?php
    #start up the seciton
    session_start();
    
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        include_once __DIR__ . '/PHPScript/SetCookies.php';
    } else {
        header("position: /../index.php");
    }
?>