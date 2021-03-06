<?php
session_start();
require_once '../PHPScript/config.php';
include_once '../PHPScript/IsLoggedIn.php';
include_once '../PHPScript/SetCookies.php';

include_once '../PHPScript/GetEventFromID.php';

    if(!isset($_GET['Event'])){
        header("location: ../index.php");
    } else {
        $eid = $_GET['Event'];
    }

?>
<html>
    <head>
        <title>
            <?php echo $eName; ?>
        </title>
        <link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/EventMod.css" rel="stylesheet">

        </head>
        
        <?php require '../PHPScript/navBar.php';?>

        <body onload="PreviewImage();">
        <div class="holder">
            <form action="/../PHPScript/UpdateEvent.php?eid=<?php echo $eid; ?>" method="post" enctype="multipart/form-data">

                
                <div class="section"> Pic </div>
                <div class="inputSec"> <input type="file" name="uploadImage" id="uploadImage" onchange="PreviewImage();" value="<?php echo $ePic; ?>"></div>
                <div class="picPreview">
                        <img src="<?php echo $ePic; ?>" id="uploadPreview"  class="eventPic" >
                </div>    
                <div class="break"></div>

                <div class="section"> Name: </div>
                <div class="inputSec"><input type="text" name="Name" id="Name" class="text" value="<?php echo $eName; ?>" required></div>
                <div class="break"> </div><!-- -->

                <div class="section"> Desc: </div>
                <div class="inputSec"><textarea name="Desc" id="Desc" class="bigTextBox" wrap="hard" value=""><?php echo $eDesc; ?></textarea></div>
                <div class="break"></div>

                <!--<div class="section"> Show Members </div>
                <div class="inputSec"> Yes <input type="radio" name="ShowMem" id="ShowMemY"> No<input type="radio" name="ShowMem" id="ShowMemN"></div>
                <div class="bigBreak"></div>
                <div class="section"> Official Group: </div>
                <div class="inputSec">
                    will say if the school has accepted them 
                </div> -->
                
                <?php
                    if($eHostRSO != NULL){

                        $admin = 0;
                        $query =   'SELECT 1
                        FROM events
                        WHERE EventID = ? && Host_RSO_ID = ?';

                        if($stmt = $link->prepare($query)){
                            $stmt->bind_param("ii", $eid, $eHostRSO);
                            $stmt->execute();
                            $stmt->store_result();
                            $admin = $stmt->num_rows();
                            $stmt->close();
                        }


                        $query =   'SELECT 1
                                    FROM admins
                                    WHERE RSO_ID = ? && UserID = ?';

                        if($stmt = $link->prepare($query) || $admin > 0){
                            if ($admin < 1){
                                $stmt->bind_param('ii', $eHostRSO, $_SESSION['id']);
                                $stmt->execute();
                                $stmt->store_result();
                            }

                            if($admin > 0 ||$stmt->num_rows() > 0 ){
                                echo   '<div class="break"></div>
                                        <div class="section"> Change Hosting User: 
                                        </div><div class="inputSec"></div><br>
                                        <select list="Members" name="uid" id="uid" class="text">
                                        <datalist id="Members">';
                                            
                                        $query = "  SELECT UserID
                                                    FROM members
                                                    WHERE RSO_ID = ?";

                                        if($stmt1 = $link->prepare($query)){
                                            $stmt1->bind_param('i', $eHostRSO);
                                            $stmt1->execute();
                                            $stmt1->bind_result($users);
                                            $stmt1->store_result();
                                            
                                            error_log($stmt1->num_rows());
                                            error_log($stmt1->error);

                                            while($stmt1->fetch()){
                                                $query = "  SELECT Email
                                                            FROM users
                                                            WHERE UserID = ?";
                                                
                                                if($stmt2 = $link->prepare($query)){

                                                    $stmt2->bind_param('i', $users);
                                                    $stmt2->execute();
                                                    $stmt2->bind_result($email);
                                                    $stmt2->store_result();
                                                    $stmt2->fetch();

                                                    
                                                    error_log("EMAIL " . $email);
                                                    error_log($stmt2->error);
                                                    
                                                    if ($_SESSION["id"] != $users){
                                                        echo '<option value="' . $users . '"> ' . $email . ' </option>';
                                                    } else {
                                                        echo '<option value="' . $users . '" seleceted> ' . $email . ' </option>';
                                                    }
                                                $stmt2->close();
                                                }
                                            }
                                        $stmt1->close();
                                        }
                            echo   '</datalist>
                            </select>
                            <div class="bigBreak"></div>';
                            }
                        }
                    }


                    $query =   'SELECT 1
                                FROM events
                                WHERE EventID = ? && Host_RSO_ID = ?';

                    if($stmt = $link->prepare($query)){
                        $stmt->bind_param("ii", $eid, $eHostRSO);
                        $stmt->execute();
                        $stmt->store_result();

                        if($stmt->num_rows() == 1){                                 

                                    echo   '<div class="break"></div>
                                            <div class="section"> Change Hosting RSO: </div>
                                            <div class="inputSec"></div><br>
                                            <select list="RSOs" name="rid" id="rid" class="text">
                                            <datalist id="RSOs">';
                                                
                                            $query = "  SELECT RSO_ID
                                                        FROM admins
                                                        WHERE UserID = ?";

                                            if($stmt1 = $link->prepare($query)){
                                                $stmt1->bind_param('i', $_SESSION['id']);
                                                $stmt1->execute();
                                                $stmt1->bind_result($rsoOption);
                                                $stmt1->store_result();
                                                
                                                error_log($stmt1->error);
                                                echo '<option value="' . NULL . '"> </option>';

                                                while($stmt1->fetch()){

                                                    $query = "  SELECT RSO_Name
                                                                FROM rso
                                                                WHERE RSO_ID = ?";
                                                    
                                                    if($stmt2 = $link->prepare($query)){

                                                        $stmt2->bind_param('i', $rsoOption);
                                                        $stmt2->execute();
                                                        $stmt2->bind_result($rsoNameOp);
                                                        $stmt2->store_result();
                                                        $stmt2->fetch();

                                                        
                                                        error_log($stmt2->error);
                                                        
                                                        if ($eHostRSO != $rsoNameOp){
                                                            echo '<option value="' . $rsoOption . '"> ' . $rsoNameOp . ' </option>';
                                                        } else {
                                                            echo '<option value="' . $rsoOption . '" seleceted> ' . $rsoNameOp . ' </option>';
                                                        }
                                                    $stmt2->close();
                                                    }
                                                }
                                                $stmt1->close();
                                            }
                                    echo   '</datalist>
                                            </select>
                                            <div class="bigBreak"></div>';
                        }
                    }
                    
                ?>
                <div class="break"></div>
                
                <div class="section"> Start Date: </div>
                <div class="inputSec"> <input type="date" name="StartDate" id="StartDate" value="<?php echo $eDate;?>" required> </div>
                
                <div class="section"> Start Time: </div><div class="inputSec"></div>
                
                    <select name="StartHours" required>
                        <?php 
                            for ($i=1; $i < 13; $i++) { 
                                if ($i == $eHour) {
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                } else {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                            }
                        ?>
                    </select>
                    <select name="StartMinute" value="<?php echo $eMin;?>" id="" required>
                        <?php
                            for ($i=0; $i < 60; $i = $i + 15) { 
                                if ($i == 0) {
                                    $i = "00";
                                }
                                if ($i == $eMin) {
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                } else {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                            }
                        ?>
                    </select>
                    <select name="StartClockSide" required>
                        <?php
                            if ($eSide == "AM") {  
                                echo'<option value="AM" selected>AM</option>
                                     <option value="PM">PM</option>';
                            } else {
                                echo'<option value="AM">AM</option>
                                     <option value="PM" selected>PM</option>';
                            }
                        ?>
                    </select>

                <div class="section"> Location for meetings </div>
                <div class="break"></div>
                <div class="section"> </div>
                <div class="section"> Lat </div>
                <div class="inputSec"><input type="number" step="0.05" name="Lat" id="Lat" value="<?php echo $eLat;?>" min="-90" max="90" class="text" required></div>
                <div class="section"> Long: </div>
                <div class="inputSec"><input type="number" step="0.05" name="Long" id="Long" value="<?php echo $eLong;?>" min="-180" max="180" class="text" required></div>
                <div class="break"></div>
                <div class="section"> </div>
                <div class="section"> Building: </div>
                <div class="inputSec"><input type="text" name="Building" id="Building" value="<?php echo $eBuild;?>" class="text"></div>
                <div class="section"> Floor: </div>
                <div class="inputSec"><input type="number" name="Floor" id="Floor" value="<?php echo $eFloor;?>" class="text"></div>
                <div class="section"> Room: </div>
                <div class="inputSec"><input type="text" name="Room" id="Room" value="<?php echo $eRoom ;?>" class="text"></div>
                <div class="inputSec"><input type="hidden" name="eid" id="eid" class="text" value="<?php echo ($eid);?>"></div>
                <div class="inputSec"><input type="hidden" name="oPic" id="oPic" class="text" value="<?php echo ($ePic);?>"></div>
                <input type="hidden" name="Type"  id="Type" class="text" value="<?php echo ($eType);?>">
                <br>
                <input type="submit" value="create"> 
            </form>
        </div>
    </body>
    <script>
        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            };
        };
    </script>
</html>