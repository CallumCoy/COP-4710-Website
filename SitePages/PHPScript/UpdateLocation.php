<?php
    error_log("location update happening here ");
    $query =   'SELECT locID
                FROM locations
                WHERE longitude = ? && latitude = ? && Building = ? && floorNum = ? && Room = ?';
    
    if($check = $link->prepare($query)){
        
        $check->bind_param('ddsis', $Long, $Lat, $Building, $Floor, $Room);
        $check->execute();
        $check->bind_result($lid);
        $check->store_result();

        if($check->num_rows() < 1){

            $query =   'INSERT INTO locations
                        VALUES (default, ?, ?, ?, ?, ?)';

            if($input = $link->prepare($query)){

                $input->bind_param('ddsis', $Long, $Lat, $Building, $Floor, $Room);
                error_log("$Long, $Lat, $Building, $Floor, $Room");
                $input->execute();
                error_log("location update happening here $input->error");
                $input->close();

                
                $check->execute();
                $check->bind_result($lid);
            }
        }
        $check->fetch();
        $check->close();
    }
    error_log("location update happening here $query $link->error");
?>