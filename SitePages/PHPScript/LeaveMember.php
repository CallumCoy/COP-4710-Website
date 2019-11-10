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

    $query =   'SELECT 1
                FROM admins
                WHERE RSO_ID = ? && UserID = ?';

    if($stmt2 = $link->prepare($query)){
        $stmt2->bind_param('ii', $rid, $_SESSION['id']);
        $stmt2->execute();
        $stmt2->store_result();
        
        if($stmt2->num_rows() == 0){
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

                    $query =   'DELETE
                                FROM members
                                WHERE UserID = ? && RSO_ID = ?';
                    
                    if($signUp = $link->prepare($query)){
                        $signUp->bind_param('ii',  $_SESSION['id'], $rid);
                        $signUp->execute();
                        $signUp->close();
                        error_log($query . " " . $signUp->error);
                        error_log($rid . " " . $signUp->error);
                        error_log($_SESSION["id"] . " " . $signUp->error);

                        $query =   'UPDATE rso
                                    SET NumofMembers = NumofMembers - 1
                                    WHERE RSO_ID = ' . $rid;
                                    
                        if($update = $link->prepare($query)){
                            $update->execute();
                            $update->close();
                    
                        }
                    }
                }
                $stmt->close();
            }
        }
        $stmt2->close();
    }

    error_log($query . " " . $link->error);

    header("location: ../PHPPage/LoadRSOPage.php?RSO=$rid");
?>