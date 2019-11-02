<?php
    #start up the seciton

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        $userID = $_SESSION["id"];
        setcookie("UserNumber", $userID, time()+3600, "/");
    }
?>