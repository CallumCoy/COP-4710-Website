<?php
    $query =   'UPDATE school
                SET NumOfRSOs = NumOfRSOs + 1
                WHERE SchoolID = ' . $sid;
                
    if($update = $link->prepare($query)){
        $update->execute();
        $update->close();
    }
?>