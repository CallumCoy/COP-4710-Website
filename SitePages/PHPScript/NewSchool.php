<?php
    $query =   'SELECT UserID, Email
                FROM users
                WHERE SchoolID = NULL';
    
    if($stmt = $link->prepare($query)){
        $stmt->execute();
        $stmt->bind_result($uid, $email);
        $stmt->store_result();
        
        while($stmt->fetch()){
            if(strpos($email,$emailExt)){
                $query =   'UPDATE users
                            SET SchoolID = ' . $sid . '
                            WHERE UserID = ' . $uid;
                            
                if($update = $link->prepare($query)){
                    $update->execute();
                    $update->close();
                
                    $query =   'INSERT INTO student
                                VALUES ('. $uid .'' . $sid . ')';
                                
                    if($update = $link->prepare($query)){
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
                }
            }
        }
        $stmt->close();
    }
?>