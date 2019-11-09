<?php
    error_log("hi");
    echo '<datalist id=RSOs>';

    $error = "";

    require_once "config.php";
    $query = '  SELECT RSO_Name
                FROM rso
                WHERE SchoolID = ?
                ORDER BY RSO_Name';

    if($stmt2 = $link->prepare($query)){

        $stmt2->bind_param("i", $_SESSION["sid"]);
        $stmt2->execute();
        $stmt2->bind_result($club);

        while($stmt2->fetch()){
            echo '<option value="' . $club . '">';
        }
        $stmt2->close();
    }


    echo '</datalist>';
?>