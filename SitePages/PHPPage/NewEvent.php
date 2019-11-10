<?php
session_start();
require_once '../PHPScript/config.php';
include_once '../PHPScript/IsLoggedIn.php';
include_once '../PHPScript/SetCookies.php';

include_once '../PHPScript/GetEventFromID.php';

    $eid = 0;
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
            <form action="/../PHPScript/UpdateEvent.php?eid=<?php echo $eid; ?>" type="post">

                
                <div class="section"> Pic </div>
                <div class="inputSec"> <input type="file" name="myPhoto" id="uploadImage" onchange="PreviewImage();" value="<?php echo $ePic; ?>"></div>
                <div class="picPreview">
                        <img src="../sources/<?php echo $ePic; ?>" id="uploadPreview" alt="Space" class="eventPic" >
                </div>    
                <div class="break"></div>

                <div class="section"> Name: </div>
                <div class="inputSec"><input type="text" name="Name" id="Name" class="text" value="<?php echo $eName; ?>" required></div>
                <div class="break"> </div><!-- -->

                <div class="section"> Desc: </div>
                <div class="inputSec"><textarea name="Desc" id="Desc" class="bigTextBox" wrap="hard" value=""><?php echo $eDesc; ?></textarea></div>
                <div class="break"></div>

                <div class="section"> Invite Type: </div>
                <div class="inputSec">
                    <select name="Type"  id="Type" class="text">
                        <option value="0">Public</option>
                        <option value="1">School Wide</option>
                        <option value="2">Club Only</option>
                    </select>
                </div>
                <div class="break"></div>


                <!--<div class="section"> Show Members </div>
                <div class="inputSec"> Yes <input type="radio" name="ShowMem" id="ShowMemY"> No<input type="radio" name="ShowMem" id="ShowMemN"></div>
                <div class="bigBreak"></div>
                <div class="section"> Official Group: </div>
                <div class="inputSec">
                    will say if the school has accepted them 
                </div> -->
                
                <?php
                    
                    
                    echo   '<div class="break"></div>
                           <div class="inputSec"></div>
                           <br>
                           <div class="inputSec"> 
                            <input type="hidden" name="uid" id="uid" class="text" value="' . $_SESSION['id'] . '">
                            </div>
                           <div class="break"></div>';
                   
                    


                    $query =   'SELECT 1
                                FROM admins
                                WHERE UserID = ?';

                    if($stmt = $link->prepare($query)){
                        $stmt->bind_param("i", $_SESSION['id']);
                        $stmt->execute();
                        $stmt->store_result();

                        if($stmt->num_rows() > 0){                                 
                            $first = 1;
                            
                        $query = "  SELECT RSO_ID
                                    FROM admins
                                    WHERE UserID = ?";

                            if($stmt1 = $link->prepare($query)){
                                $stmt1->bind_param('i', $_SESSION['id']);
                                $stmt1->execute();
                                $stmt1->bind_result($rsoOption);
                                $stmt1->store_result();
                                
                                error_log($stmt1->error);

                                while($stmt1->fetch()){

                                    $query = "  SELECT RSO_Name, NumofMembers
                                                FROM rso
                                                WHERE RSO_ID = ?";
                                    
                                    if($stmt2 = $link->prepare($query)){

                                        $stmt2->bind_param('i', $rsoOption);
                                        $stmt2->execute();
                                        $stmt2->bind_result($rsoNameOp, $mem);
                                        $stmt2->store_result();
                                        $stmt2->fetch();

                                        
                                        error_log($stmt2->error);
                                        
                                        if ($first == 1 && $mem > 4){
                                            echo   '<div class="break"></div>
                                                    <div class="section"> Change Hosting RSO: </div>
                                                    <div class="inputSec"></div><br>
                                                    <select list="RSOs" name="rid" id="rid" class="text">
                                                    <datalist id="RSOs">';
                                            echo '<option value=""> Yourself </option>';
                                            echo '<option value="' . $rsoOption . '"> ' . $rsoNameOp . ' </option>';
                                        } elseif( $mem > 4){
                                            echo '<option value="' . $rsoOption . '"> ' . $rsoNameOp . ' </option>';
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

                
                <div class="section"> Start Date: </div>
                <div class="inputSec"> <input type="date" name="StartDate" id="StartDate" required> </div>
                
                <div class="section"> Start Time: </div><div class="inputSec"></div>
                
                <select name="StartHours" required>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12" selected>12</option>
                    </select>
                    <select name="StartMinute" id="" required>
                        <option value="00" selected>00</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                    </select>
                    <select name="StartClockSide" required>
                        <option value="AM">AM</option>
                        <option value="PM" selected>PM</option>
                    </select>

                <div class="section"> Location for Event </div>
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
                <div class="inputSec"><input type="hidden" name="eid" id="eid" class="text" value="<?php echo ($eid);?>"</div>
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