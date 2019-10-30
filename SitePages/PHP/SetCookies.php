<?php
    
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: index.php");
        exit;
    }

    $userID = $_SESSION["id"];
    setcookie("UserNumber", userID, time()+3600);
?>