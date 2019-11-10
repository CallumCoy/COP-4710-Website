<?php
    #start up the seciton

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        $userID = $_SESSION["id"];
        setcookie("UserNumber", $userID, time()+3600, "/");
        if(!isset($_SESSION['sid'])){
            $query =   'SELECT SchoolID
                        FROM users
                        WHERE UserID = ?';

            if($stmt = $link->prepare($query)){
                $stmt->bind_param('i', $_SESSION['id']);
                $stmt->execute();
                $stmt->bind_result($sid);
                $stmt->store_result();
                $stmt->fetch();

                if($stmt->num_rows == 1){
                    $_SESSION['sid'] = $sid;
                }
            }
        }
    }
?>