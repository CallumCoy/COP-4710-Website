<?php
    include_once '../PHPScript/IsLoggedIn.php';

    $uid = $name = $desc = $pic = $error = "";

    $uid = trim($_POST["uid"]);
    $name = trim($_POST["Name"]);
    $desc = trim($_POST["Desc"]);

    include '../PHPScript/SetUpPicture.php';
    
    require_once "config.php";

    #does this data already exist?

    session_start();

    $query = "  SELECT RSO_ID
                FROM rso
                WHERE RSO_Name = ? and SchoolID = ?";

    if($stmt = $link->prepare($query)){
        $stmt->bind_param("si", $name, $_SESSION["sid"]);
        $stmt->execute();
        $stmt->bind_result($RSOVal);
        $stmt->store_result();
        $stmt->fetch();

        error_log("RSO number = " . $RSOVal);

        if($stmt->num_rows() == 1){
            error_Log("1 row");

            include_once '../PHPScript/checkPrios.php';

            $query = "  UPDATE rso
                        SET RSO_ProfPic = ?, RSO_Desc = ?
                        WHERE RSO_ID = ?";

        error_log("RSO number = " . $RSOVal);
            if($stmt2 = $link->prepare($query)){
                $stmt2->bind_param("ssi", $pic, $desc, $RSOVal);
                error_log("file updated? Error: " . $stmt2->error);
                error_log("file updated? Error: " . $pic);
                error_log("file updated? Error: " . $desc);
                $stmt2->execute();

                $stmt2->close();
            }

            if($uid != $_SESSION["id"] && $uid != NULL){

                $query = "  UPDATE admins
                            SET UserID = ?
                            WHERE UserID = ? AND RSO_ID = ?";

                if($stmt2 = $link->prepare($query)){
                    $stmt2->bind_param("iii", $uid, $_SESSION["id"], $RSOVal);
                    $stmt2->execute();
                    error_log("Admin reset? Error: " . $stmt2->error);

                    $stmt2->close();
                }
            }

        } elseif ($stmt->num_rows() == 0){
            $query =   "INSERT INTO rso
                        VALUES (default, ?,?,'1',?,?,?)";
            
            error_Log("0 rows");
            if($stmt2 = $link->prepare($query)){
                error_Log($_SESSION["sid"] . " " . $_SESSION["id"]);
                error_Log($stmt2->bind_param("ssssi", $name, date('Y-m-d'), $desc, $pic, $_SESSION["sid"]));
                error_Log($stmt2->execute());
                error_log("RSO created? Error: " . $stmt2->error);

                $stmt2->close();
            }

            
            $stmt->execute();
            $stmt->bind_result($RSOVal);
            $stmt->store_result();
            $stmt->fetch();

            $query =   "INSERT INTO admins
                        VALUES (?,?)";
                        
            error_log("RSO number = " . $RSOVal);

            if($stmt2 = $link->prepare($query)){
                error_Log($stmt2->bind_param("ii", $_SESSION["id"], $RSOVal));
                error_Log($stmt2->execute());
                error_log("Admin set? Error: " . $stmt2->error);
            }

            $query =   "INSERT INTO members
                        VALUES (?,?)";
                        
            if($stmt2 = $link->prepare($query)){
                error_Log($stmt2->bind_param("ii", $_SESSION["id"], $RSOVal));
                error_Log($stmt2->execute());
                error_log("member set? Error: " . $stmt2->error);
            }

        } else {
            $error = "something really bad happened somewhere";
        }
        $stmt->close();
    }
    $link->close();
    
    header("location: /../index.php?error=". $error);#send yopu to your new RSO in future
?>