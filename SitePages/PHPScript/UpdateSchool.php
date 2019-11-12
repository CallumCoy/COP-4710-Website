<?php
    session_start();
    include_once '../PHPScript/IsLoggedIn.php';

    $uid = $rid = $name = $desc = $pic = $Lat = $Long = $Building = $Floor = $Room = $eid = $error = "";

    $sid = trim($_POST["sid"]);
    $uid = trim($_SESSION["id"]);
    $name = trim($_POST["Name"]);
    $desc = trim($_POST["Desc"]);
    $Lat = trim($_POST["Lat"]);
    $Long = trim($_POST["Long"]);
    $SchoolExt = trim($_POST["EmailExt"]);
    if ($sid < 1){
        $sid = NULL;
    }

    require_once "config.php";
    include '../PHPScript/AreTheyAdmin.php';
    include '../PHPScript/SetUpPicture.php';

    #does this data already exist?

    if($sid != NULL && $sid > 0 && $admin > 1){
        error_Log("1 row");


        $query = "  UPDATE school
                    SET SchoolName = ?, SchoolPic = ?, SchoolDesc = ?, School_Lat = ?, School_long = ?, SchoolExt = ? 
                    WHERE SchoolID = ?";
            error_log("file updated? Error: " . $query);

        if($stmt2 = $link->prepare($query)){
            $stmt2->bind_param("sssiisi", $name, $pic, $desc, $Lat, $Long, $SchoolExt, $sid);
            error_log("file updated? Error: " . $pic);
            error_log("file updated? Error: " . $desc);
            $stmt2->execute();

            $stmt2->close();
        }

    } elseif($admin > 1) {
                            
        $query = "  INSERT INTO school
                    VALUES (default, ?, ?, ?, 0, 0, ?, ?, ?)";

        if($make = $link->prepare($query)){
            $make->bind_param("sssiis", $name, $pic, $desc, $Lat, $Long, trim($SchoolExt));
            $make->execute();
            $make->close();
        }
        
                            
        $query = "  SELECT SchoolID 
                    FROM school
                    WHERE School_Lat = $Lat && School_Long = $Long";

        if($get = $link->prepare($query)){
            $get->execute();
            $get->bind_result($sid);
            $get->store_result();
            $get->fetch();
            $get->close();
        }
                            
        $query = "  INSERT INTO super_admins
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
    
    header("location: ../PHPPage/LoadSchool.php?sid=$sid")
?>