<?php

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        # relocate
        header("location: /../index.php");
        exit;
    }
    
    $error = $param_userID = "";

    #are they a student
    require_once "config.php";
    $sql = "SELECT SchoolID FROM students WHERE UserID = ?";

    if(!isset($_SESSION["sid"]) || $_SESSION["sid"] === NULL){
        $error = "you don't even have a school.";
    }

    #now checking if the group exist and that the student is the admin of it
    $sql = "SELECT RSO_ID FROM rso WHERE RSO_ID = ? && SchoolID = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ii", $paramRSO_ID, $param_SchoolID);

        $param_SchoolID = $_SESSION["sid"];
        $paramRSO_ID = $RSOVal;

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            error_log("num of rows " . mysqli_stmt_num_rows($stmt));
            
            if (mysqli_stmt_num_rows($stmt) == 1){
                
                mysqli_stmt_bind_result($stmt, $RSO_ID);
                
                #now checking if the student is the admin of this RSO
                $query = "SELECT RSO_ID FROM admins WHERE UserID = ? AND RSO_ID = ?";

                if($event = mysqli_prepare($link, $query)){
                    $event->bind_param( "ii", $_SESSION["id"], $RSOVal);
                    
                    error_log($param_userID . " " . $RSOVal);
                    
                    if($event->execute()){
                        mysqli_stmt_store_result($event);
                        error_log("file updated? Error: " . $event->error);
                        error_log("num of rows " . $event->num_rows());
                        
                        if (mysqli_stmt_num_rows($event) != 1){
                            $error = "you are not the admin of this group.";
                        }
                    }
                    mysqli_stmt_close($event);
                } else{
                    $error = "something happned.";
                }
            } else if(mysqli_stmt_num_rows($stmt) > 1){
                $error = "something happned.";
            }
        }
            $stmt->close();
    }

    if ($error != ""){
        error_log($error . "Priority failed");
        header("location: ../index.php?error_message=$error");
    }
?>