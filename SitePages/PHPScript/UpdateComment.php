<?php
    session_start();
    include_once '../PHPScript/IsLoggedIn.php';
    require_once "config.php";

    $uid = $rid = $name = $desc = $pic = $Lat = $Long = $Building = $Floor = $Room = $eid = $error = "";

    $eid = trim($_GET["Event"]);
    $uid = trim($_SESSION["id"]);
    $comment = trim($_GET["Review"]);
    $rate = trim($_GET["Rate"]);
    $action = trim($_GET["action"]);


    error_log("$eid");

    if ($action == "create") {
        
        $query =   "INSERT INTO commented
                    VALUES (?, ?, ?, ?, ?, ?)";

        if($stmt2 = $link->prepare($query)){
            $stmt2->bind_param("iidsss", $uid, $eid, $rate, $comment, $time, $date);
            $time = date("H:i:00");
            $date = date("Y-m-d");
            $stmt2->execute();
            $stmt2->close();
            error_log("$query, $stmt2->error");
        }
    } elseif ($action =="update") {
        
        $query =   "UPDATE commented
                    SET Rating = ?, Text = ?, TimePrint = ?, DayOfPost = ? 
                    WHERE UserID = ? && EventID = ?";
           
        if($stmt2 = $link->prepare($query)){
            $stmt2->bind_param("dsssii", $rate, $comment, $time, $date, $uid, $eid);
            $time = date("H:i:00");
            $date = date("Y-m-d");
            $stmt2->execute();
        error_log("$query, $stmt2->error");
            $stmt2->close();
        }
    } elseif ($action == "delete") {
        
        $query =   'DELETE
                    FROM commented
                    WHERE UserID = ? && EventID = ?';
           
           if($stmt2 = $link->prepare($query)){
            error_log("$uid, $eid");
                $stmt2->bind_param("ii", $uid, $eid);
                $stmt2->execute();
           error_log("$query, $stmt2->error");
                $stmt2->close();
           }
    }
    error_log("$query, $link->error");

    
    $query =   "SELECT rating
                FROM commented
                WHERE EventID = ?";

    if ($stmt = $link->prepare($query)) {
        $stmt->bind_param("i", $eid);
        $stmt->execute();
        $stmt->bind_result($num);
        $stmt->store_result();

        if ($stmt->num_rows()) {
            $total = $stmt->num_rows();
            $count = 0;

            while($stmt->fetch()){
                $count = $count + $num;
            }

            $total = $count/$total;

            $query =   "UPDATE events
                    SET rating = ?
                    WHERE EventID = ?";

            if ($rateUp = $link->prepare($query)) {
            $rateUp->bind_param("ii", $total, $eid);
            $rateUp->execute();
            $rateUp->close();
            }
        }
    }
    header("location: ../PHPPage/LoadEventPage.php?Event=$eid");
?>