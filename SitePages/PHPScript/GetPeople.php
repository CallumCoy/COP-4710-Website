<?php
    if(isset($_GET["type"])){
        $people = $_GET["type"];
    }

    $query = "SELECT USERID
              FROM " . $people . "
              WHERE RSO_ID = ?";

    if($stmt = $link->prepare($query)){
        $stmt->bind_param("i", $rID);
        $stmt->execute();
        $stmt->bind_result($ID);
        $stmt->store_result();


        while($stmt->fetch()){

            $query = "SELECT Username, ProfilePic
                      FROM Users
                      WHERE UserID = ?";

            if($stmt2 = $link->prepare($query)){
                $stmt2->bind_param("i", $ID);
                $stmt2->execute();
                $stmt2->bind_result($Name, $Pic);
                $stmt2->store_result();
                $stmt2->fetch();

                echo ('<div class="person">
                            <div class="miniPic">
                                    <img src="' . $Pic . '" alt="Space" class="eventPic">
                                </div>                      
                                <div class="InfoTable">
                                    <div class="Info">
                                        ' . $Name . '
                                    </div>
                                </div>
                        </div>');
                
                $stmt2->close();
            }
        }
    $stmt->close();
    }
?>