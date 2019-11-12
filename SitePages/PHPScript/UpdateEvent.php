<?php
    session_start();
    include_once '../PHPScript/IsLoggedIn.php';

    $uid = $rid = $name = $desc = $Lat = $Long = $Building = $Floor = $Room = $eid = $error = "";

    $eid = trim($_POST["eid"]);
    $uid = trim($_SESSION["id"]);
    if (isset($_POST["rid"])) {
        $rid = trim($_POST["rid"]);
    }
    $name = trim($_POST["Name"]);
    $desc = trim($_POST["Desc"]);
    $date = trim($_POST["StartDate"]);
    $hour = trim($_POST["StartHours"]);
    $min = trim($_POST["StartMinute"]);
    $clockCycle = trim($_POST["StartClockSide"]);
    $Lat = trim($_POST["Lat"]);
    $Long = trim($_POST["Long"]);
    $Building = trim($_POST["Building"]);
    $Floor = trim($_POST["Floor"]);
    $Room = trim($_POST["Room"]);
    $invType = trim($_POST['Type']);

    include '../PHPScript/SetUpPicture.php';

    if ($rid < 1){
        $rid = NULL;
        if ($invType == 2){
            $invType = 1;
        }
    }

    $hour = $hour%12;

    if(($min % 15) != 0 || $min > 59 || $min < 0){
        $temp = $min/60;
        $temp2 = $min%15;
        $min = $min - ($temp * 60) - $temp2; 
    }

    $lilTime = date("H:i:s", strtoTime("$hour:$min $clockCycle"));
    error_log($lilTime);
    $time = date('Y-m-d H:i:s', strtoTime("$date $lilTime"));
    error_log($time);

    require_once "config.php";
    include '../PHPScript/AreTheyAdmin.php';
    error_log("-[==-=========================================================================================== ");
    require '../PHPScript/UpdateLocation.php';

    $query =   'SELECT 1
                FROM events
                WHERE EventID != ? && MainLocationID = ? && Start_Time = ?';

    if($check = $link->prepare($query)){
         
        $check->bind_param('iis', $eid, $lid, $time);
        $check->execute();
        $check->store_result();

        if($check->num_rows == 0){
            error_log("eid = $eid");
            if($eid > 0){
                error_Log("1 row");

                $query = "  SELECT approved
                            FROM events
                            WHERE EventID = ?";
                

                if($stmt = $link->prepare($query)){
                    $stmt->bind_param("i", $admin);
                    error_log("location: " . $lid);
                    error_log("file updated? Error: " . $desc);
                    $stmt->execute();
                    $stmt->bind_result($admin);
                    $stmt->close();
                }

                $query = "  UPDATE events
                            SET EventName = ?, Start_Time = ?, EventPic = ?, EventDesc = ?, InviteType = ?, HostingUserID = ?, Host_RSO_ID = ?, approved = ?, MainLocationID = ?
                            WHERE EventID = ?";

                    error_log("file updated? Error: " . $query);
                    error_log("file updated? admin level: " . $admin);
                    error_log("file updated? admin level: " . $lid);
                    error_log("file updated? Error: " . $desc);

                if($admin > 0){
                    $admin = 1;
                }

                if($stmt2 = $link->prepare($query)){
                    $stmt2->bind_param("ssssiiiiii", $name, $time, $pic, $desc, $invType, $uid ,$rid, $admin, $lid, $eid);
                    error_log("file updated? Error: " . $pic);
                    $stmt2->execute();
                    error_log("file updated? Error: " . $stmt2->error);

                    $stmt2->close();
                }

            } elseif ($eid == 0){
                                    
                $query = "  SELECT 1
                            FROM events
                            WHERE EventName = ? && Host_RSO_ID = ? && SchoolID = ?";
            
                if($stmt1 = $link->prepare($query)){
                    $stmt1->bind_param("sii", $name, $rid, $_SESSION["sid"]);
                    $stmt1->execute();

                    error_log("RSO created? Error: " . $rid);

                    $stmt1->store_result();
                    $stmt1->fetch();

                    error_log("RSO created? Error: ROWS " . $stmt1->num_rows());

                    if($stmt1->num_rows() < 1){
                        $query =   "INSERT INTO events
                                    VALUES (default, ?,?,?,?,?,?,?,?,?,?, 5)";
                        
                        error_Log("0 rows");
                        if($stmt21 = $link->prepare($query)){
                            error_Log($_SESSION["sid"] . " " . $_SESSION["id"]);
                            $stmt21->bind_param("sssisiiiii", $name, $time, $pic, $lid, $desc, $invType, $uid ,$rid, $_SESSION['sid'], $admin);
                            $stmt21->execute();
                            error_log("RSO created? Error: " . $stmt2->error);
                            error_log("RSO created? Error: " . $name . ', ' . $time . ', ' . $pic . ', ' . $desc . ', ' . $invType . ' ' . $uid . ' ' . $rid . ' ' . $eid . ' ' . $admin);

                            $stmt21->close();
                        }
    error_log("file updated? Error: $link->error $query");

                    }
                }

            } else {
                $error = "something really bad happened somewhere";
            }
        }
        $check->close();
    }

    error_log("file updated? Error: " . $link->error);
    
                            
    $query = "  SELECT EventID
                FROM events
                WHERE EventName = ? && Host_RSO_ID = ? && SchoolID = ?";

    if($stmt1 = $link->prepare($query)){
        $stmt1->bind_param("sii", $name, $rid, $_SESSION["sid"]);
        $stmt1->execute();
        $stmt1->bind_result($eid);
        error_log("RSO created? Error: " . $eid);
        $stmt1->store_result();
        $stmt1->fetch();
        error_log("RSO created? Error: " . $stmt1->error);
        error_log("RSO created? Error: " . $eid);

        header("location: /../PHPPage/LoadEventPage.php?Event=". $eid);
        $stmt1->close();
    }
    $link->close();
?>