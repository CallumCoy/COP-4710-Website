<?php

    if(strpos($email,$emailExt)){
        $query =   'UPDATE members
                    SET RSO_ID = ' . $rid . '
                    WHERE UserID = ' . $uid;
                    
        if ($update = $link->prepare($query)){
            $update->execute();
            $update->close();

            $query =   'UPDATE rso
                        SET NumofMembers = NumOfMembers + 1
                        WHERE RSO_ID = ' . $rid;
                        
            if($update = $link->prepare($query)){
                $update->execute();
                $update->close();
        
            }
        }
    }
?>