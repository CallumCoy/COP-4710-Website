<?php
    if(isset($_GET["type"])){
        $admin = $_GET["type"];
    }

    $aName = $aPic = $aEmail = "";

    $query = "SELECT USERID
              FROM " . $admin . "
              WHERE RSO_ID = ?";

    if($stmt = $link->prepare($query)){
        $stmt->bind_param("i", $rID);
        $stmt->execute();
        $stmt->bind_result($aID);
        $stmt->store_result();
        $stmt->fetch();

        $query = "SELECT Username, ProfilePic, Email
                  FROM Users
                  WHERE UserID = ?";

        if($stmt2 = $link->prepare($query)){
            $stmt2->bind_param("i", $aID);
            $stmt2->execute();
            $stmt2->bind_result($aName, $aPic, $aEmail);
            $stmt2->store_result();
            $stmt2->fetch();
            
            echo ('
            <div class="miniPic">
                <img src="' . $aPic . '" alt="Space" class="eventPic">
            </div>
            <div class="InfoTable">
                <div class="Info">
                    ' . $aName . '
                    <br>
                    ' . $aEmail . '
                </div>
            </div>');

            $stmt2->close();
        }
    }
?>