<?php
    $error = '';
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        # relocate
        header("location: /../index.php");
        exit;
    }
    
    $error = $param_userID = "";

    if(!isset($_SESSION["sid"]) || $_SESSION["sid"] === NULL){
        $error = "you don't even have a school.";
    }
    
    $query =   'SELECT 1
                FROM events
                WHERE EventID = ? && HostingUserID = ?';

    if($stmt = $link->prepare($query)){
        $stmt->bind_param("ii", $eid, $_SESSION['id']);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows() < 1){
            $error = "You are not the host of this event.";
        }
        $stmt->close();
    }

    $query =   'SELECT RSO_ID
                FROM admins
                WHERE UserID = ?';

    if($stmt = $link->prepare($query)){
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $stmt->bind_result($rso);
        $stmt->store_result();

        while($stmt->fetch()){
            
            $query =   'SELECT 1
                        FROM events
                        WHERE EventID = ? && Host_RSO_ID = ?';

            if($stmt2 = $link->prepare($query)){
                $stmt2->bind_param("ii", $eid, $rso);
                $stmt2->execute();
                $stmt2->store_result();

                if($stmt2->num_rows() > 0){
                    $error = "";
                }
                
                $stmt2->close();
            }
        }
        $stmt->close();
    }

    if ($error != ""){
        error_log($error . "Priority failed");
        header("location: ../index.php?error_message=$error");
    }
?>