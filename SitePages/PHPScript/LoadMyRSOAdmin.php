<?php
    $error = "";

    require_once "config.php";

    $query = "SELECT RSO_ID 
              FROM admins
              WHERE UserID = ?";

    if  ($stmt = $link->prepare($query)){
        
        $stmt->bind_params($_SESSION["id"]);

        $stmt->execute();
        $stmt->bind_result($RSO);

        while ($stmt->fetch()){
            $query = "SELECT RSO_Name, RSO_Desc, RSO_ProfPic
                      FROM rso
                      WHERE RSO_ID = ?";

            if ($stmt2 = $link->prepare($query)){

                $stmt2->bind_params($RSO);
                $stmt2->execute();
                $stmt2->bind_result($name, $desc, $pic);

                while($stmt2->fetch()){
                    echo '<div class="eventList col-EventList">
                            <div class="event">
                                <div class="eventPicDiv">
                                    <img src="' . $RSO_ProfPic . '" alt="Space" class="eventPic">
                                </div>
                                <div class="information">
                                    <h3>' . $name .'</h3>
                                    <div class="text">
                                        desc: ' . $desc .'
                                    </div>  
                                </div>
                            </div>
                        </div>';
                }
            }
            $stmt2->close();
        }
        $stmt->close();
    }
    $link->clsoe();
?>