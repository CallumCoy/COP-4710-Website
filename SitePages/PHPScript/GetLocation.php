<?php 
    $long = $lat = $building = $floor = $room = '';

    $query =   'SELECT *
                FROM locations
                WHERE locID = ?';

    if($stmt = $link->prepare($query)){
        erro_log("location id is $eLocID");
        $stmt->bind_param("i", $eLocID);
        $stmt->execute();
        $stmt->bind_result($t, $long, $lat, $building, $floor, $room);
        $stmt->store_result();
        $stmt->close();
    }
?>