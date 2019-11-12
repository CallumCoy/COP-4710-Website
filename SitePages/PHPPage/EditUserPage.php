<?php
    session_start();
    require_once '../PHPScript/config.php';
    include_once '../PHPScript/IsLoggedIn.php';
    include_once '../PHPScript/SetCookies.php';

        $query = "  SELECT Username, ProfilePic, Email, Bio
                    FROM users
                    WHERE UserID = ?";

        if ($stmt = $link->prepare($query)){
            $stmt->bind_param("i", $_SESSION["id"]);
            $stmt->execute();
            $stmt->bind_result($uName, $uPic, $UEmail, $uBio);
            $stmt->store_result();
            $stmt->fetch();
            $stmt->close();
        } 

?>
<html>
    <head>
        <title>
            <?php echo $uName; ?>
        </title>
        <link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/EventMod.css" rel="stylesheet">

        </head>
        
        <?php require '../PHPScript/navBar.php';?>

        <body onload="PreviewImage();">
        <div class="holder">
            <form action="/../PHPScript/UpdateUser.php"  method="post" enctype="multipart/form-data">

                <div class="section"> Pic </div>
                <div class="inputSec"> <input type="file" name="uploadImage" id="uploadImage" onchange="PreviewImage();" value="<?php echo $uPic; ?>"></div>
                <div class="picPreview">
                        <img src="<?php echo $uPic; ?>" id="uploadPreview"  class="eventPic" >
                </div>    
                <div class="break"></div>

                <div class="section"> Email: </div>
                <div class="inputSec"><input type="text" name="Email" id="Email" class="text" value="<?php echo $UEmail; ?>" readonly></div>
                <div class="break"> </div><!-- -->

                <div class="section"> Name: </div>
                <div class="inputSec"><input type="text" name="Name" id="Name" class="text" value="<?php echo $uName; ?>" required></div>
                <div class="break"> </div><!-- -->

                <div class="section"> Desc: </div>
                <div class="inputSec"><textarea name="Desc" id="Desc" class="bigTextBox" wrap="hard" value=""><?php echo $uBio; ?></textarea></div>
                <div class="break"></div>

                <div class="inputSec"><input type="hidden" name="uid" id="uid" class="text" value="<?php echo ($_SESSION['sid']);?>"></div>
                <div class="inputSec"><input type="hidden" name="oPic" id="oPic" class="text" value="<?php echo ($uPic);?>"></div>
                
                <input type="submit" value="Update"> 
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