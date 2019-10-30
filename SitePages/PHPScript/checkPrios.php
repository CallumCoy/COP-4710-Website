<?php

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        # relocate
        header("location: /../index.php");
        exit;
    }
    
    $error = "";

    require_once "config.php";
    $stmt = "SELECT SchoolID FROM students WHERE UserID = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, $param_userID);

        $param_userID = _SESSION["id"];

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 0){
                $error = "you don't even have a school.";
            } else if (mysqli_stmt_num_rows($stmt) > 1){
                $error = "Something really wacky happened here please contact tech support";
            } 
        }

        if ($error != ""){
            header("location: ../index.php?error_message=$error");
        }
        mysqli_stmt_close($stmt);
    }
    $stmt = "SELECT SchoolID FROM students WHERE UserID = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_userID);

        $param_userID = _SESSION["id"];

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 0){
                $error = "you don't even have a school.";
            } else if (mysqli_stmt_num_rows($stmt) > 1){
                $error = "Something really wacky happened here please contact tech support";
            } else {
                mysqli_stmt_bind_result($stmt, $schoolID);
            }
        }

        if ($error != ""){
            header("location: ../index.php?error_message=$error");
        }
        mysqli_stmt_close($stmt);
    }

    #now checking if the group exist and that the student is the admin of it
    $stmt = "SELECT RSO_ID FROM rso WHERE RSO_Name = ? && SchoolID = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "si", $paramRSO_Name, $param_SchoolID);

        $param_SchoolID = $schoolID;
        $paramRSO_Name = $RSOVal;

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 1){
                
                mysqli_stmt_bind_result($stmt, $RSO_ID);
                
                #now checking if the student is the admin of this RSO
                $stmt2 = "SELECT RSO_ID FROM admins WHERE RSO_ID = ? && UserID = ?";

                if($stmt2 = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt2, "ii", $paramRSO_ID, $param_UserID);
                    
                    $param_userID = _SESSION["id"];
                    $paramRSO_ID = $RSO_ID;
                    
                    if(mysqli_stmt_execute($stmt2)){
                        mysqli_stmt_store_result($stmt2);
                        
                        if (mysqli_stmt_num_rows($stmt2) != 1){
                            $error = "you are not the admin of this group.";
                        }
                    }
                    mysqli_stmt_close($stmt2);
                }
            } 
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);

    if (error != ""){
        header("location: ../index.php?error_message=$error");
    }
?>