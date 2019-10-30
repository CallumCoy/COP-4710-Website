<?php
    #start up the seciton
    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        $userID = $_SESSION["id"];
        setcookie("UserNumber", $userID, time()+3600, "/");
    }
?>