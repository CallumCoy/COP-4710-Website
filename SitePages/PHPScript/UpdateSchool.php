<?php
    session_start();
    include_once '../PHPScript/IsLoggedIn.php';

    $uid = $rid = $name = $desc = $pic = $Lat = $Long = $Building = $Floor = $Room = $eid = $error = "";

    $sid = trim($_POST["eid"]);
    $uid = trim($_POST["uid"]);
    $name = trim($_POST["Name"]);
    $desc = trim($_POST["Desc"]);
    $Lat = trim($_POST["Lat"]);
    $Long = trim($_POST["Long"]);
    $SchoolExt = trim($_POST["SchoolExt"]);
    if ($sid < 1){
        $sid = NULL;
    }

    require_once "config.php";
    include '../PHPScript/AreTheyAdmin.php';
    include '../PHPScript/SetUpPicture.php';

    #does this data already exist?

    if($sid != NULL && $admin > 1){
        error_Log("1 row");


        $query = "  UPDATE school
                    SET SchoolName = ?, SchoolPic = ?, SchoolDesc = ?, School_Lat = ?, School_long = ?, SchoolExt = ? 
                    WHERE SchoolID = ?";
            error_log("file updated? Error: " . $query);

        if($stmt2 = $link->prepare($query)){
            $stmt2->bind_param("sssiisi", $name, $pic, $desc, $Lat, $Long, $SchoolExt);
            error_log("file updated? Error: " . $pic);
            error_log("file updated? Error: " . $desc);
            $stmt2->execute();

            $stmt2->close();
        }

    } elseif($admin > 1) {
                            
        $query = "  INSERT INTO school
                    VALUES (default, ?, ?, ?, 1, 0, ?, ?, ?)";

        if($make = $link->prepare($query)){
            $make->bind_param("sssiisi", $name, $pic, $desc, $Lat, $Long, $SchoolExt);
            $make->execute();
            $make->close();
        }
                            
        $query = "  INSERT INTO super_amdins
                    VALUES (?, ?)";

        if($make = $link->prepare($query)){
            $make->bind_param("ii", $_SESSION['id'], $sid);
            $make->execute();
            $make->close();
        }

        include "../PHPScript/NewSchool.php";
    }
    error_log("file updated? Error: " . $link->error);
    $link->close();

?>