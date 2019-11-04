<?php
$query = "SELECT EventID, EventName, Start_Time, EventPic, EventDesc, InviteType, Host_RSO_ID
          FROM events
          WHERE SchoolID = ?
          ORDER BY Start_Time DESC, EventName DESC";

if  ($stmt = $link->prepare($query)){
    
    $stmt->bind_param("i", $_SESSION["sid"]);
    $stmt->bind_result($eID, $eName, $eStart, $ePic, $eDesc, $eInvType, $host);
    $stmt->execute();
    $stmt->store_result();


    $eStart = date('m-d-Y G:i A', strtotime($eStart));

    error_log("num of rows " . $stmt->num_rows() . " " .  $_SESSION["sid"]);
    error_log("is there any groups? Error: " . $eID);

    while ($stmt->fetch()){
        if($eInvType < 2){
            echo   '<a href="../PHPPage/LoadEventPage.php?Event=' . $eID . '"> <div class="event" >
                        <div class="eventPicDiv">
                            <img src="' . $ePic . '" alt="Space" class="eventPic">
                        </div>
                        <div class="information">
                            <h3>' . $eName .'</h3>
                            <div class="text">
                                desc: ' . $eDesc .'
                            </div>  
                            <div class="startInfo"> Date: ' . $eStart . '</div>    
                        </div>
                    </div> </a>';
        } else {
            $query =   'SELECT 1
                        FROM members
                        WHERE UserID = ? && RSO_ID = ?';

            if  ($stmt2 = $link->prepare($query)){
                
                $stmt2->bind_param("i", $_SESSION["id"], $eHost);
                $stmt2->execute();
                $stmt2->store_result();
                error_log("num of rows " . $stmt->num_rows() . " " .  $_SESSION["id"]);
                error_log("is there any groups? Error: " . $RSO);
                
                if($stmt2->num_rows() == 1){
                    echo   '<a href="../PHPPage/LoadEventPage.php?Event=' . $eID . '"> <div class="event" >
                                <div class="eventPicDiv">
                                    <img src="' . $ePic . '" alt="Space" class="eventPic">
                                </div>
                                <div class="information">
                                    <h3>' . $eName .'</h3>
                                    <div class="text">
                                        desc: ' . $eDesc .'
                                    </div>  
                                    <div class="startInfo"> Date: ' . $eStart . '</div>    
                                </div>
                            </div> </a>';
                }
            }
        }
    }
    $stmt->close();
}
?>