<?php
include_once __DIR__ . '/../PHPScript/isLoggedIn';
    $RSO_Val = $_GET['name'];
    session_start();
    if ($RSO_Val != null){
        include_once __DIR__ . '/../PHPScript/checkPrios';
        include_once __DIR__ . '/../PHPScript/getRSOInfo';
    } else {
        $desc = "";
        $pic = "";
    }
?>
<html>
    <head>
        <title>
            <?php $RSO_Val?>
        </title>

        
        <?php require __DIR__ . '/PHP/navBar.php';?>

        <body onload="PreviewImage();">
        <div class="holder">
            <form action="">

                <div class="section"> Pic </div>
                <div class="inputSec"> <input type="file" name="myPhoto" id="uploadImage" onchange="PreviewImage();"></div>
                <div class="picPreview">
                        <img src="..\Sources\Images\2019-10-25 15_47_10-【Electro】Monstaz. - Popcorn Funk - YouTube.png" id="uploadPreview" alt="Space" class="eventPic" >
                </div>    
                <div class="break"></div>

                <div class="section"> Name: </div>
                <div class="inputSec"><input type="text" name="Name" id="Name" class="text" required></div>
                <div class="break"> </div>

                <div class="section"> Desc: </div>
                <div class="inputSec"><textarea name="Desc" id="Desc" class="bigTextBox" wrap="hard"></textarea></div>
                <div class="break"></div>

                <div class="section"> Show Members </div>
                <div class="inputSec"> Yes <input type="radio" name="ShowMem" id="ShowMemY"> No<input type="radio" name="ShowMem" id="ShowMemN"></div>
                <div class="bigBreak"></div>
                <div class="section"> Official Group: </div>
                <div class="inputSec">
                    <!-- will say if the school has accepted them -->
                </div>
                
                <div class="break"></div>
                <div class="section"> Change Admin: </div>
                <div class="inputSec"></div>
                    <input list="Members" name="Admin" id="Admin" class="text">
                    <datalist id="Members">
                        <option value="Tom"></option>
                    </datalist>
                <div class="bigBreak"></div>

                <div class="section"> Location for meetings </div>
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