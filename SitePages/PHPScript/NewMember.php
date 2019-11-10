<?php

    $query =   'INSERT INTO members
                VALUES (' . $rid . ', ' . $_SESSION['id'] . ')';
                
    if ($update = $link->prepare($query)){
        $update->execute();
        $update->close();

        $query =   'UPDATE rso
                    SET NumofMembers = NumofMembers + 1
                    WHERE RSO_ID = ' . $rid;
                    
        if($update = $link->prepare($query)){
            $update->execute();
            $update->close();
    
        }
    }
?>