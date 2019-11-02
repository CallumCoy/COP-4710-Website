<?php
    #start up the seciton
    
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        include_once __DIR__ . '/SetCookies.php';
    } else {
        header("position: /../index.php");
    }
?>