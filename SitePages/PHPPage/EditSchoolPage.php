<?php
session_start();
require_once '../PHPScript/config.php';
include_once '../PHPScript/IsLoggedIn.php';
include_once '../PHPScript/SetCookies.php';

include_once '../PHPScript/GetEventFromID.php';

include '../PHPScript/AreTheyAdmin.php';
error_log($_GET['sid']. " $admin ");
    if(!isset($_GET['sid']) || $admin < 2){
        header("location: ../index.php");
    } elseif($sid == 0) {
        $sid = NULL;
    }else{
        $sid = $_GET['sid'];
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
            <form action="/../PHPScript/UpdateSchool.php?sid=<?php echo $sid; ?>" method="post" enctype="multipart/form-data">

                
                <div class="section"> Pic </div>
                <div class="inputSec"> <input type="file" name="uploadImage" id="uploadImage" onchange="PreviewImage();" value="<?php echo $ePic; ?>"></div>
                <div class="picPreview">
                        <img src="../sources/<?php echo $ePic; ?>" id="uploadPreview"  class="eventPic" >
                </div>    
                <div class="break"></div>

                <div class="section"> Name: </div>
                <div class="inputSec"><input type="text" name="Name" id="Name" class="text" value="<?php echo $eName; ?>" required></div>
                <div class="break"> </div><!-- -->

                <div class="section"> Desc: </div>
                <div class="inputSec"><textarea name="Desc" id="Desc" class="bigTextBox" wrap="hard" value=""><?php echo $eDesc; ?></textarea></div>
                <div class="break"></div>

                <?php
                    if (!isset($emailExt)){
                        echo   '<div class="section"> Email Extension: </div>
                                <div class="inputSec"><input type="text" name="EmailExt" id="EmailExt" class="text" value="" pattern="@[A-Za-z0-9]{1,}.[A-Za-z0-9.-]{2,} " required></div>
                                <div class="break"></div>';
                    } else {
                        echo   '<div class="section"> Email Extension: </div>
                                <div class="inputSec"><input type="text" name="EmailExt" id="EmailExt" class="text" value="' . $emailExt . '" readonly</div>
                                <div class="break"></div>';
                    }
                ?>
                <div class="section"> School Location </div>
                <div class="break"></div>
                <div class="section"> </div>
                <div class="section"> Lat </div>
                <div class="inputSec"><input type="number" name="Lat" id="Lat" min="-90" max="90" class="text"></div>
                <div class="section"> Long: </div>
                <div class="inputSec"><input type="number" name="Long" id="Long" min="-180" max="180" class="text"></div>
                <div class="break"></div>
                <div class="section"> </div>
                <div class="inputSec"><input type="hidden" name="eid" id="eid" class="text" value="<?php echo ($sid);?>"</div>
                <br>

                <?php
                    if (!isset($emailExt)){
                        echo   '<input type="submit" value="create">';
                    } else {
                        echo   '<input type="submit" value="edit">';
                    }
                ?>

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