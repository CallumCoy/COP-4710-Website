<?php
    $error = "";
    
    error_log("hi");

    $query = "  SELECT RSO_Name, RSO_Desc, RSO_ProfPic, NumofMembers
                FROM rso 
                WHERE RSO_ID = ?";

    #Is it a new RSO or not
    if($stmt = $link->prepare($query)){
        $stmt->bind_param("i", $rID);
        error_log($rID);
        $stmt->execute();
        $stmt->bind_result($orName, $desc, $pic, $num);
        $stmt->store_result();
        $stmt->fetch();

        if($stmt->num_rows == 1){
            error_log("succesfully set the values.");
            #$rID
            #$orName
            #$desc
            #$pic
            #$num
        } else if ($stmt->num_rows == 0) {
            #send all the details to the page
            $error = "RSO doesn't exist.";
        } else {
            $error = "several of this RSO exist";
        }
        $stmt->close();
    }

    if ($error != ""){
        header("location: ../index.php?error_message=$error");
    }
?>