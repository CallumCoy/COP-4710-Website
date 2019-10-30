<?php
    $error = "";

    require_once "/../PHPScript/config.php";
    $stmt = "SELECT RSO_Desc RSO_ProPic FROM rso WHERE RSO_ID - ?";

    if(mysqli_stmt_prepare($link, $sql)){
        mysqli_stmt_bound_param($stmt, "i", $param_RSO_ID);

        $param_RSO_ID = $RSO_ID;
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){
                
                mysqli_stmt_bind_result($stmt, $desc, $pic);

            } else if (mysqli_stmt_num_rows($stmt) == 0){

                $desc = "";
                $pic = "";

            } else {

                $error = "honestly it should be impossible to get here";

            }

            mysqli_stmt_close($stmt);

        }
    }
    mysqli_close($link);

    if (error != ""){
        header("location: ../index.php?error_message=$error");
    }
?>