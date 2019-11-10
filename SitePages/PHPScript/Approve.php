<?php
    include "AreTheyAdmin.php";

    if($admin > 0){
        $query =   'SELECT RSO_ID
                    FROM admins
                    WHERE UserID = ?';
        
        if($getClubs = $link->prepare($query)){

            $getClubs->bind_param('i', $_SESSION['id']);
            $getClubs->execute();
            $getClubs->bind_result($rid);
            $getClubs->store_result();
            
            while($getClubs->fetch()){

                $query =   'SELECT *
                            FROM events
                            WHERE RSO_ID = ?
                            ORDER BY approved ASC';
        
                if($getEvents = $link->prepare($query)){
                   
                    $getEvents->bind_param("i", $rid);
                    $getEvents->execute();
                    $getEvents->bind_result($eID, $eName, $eStart, $ePic, $eLocID, $eDesc, $eInvType, $eHost, $erHost, $eSchoolID, $eApproved);
                    $getEvents->store_result();
                   
                    while($getEvents->fetch()){

                        $time =date("m/d/Y h:m A", strtotime("$eStart"));

                        echo'<a href="../PHPPage/LoadEventPage.php?Event=' . $eID . '"> <div class="event" >
                                <div class="eventPicDiv">
                                    <img src="' . $ePic . '" alt="Space" class="eventPic">
                                </div> </a>
                                <a href="../PHPPage/EditEventPage.php?Event=' . $eID . '"><div class="information setCol' . $eApproved . '">
                                    <h3>' . $eName .'</h3>
                                    <div class="text">
                                        <pre>
                                            ' . $eDesc .'
                                        <pre>
                                    </div>  
                                    <div class="startInfo">' . $time . '</div>    
                                </div>
                            </div> </a>';

                    }
                    $getEvents->close();
                }
            }
            $getClubs->close();
        }      
    }

    if($admin > 1){
        $query =   'SELECT SchoolID
                    FROM super_admins
                    WHERE UserID = ?';

        if($getSchoool = $link->prepare($query)){

            $getSchoool->bind_param('i', $_SESSION['id']);
            $getSchoool->execute();
            $getSchoool->bind_result($sid);
            $getSchoool->store_result();

            while($getSchoool->fetch()){

                $query =   'SELECT *
                            FROM events
                            WHERE SchoolID = ?
                            ORDER BY approved ASC';

                if($getEvents = $link->prepare($query)){
                
                    $getEvents->bind_param("i", $sid);
                    $getEvents->execute();
                    $getEvents->bind_result($eID, $eName, $eStart, $ePic, $eLocID, $eDesc, $eInvType, $eHost, $erHost, $eSchoolID, $eApproved);
                    $getEvents->store_result();
                
                    while($getEvents->fetch()){

                        $time =date("F jS Y    |    h:m A", strtotime("$eStart"));

                        echo'<a href="../PHPPage/LoadEventPage.php?Event=' . $eID . '"> <div class="event" >
                                <div class="eventPicDiv">
                                    <img src="' . $ePic . '" alt="Space" class="eventPic">
                                </div> </a>
                                <a href="../PHPPage/EditEventPage.php?Event=' . $eID . '"><div class="information setCol' . $eApproved . '">
                                    <h3>' . $eName .'</h3>
                                    <div class="text">
                                        <pre>
                                            ' . $eDesc .'
                                        <pre>
                                    </div>  
                                    <div class="startInfo">' . $time . '</div>    
                                </div>
                            </div> </a>';
                    }

                    $getEvents->close();
                }
            }
            $getSchoool->close();
        }
    }
    error_log("$query $link->error");
?>