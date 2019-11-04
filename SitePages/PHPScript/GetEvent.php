<?php
$query = "SELECT EventName, Start_Time, EventPic, EventDesc, InviteType, Host_RSO_ID
          FROM events
          WHERE EventID = ?";

if  ($stmt = $link->prepare($query)){
    
    $stmt->bind_param("i", $eID);
    $stmt->bind_result($eName, $eStart, $ePic, $eDesc, $eInvType, $host);
    $stmt->execute();
    $stmt->store_result();
    $stmt->fetch();
}
?>