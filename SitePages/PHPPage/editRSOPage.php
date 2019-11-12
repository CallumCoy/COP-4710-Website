<?php
session_start();
include_once '../PHPScript/IsLoggedIn.php';
include_once '../PHPScript/SetCookies.php';
require_once '../PHPScript/config.php';

error_log("num of gets " . count($_GET));

$orName = $desc = $pic = $num = $sid = $error = "";
$rID = 0;

    if(isset($_GET['name'])){
        $name = $_GET['name'];
    }
    if(isset($_GET['desc'])){
        $desc = $_GET['desc'];
    }
    if(isset($_GET['rID'])){
        $rID = $_GET['rID'];
    }

    if(isset($_GET['RSO'])){
        $rID = $_GET['RSO'];
    }

    if ($rID == 0){

        $query = "  SELECT RSO_ID
                    FROM rso
                    WHERE (RSO_Name = ?) && SchoolID = ?";

        if ($stmt = $link->prepare($query)){
            $stmt->bind_param("si", $name, $_SESSION["sid"]);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->store_result();
            $stmt->fetch();
            $stmt->close();

            error_log($id);
            $RSOVal = $id;
            include_once '../PHPScript/checkPrios.php';
            
        } 
    } else {
        include "../PHPScript/getRSOImproved.php";
    }

?>
<html>
    <head>
        <title>
            <?php echo $name; ?>
        </title>
        <link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/EventMod.css" rel="stylesheet">

        </head>
        
        <?php require '../PHPScript/navBar.php';?>

        <body onload="PreviewImage();">
        <div class="holder">
            <form action="/../PHPScript/UpdateRSO.php" method="post" enctype="multipart/form-data">

                <div class="section"> Pic </div>
                <div class="inputSec"> <input type="file" name="uploadImage" id="uploadImage" onchange="PreviewImage();" value="<?php echo $pic; ?>"></div>
                <div class="picPreview">
                        <img src="../sources/<?php echo $pic; ?>" id="uploadPreview"  class="eventPic" >
                </div>    
                <div class="break"></div>

                <div class="section"> Name: </div>
                <div class="inputSec"><input type="text" name="Name" id="Name" class="text" value="<?php echo $orName; ?>" required></div>
                <div class="break"> </div><!-- -->

                <div class="section"> Desc: </div>
                <div class="inputSec"><textarea name="Desc" id="Desc" class="bigTextBox" wrap="hard" value=""><?php echo $desc; ?></textarea></div>
                <div class="break"></div>

                <!--<div class="section"> Show Members </div>
                <div class="inputSec"> Yes <input type="radio" name="ShowMem" id="ShowMemY"> No<input type="radio" name="ShowMem" id="ShowMemN"></div>
                <div class="bigBreak"></div>
                <div class="section"> Official Group: </div>
                <div class="inputSec">
                    will say if the school has accepted them 
                </div> -->
                
                <div class="break"></div>
                <div class="section"> Change Admin: </div>
                <div class="inputSec"></div>
                    <select list="Members" name="uid" id="uid" class="text">
                    <datalist id="Members">
                        <?php

                            $query = "  SELECT UserID
                                        FROM members
                                        WHERE RSO_ID = ?";

                            if($stmt = $link->prepare($query)){
                                $stmt->bind_param('i', $id);
                                $stmt->execute();
                                $stmt->bind_result($users);
                                $stmt->store_result();
                                
                                error_log($stmt->num_rows());
                                error_log($stmt->error);

                                while($stmt->fetch()){
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
                                        
                                        if ($_SESSION["id"] != $uid){
                                            echo '<option value="' . $users . '"> ' . $email . ' </option>';
                                        } else {
                                            echo '<option value="' . $users . '" seleceted> ' . $email . ' </option>';
                                        }
                                       $stmt2->close();
                                    }
                                }
                              $stmt->close();
                            }
                            $link->close();
                        ?>    
                    </datalist>
                    </select>
                <div class="bigBreak"></div>

                <!--<div class="section"> Location for meetings </div>
                <div class="break"></div>
                <div class="section"> </div>
                <div class="section"> Lat </div>
                <div class="inputSec"><input type="number" name="Lat" id="Lat" min="-90" max="90" class="text"></div>
                <div class="section"> Long: </div>
                <div class="inputSec"><input type="number" name="Long" id="Long" min="-180" max="180" class="text"></div>
                <div class="break"></div>
                <div class="section"> </div>
                <div class="section"> Building: </div>
                <div class="inputSec"><input type="text" name="Building" id="Building" class="text"></div>
                <div class="section"> Floor: </div>
                <div class="inputSec"><input type="number" name="Floor" id="Floor" class="text"></div>
                <div class="section"> Room: </div>
                <div class="inputSec"><input type="text" name="Room" id="Room" class="text"></div>
                -->
                <div class="inputSec"><input type="hidden" name="oPic" id="oPic" class="text" value="<?php echo ($pic);?>"></div>
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