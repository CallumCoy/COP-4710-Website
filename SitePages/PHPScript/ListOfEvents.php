<?php
    error_log("hi");
    echo '<datalist id=Events>';

    $error = "";

    require_once "config.php";
    $query = '  SELECT EventName
                FROM events
                WHERE (SchoolID = ? && InviteType = 1) OR InviteType = 0';

    if($stmt = $link->prepare($query)){

        $stmt->bind_param("i", $_SESSION["sid"]);
        $stmt->execute();
        $stmt->bind_result($Event);

        while($stmt->fetch()){
            echo '<option value="' . $Event . '">';
        }
        $stmt->close();
    }

    $query = '  SELECT EventName
                FROM events
                WHERE InviteType = 1';

    if($stmt = $link->prepare($query)){

        $stmt->execute();
        $stmt->bind_result($Event);
        $stmt->store_result();

        while($stmt->fetch()){
            
            $query = '  SELECT 1
                        FROM members
                        WHERE RSO_ID = ? && UserID = ?';
            
            if($stmt2 = $link->prepare($query)){

                $stmt2->bind_param("ii",$Event, $_SESSION["sid"]);
                $stmt2->execute();
                $stmt2->store_result();
                
                if($stmt2->num_rows() > 0){
                    echo '<option value="' . $Event . '">';        
                }
                $stmt2->close();
            }
        }
        $stmt->close();
    }

    echo '</datalist>';
?>