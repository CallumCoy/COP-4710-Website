<?php
    $error = "";
    $search = "";
    $numOfGets = count($_GET);
    error_log("hi");
    
    if(isset($_GET["Start"])){
        $search =  $search . "Start_Time = " . $_GET['Start'];
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }

    if(isset($_GET["Name"])){
        $search =  $search . "EventName = '" . $_GET['Name'] ."'";
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }
    
    if(isset($_GET["School"])){
        $search =  $search . "SchoolID = " . $_GET['School'];
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }
    
    if(isset($_GET["Host"])){
        $search =  $search . "Host_RSO_ID = " . $_GET['Host'];
        $numOfGets = $numOfGets - 1;
    }
    
    if(isset($_GET["UHost"])){
        $search =  $search . "HostingUserID = " . $_GET['UHost'];
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }

    if(isset($_GET["UHost"]) && $_GET["UHost"] = $_SESSION["id"]){
        $command = 'href="../PHPPage/EditEventPage.php?Event=';
    } else {
        $command = 'href="../PHPPage/LoadEventPage.php?Event=';
    }

    $query = "  SELECT * 
                FROM events 
                WHERE " . $search . "
                ORDER BY Start_Time DESC, EventName DESC";

    error_log($query);
    #Is it a new RSO or not
    if($stmt = $link->prepare($query)){
        $stmt->execute();
        $stmt->bind_result($eID, $eName, $eTime, $ePic, $eStart, $eLocID, $eDesc, $eInvType, $eHost, $eSchoolID);
        $stmt->store_result();
            while($stmt->fetch()){
                if($eInvType == 0){
                    echo   '<a ' . $command . $eID . '"> <div class="event" >
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
                } elseif($eInvType == 1){ 
                    
                    $query =   'SELECT 1
                    FROM students
                    WHERE UserID = ? && SchoolID = ?';

                    if  ($stmt2 = $link->prepare($query)){
                        
                        $stmt2->bind_param("i", $_SESSION["id"], $eSchoolID);
                        $stmt2->execute();
                        $stmt2->store_result();
                        error_log("num of rows " . $stmt->num_rows() . " " .  $_SESSION["id"]);
                        error_log("is there any groups? Error: " . $RSO);
                        
                        if($stmt2->num_rows() == 1){
                            echo   '<a ' . $command . $eID . '"> <div class="event" >
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
                } else {
                    $query =   'SELECT 1
                                FROM members
                                WHERE UserID = ? && RSO_ID = ?';
        
                    if  ($stmt2 = $link->prepare($query)){
                        
                        $stmt2->bind_param("ii", $_SESSION["id"], $eHost);
                        $stmt2->execute();
                        $stmt2->store_result();
                        error_log("num of rows " . $stmt->num_rows() . " " .  $_SESSION["id"]);
                        error_log("is there any groups? Error: " . $eHost);
                        
                        if($stmt2->num_rows() == 1){
                            echo   '<a '. $command . $eID . '"> <div class="event" >
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
    }

    $link->close();

    if ($error != ""){
        header("location: ../index.php?error_message=$error");
    }
?>