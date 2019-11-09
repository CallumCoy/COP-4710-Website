<?php
    $query =   'SELECT SchoolID
                FROM rso
                WHERE RSO_ID = ?';

    if($stmt = $link->prepare($query)){
        $stmt->bind_param('i', $rid);
        $stmt->execute();
        $stmt->bind_result($school);
        $stmt->store_result();
        $stmt->fetch();

        if($school == $_SESSION['sid']) {

            $query =   'INSERT INTO memebrs
                        VALUES (?, ?)';
            
            if($signUp = $link->prepare($query)){
                $signUp->bind_param('ii', $uid, $rid);
                $signUp->execute();
                $signUp->close();
            }
        }
        $stmt->close();
    }
?>