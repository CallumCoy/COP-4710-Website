<?php
    $query =   "SELECT EventName, Start_Time, EventPic, MainLocationID, EventDesc, InviteType, HostingUserID, Host_RSO_ID
                FROM events
                WHERE EventID = ?";

    if($stmt = $link->prepare($query)){
        $stmt->bind_param('i', $_GET['Event']);
        $stmt->execute();
        $stmt->bind_result($eName, $eStart, $ePic, $eLocID, $eDesc, $eType, $eHostUser, $eHostRSO);
        $stmt->store_result();
        $stmt->fetch();

        error_log($eName . ' ' . $_GET['Event']);
    } else {
        header("location: ../index.php?error=event not found.");
    }
?>