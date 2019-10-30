<?php
    echo '<datalist id=RSOs>';

    $error = "";

    require_once "config.php";
    session_start();

    # get the id of the school the user is attending
    $query = '  SELECT SchoolID
                FROM students
                WHERE UserID = ?';

    if($stmt = $link->prepare($query)){

        $stmt->bind_param($_SESSION['id']);
        $stmt->execute();
        $stmt->bind_result($Sid);
    }

    $stmt->close();

    $query = '  SELECT RSO_Name
                FROM rso
                WHERE SchoolID = ?';

    if($stmt = $link->prepare($query)){

        $stmt->bind_param($Sid);
        $stmt->execute();
        $stmt->bind_result($club);

        while($stmt2->fetch()){
            echo '<option value="' . $club . '">';
        }
    }

    echo '</datalist>';
?>