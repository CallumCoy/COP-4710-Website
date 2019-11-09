<?php
    error_log("hi");
    echo '<datalist id=Schools>';

    echo '<option value="' . NULL . '"> </option>';
    $error = "";

    require_once "config.php";
    $query = '  SELECT SchoolID, SchoolName
                FROM school';

    if($stmt2 = $link->prepare($query)){

        $stmt2->execute();
        $stmt2->bind_result($id, $school);

        while($stmt2->fetch()){
            echo '<option value="' . $id . '"> ' . $school . '</option>';
        }
        $stmt2->close();
    }


    echo '</datalist>';
?>