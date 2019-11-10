<?php
    $query =   'SELECT 1
                FROM student
                WHERE UserID = ?';

    if($stmt = $link->prepare($query)){
        $stmt->bind_param('i', $uid);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows() == 0) {

            $query =   'INSERT INTO students
                        VALUES (?, ?)';
            
            if($signUp = $link->prepare($query)){
                $signUp->bind_param('ii', $uid, $sid);
                $signUp->execute();
                $signUp->close();
            }
        }
        $stmt->close();
        include "../PHPScript/NewStudent.php";
    }
?>