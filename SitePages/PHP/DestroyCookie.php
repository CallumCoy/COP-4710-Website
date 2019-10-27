<?php
    
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: index.php");
        exit;
    }

    $userID = $_SESSION["id"]
    setcookie("UserNumber", userID, mktime(12,0,0,1, 1, 1990));
    header("location: index.php");
?>