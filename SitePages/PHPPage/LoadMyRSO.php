<?php
    session_start();
    include_once '../PHPScript/SetCookies.php';
    require_once "config.php";
    $type = 'RSO';

    if (isset($_GET["level"])){
        $level = $_GET["level"];
        if($level == 'admin'){
            $command = 'href="../PHPScript/getRSOInfo.php?RSO=';#TODO
        } else {
            $command = 'href="../PHPPage/LoadRSOPage.php?RSO=';
        }
    }

    $error = "";
?>

<html>
    <head>
        <title>
            Events
        </title>
        <link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/SlideOutMenu.css" rel="stylesheet">
        <link href="../CSS/SearchPage.css" rel="stylesheet">
        <link href="../CSS/SignUp_Login.css" rel="stylesheet">
        <link href="../CSS/EventMod.css" rel="stylesheet">
        <script src="../JavaScript/map.js"></script><link href="../CSS/Base.css" rel="stylesheet">
    </head>
    <div>

    </head>
    <body onload="getLocation();">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js">
        </script><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIY0b4bKUEcux9O822gFjvSwREmpGgJ1s"></script>
        <script src="JavaScript/map.js"></script>
        
        <?php require '../PHPScript/overLay.php';?>

        <?php require '../PHPScript/navBar.php';?>

        <div class="map">
            <div class="innerMap" id="map"></div>
        </div>
        
        <div class="eventList col-EventList">

<?php
    require_once "../PHPScript/config.php";

    $query = "SELECT RSO_ID 
              FROM " . $level . "
              WHERE UserID = ?";

    if  ($stmt = $link->prepare($query)){
        
        $stmt->bind_param("i", $_SESSION["id"]);
        $stmt->bind_result($RSO);

        $stmt->execute();
        $stmt->store_result();
        error_log("num of rows " . $stmt->num_rows() . " " .  $_SESSION["id"]);
        error_log("is there any groups? Error: " . $RSO);

        while ($stmt->fetch()){
            $query = "SELECT RSO_Name, RSO_Desc, RSO_ProfPic, NumofMembers
                      FROM rso
                      WHERE RSO_ID = ?";

            if ($stmt2 = $link->prepare($query)){

                $stmt2->bind_param('i', $RSO);
                $stmt2->bind_result($name, $desc, $pic, $num);
                $stmt2->execute();
                $stmt->store_result();

                error_log("num of rows " . $stmt2->num_rows());
                error_log("which groups? Error: " . $stmt2->error);

                while($stmt2->fetch()){
                    if($num < 5){
                        echo   '<a '. $command . $RSO . '"> <div class="event" >
                                    <div class="eventPicDiv">
                                        <img src="' . $pic . '" alt="Space" class="eventPic">
                                    </div>
                                    <div class="information">
                                        <h3>' . $name .'</h3>
                                        <div class="text">
                                            desc: ' . $desc .'
                                        </div>  
                                    </div>
                                </div> </a>';
                    } else {
                        echo   '<a '. $command . $RSO .'> <div class="event" >
                                <div class="event">
                                    <div class="eventPicDiv">
                                        <img src="' . $pic . '" alt="Space" class="eventPic">
                                    </div>
                                    <div class="information">
                                        <h3>' . $name .'</h3>
                                        <div class="text">
                                            desc: ' . $desc .'
                                        </div>  
                                    </div>
                                </div> </a>';
                    }
                }
                $stmt2->close();    
            }
        }
        $stmt->close();
    }
    $link->close();
?>


        </div>
        <!-- hiding forms below-->
        <div id="login" class="popup">
            <form action="/PHPScript/LogIn.php" method="post">
                <h1> Login </h1>
    
                <label for="email">Email<br></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>
                
                <label for="password"><br>Password</br></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>
    
                <br>
                <button type="submit" class="btn">Login</button>
                <button type="button" class="btn cancel" onclick="closeThem()">Close</button>
                <div class="errBox">
                    <?php
                        if (!empty($err))
                    ?>
                </div>
            </form>
        </div>
            
        <div id="signUp" class="popup">
            <form action="/PHPScript/SignUp.php" method="post">
                <h1> Sign Up </h1>
    
                <label for="email">Email<br></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>
    
                <label for="name"><br>Name</br></label>
                <input type="text" placeholder="Enter name" name="name" id="name" required>
                
                <label for="password"><br>Password</br></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" minlength="8" required>
    
                <label for="passwordCheck"><br>Password Confirm</br></label>
                <input type="password" placeholder="Enter Password" name="passwordCheck" id="passwordCheck" minlength="8" required>
    
                <br>
                <button type="submit" class="btn">Sign Up</button>
                <button type="button" class="btn cancel" onclick="closeThem();">Close</button>
            </form>
        </div>

        <div class="greyout" id="greyscreen" onclick="closeThem(); "> </div>

        <script>
            function openNav() {
            document.getElementById("myNav").style.width = "250px";
            }

            function closeNav() {
            document.getElementById("myNav").style.width = "0%";
            }

            function openSignUp(){
                document.getElementById("login").style.display = "none";
                document.getElementById("signUp").style.display = "block";
                document.getElementById("greyscreen").style.display = "block";
            }

            function openLogin(){
                document.getElementById("signUp").style.display = "none";
                document.getElementById("login").style.display = "block";
                document.getElementById("greyscreen").style.display = "block";
            }

            //closes greyScreen, Login and signUp
            function closeThem(){
                document.getElementById("login").style.display = "none";
                document.getElementById("signUp").style.display = "none";
                document.getElementById("greyscreen").style.display = "none";
            }
        </script>

    </body>
</html>