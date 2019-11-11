<?php
    $query =   "SELECT EventName, Start_Time, EventPic, MainLocationID, EventDesc, InviteType, HostingUserID, Host_RSO_ID, rating
                FROM events
                WHERE EventID = ?";

    if($stmt = $link->prepare($query)){
        $stmt->bind_param('i', $_GET['Event']);
        $stmt->execute();
        $stmt->bind_result($eName, $eStart, $ePic, $eLocID, $eDesc, $eType, $eHostUser, $eHostRSO, $rating);
        $stmt->store_result();
        $stmt->fetch();

        $eDate = date("Y-m-d", strtoTime("$eStart"));
        $eHour = date("h", strtoTime("$eStart"));
        $eMin = date("m", strtoTime("$eStart"));
        $eSide = date("A", strtoTime("$eStart"));
        
        $query =   "SELECT *
                    FROM locations
                    WHERE locID = ?";

        if($stmt = $link->prepare($query)){
            $stmt->bind_param('i', $eLocID);
            $stmt->execute();
            $stmt->bind_result($eLocID, $eLat, $eLong, $eBuild, $eFloor, $eRoom);
            $stmt->store_result();
            $stmt->fetch();
        }

        error_log($eName . ' ' . $_GET['Event']);
    } else {
        header("location: ../index.php?error=event not found.");
    }
?>