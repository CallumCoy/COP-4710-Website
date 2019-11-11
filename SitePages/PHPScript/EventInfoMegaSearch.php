<?php
    $error = "";
    $search = "";
    $numOfGets = 0;
    error_log("hi");
    
    foreach ($_GET as $key => $value){
        if ($value != NULL){
            $numOfGets ++;
        }
     }

     error_log($numOfGets);

    if(isset($_GET["view"]) && $_GET["view"] != NULL){
        $numOfGets = $numOfGets - 1;
        $view = $_GET["view"];
    } else {
        $view = 1;
    }

    if(isset($_GET["StartTime"]) && $_GET["StartTime"] != NULL){
        $time = $_GET["StarTime"];
        $numOfGets = $numOfGets - 1;
    } else {
        $time = date("h:i:sa");
    }

    if(isset($_GET["StartDate"]) && $_GET["StartDate"] != NULL){

        $date = $_GET['StartDate'];
        $interval = " - INTERVAL 2 HOUR";
        $numOfGets = $numOfGets - 1;

    } elseif(isset($_GET["Old"]) && $_GET["Old"] == 0){
        $interval = " - INTERVAL 1 DAY";
        $date = "2000-01-01";
        $numOfGets = $numOfGets - 1;

        if($numOfGets != 0){
            $search = $search . ' && ';
        }

    } else {
        $date = date("Y-m-d");
        $interval = " - INTERVAL 1 DAY";
    }
    date_default_timezone_set('US/Eastern');
    $search = $search . "Start_Time >= " . date(strtoTime("$date $time"));
        
    error_log("numofgets = " . $numOfGets);

    if($numOfGets != 0){
        error_log("search = " . $search);
        $search = $search . ' && ';
    }

    if(isset($_GET["Name"]) && $_GET["Name"] != NULL){
        $search =  $search . "EventName LIKE '" . $_GET['Name'] ."'";
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }
    
    if(isset($_GET["School"]) && $_GET["School"] != NULL){
        $search =  $search . "SchoolID = " . $_GET['School'];
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }
    
    if(isset($_GET["Host"]) && $_GET["Host"] != NULL){
        $search =  $search . "Host_RSO_ID = " . $_GET['Host'];
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        } 
    }
    
    if(isset($_GET["UHost"]) && $_GET["UHost"] != NULL){
        $search =  $search . "HostingUserID = " . $_GET['UHost'];
        $eid = $_GET['UHost'];
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        } 
    }

    include "../PHPScript/AreTheyAdmin.php";

    if(isset($_GET["UHost"]) && $_GET["UHost"] == $_SESSION["id"] && $view == 0){
        $command = 'href="../PHPPage/EditEventPage.php?Event=';
    } elseif ($admin == 1 && $view == 0) {
        $command = 'href="../PHPPage/EditEventPage.php?Event=';
    } else{
        $command = 'href="../PHPPage/LoadEventPage.php?Event=';
    }

    $query = "  SELECT * 
                FROM events 
                WHERE " . $search . "
                ORDER BY Start_Time ASC, EventName ASC";

    error_log($query);
    
    if($stmt = $link->prepare($query)){
        $stmt->execute();
        $stmt->bind_result($eID, $eName, $eStart, $ePic, $eLocID, $eDesc, $eInvType, $eHost, $erHost, $eSchoolID, $eApproved, $rating);


        include "../PHPScript/AreTheyAdmin.php";

        $stmt->store_result();
        
        error_log('number of events found ' .$stmt->num_rows());
        error_log($query . ' ' .$stmt->error);
        while($stmt->fetch()){

            $eStart =date("F jS Y | h:i A", strtotime("$eStart"));
            
            $query =   "SELECT * 
                        FROM members
                        WHERE RSO_ID = ?";

            if($numMem = $link->prepare($query)){

                if ($erHost != NULL){
                    $numMem->bind_param("i", $erHost);
                    $numMem->execute();
                    $numMem->store_result();
                    error_log($query . ' ' .$stmt->error);
                }

                error_log('num of mems ' . $numMem->num_rows());
                
                if ($erHost == NULL || $numMem->num_rows() > 4 || $view == 0){
                    error_log("hi");
                    if($eInvType == 0 && ($eApproved == 1 || $view == 0)){
                        echo   '<a ' . $command . $eID . '"> <div class="event" >
                                    <div class="eventPicDiv">
                                        <img src="' . $ePic . '"  class="eventPic">
                                    </div>
                                    <div class="information">
                                        <h3>' . $eName .'</h3>
                                        <div class="text">
                                            <pre>
                                                ' . $eDesc .'
                                                ' . $rating
                                            .'/5</pre>
                                        </div>  
                                        <div class="startInfo">  ' . $eStart . '</div>    
                                    </div>
                                </div> </a>';
                    } elseif($eInvType == 1 && ($eApproved == 1 || $view == 0)){ 
                        
                        $query =   'SELECT 1
                        FROM students
                        WHERE UserID = ? && SchoolID = ?';

                        if  ($stmt2 = $link->prepare($query)){
                            
                            $stmt2->bind_param("ii", $_SESSION["id"], $eSchoolID);
                            $stmt2->execute();
                            $stmt2->store_result();
                            error_log($query . ' ' .$stmt->error);
                            error_log("num of rows " . $stmt->num_rows() . " " .  $_SESSION["id"]);
                            
                            if($stmt2->num_rows() == 1){
                                echo   '<a ' . $command . $eID . '"> <div class="event" >
                                            <div class="eventPicDiv">
                                                <img src="' . $ePic . '"  class="eventPic">
                                            </div>
                                            <div class="information">
                                                <h3>' . $eName .'</h3>
                                                <div class="text">
                                                    <pre>
                                                        '
                                                        . $eDesc 
                                                        . $rating
                                                    .'/5</pre>
                                                </div>  
                                                </div>  
                                                <div class="startInfo">  ' . $eStart . '</div>    
                                            </div>
                                        </div> </a>';
                            }
                        }
                    } elseif($eApproved == 1 || $view == 0) {
                        $query =   'SELECT 1
                                    FROM members
                                    WHERE UserID = ? && RSO_ID = ?';
                
                        if  ($stmt2 = $link->prepare($query)){
                            
                            $stmt2->bind_param("ii", $_SESSION["id"], $erHost);
                            $stmt2->execute();
                            $stmt2->store_result();
                            error_log($query . ' ' .$stmt2->error);
                            error_log("num of rows " . $stmt2->num_rows() . " " .  $_SESSION["id"]);
                            error_log("is there any groups? Error: " . $erHost);
                            
                            if($stmt2->num_rows() == 1){
                                echo   '<a '. $command . $eID . '"> <div class="event" >
                                            <div class="eventPicDiv">
                                                <img src="' . $ePic . '"  class="eventPic">
                                            </div>
                                            <div class="information">
                                                <h3>' . $eName .'</h3>
                                                <div class="text">
                                                    <pre>
                                                        '
                                                        . $eDesc 
                                                        . $rating
                                                    .'/5</pre>
                                                </div>  
                                                <div class="startInfo">  ' . $eStart . '</div>    
                                            </div>
                                        </div> </a>';
                            }
                        }
                    }
                }
            }
        }
    }

    error_log($query . ' ' . $link->error);
    $link->close();

    if ($error != ""){
        header("location: ../index.php?error_message=$error");
    }
?>