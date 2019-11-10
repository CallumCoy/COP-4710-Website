<?php
    session_start();
    require_once '../PHPScript/config.php';
    include_once '../PHPScript/IsLoggedIn.php';
    include_once '../PHPScript/SetCookies.php';
    
    if(!isset($_GET['rid'])){
        header("location: ../index.php");
    } else {
        $rid = $_GET['rid'];
    }

    $query =   'SELECT SchoolID
                FROM rso
                WHERE RSO_ID = ?';

    if($stmt = $link->prepare($query)){
        $stmt->bind_param('i', $rid);
        $stmt->execute();
        $stmt->bind_result($school);
        $stmt->store_result();
        $stmt->fetch();

        if($school == $_SESSION['sid']) {

            $query =   'INSERT INTO members
                        VALUES (?, ?)';
            
            if($signUp = $link->prepare($query)){
                $signUp->bind_param('ii', $_SESSION['id'], $rid);
                $signUp->execute();
                $signUp->close();

                include "../PHPScript/NewMember.php";
            }
        }
        $stmt->close();

    header("location: ../PHPPage/LoadRSOPage.php?RSO=$rid");

    }
?>