<?php

    $query =   'INSERT INTO students
                VALUES (' . $sid . ', ' . $uid . ')';
                
    if ($update = $link->prepare($query)){
        $update->execute();
        $update->close();

        $query =   'UPDATE school
                    SET NumOfStudents = NumOfStudents + 1
                    WHERE SchoolID = ' . $sid;
                    
        if($update = $link->prepare($query)){
            $update->execute();
            $update->close();
    
        }
    }
?>