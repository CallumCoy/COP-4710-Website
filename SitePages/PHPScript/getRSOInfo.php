<?php
    session_start();
    $error = "";
    
    error_log("hi");

    if(isset($_GET["RSOs"])){
        $rName = $orName =  $_GET["RSOs"];
    } else {
        header("location: /../index.php");
    }

    include "./config.php";
    $query = "  SELECT RSO_Desc, RSO_ProfPic, NumofMembers
                FROM rso 
                WHERE RSO_Name = ? && SchoolID = ?";

    #Is it a new RSO or not
    if($stmt = $link->prepare($query)){
        $stmt->bind_param("si", $rName, $_SESSION["sid"]);
        $stmt->execute();
        $stmt->bind_result($desc, $pic, $num);
        $stmt->store_result();
        $stmt->fetch();

        if($stmt->num_rows == 0){
            header("location: /../PHPPage/editRSOPage.php?name=" . $orName . "&desc=''&pic=''&num=0");
        } else if ($stmt->num_rows == 1) {
            #send all the details to the page
            header("location: /../PHPPage/editRSOPage.php?name=" . $orName . "&desc=" . $desc . "&pic=" . $pic . "&num=" . $num);
        } else {
            header("location: /../index");
        }
        $stmt->close();
    }

    $link->close();

    if ($error != ""){
        header("location: ../index.php?error_message=$error");
    }
?>