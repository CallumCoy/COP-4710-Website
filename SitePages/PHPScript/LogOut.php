<?php
    #creates a session so there is always something to destroy
    session_start();

    #unset all possible varaiables
    $_SESSION = array();

    #DESTROY IT ALL
    session_destroy();
    include_once 'DestroyCookie.php';

    #sends you back to square 1
    header("location: /../index.php");
    exit;
?>