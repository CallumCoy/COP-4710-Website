<?php
header("location: /PHPPage/EventListPage.php");
    session_start();
    require_once "PHPScript/config.php";
    include_once __DIR__ . '/PHPScript/SetCookies.php';
?>
<html>
    <head>
        <title>
            Events
        </title>
        <link href="CSS/Base.css" rel="stylesheet">
        <link href="CSS/SlideOutMenu.css" rel="stylesheet">
        <link href="CSS/SearchPage.css" rel="stylesheet">
        <link href="CSS/SignUp_Login.css" rel="stylesheet">
        <script src="JavaScript/map.js"></script><link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/EventMod.css" rel="stylesheet">
    </head>
    <div>

    </head>
    <body onload="getLocation();">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js">
        </script><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIY0b4bKUEcux9O822gFjvSwREmpGgJ1s"></script>
        <script src="JavaScript/map.js"></script>
        
        <?php require __DIR__ . '/PHPScript/overLay.php';?>

        <?php require __DIR__ . '/PHPScript/navBar.php';?>

        <div class="map">
            <div class="innerMap" id="map"></div>
        </div>
        
        
        <div class="eventList col-EventList">
            <div class="event">
                <div class="eventPicDiv">
                    <img src="Sources\Images\413977.jpg"  class="eventPic">
                </div>
                <div class="information">
                    <h3>Event Name</h3>
                    <div class="text">
                        desc:
                    </div>
                    <div class="startInfo"> Date: dd/mm/yy | Time: 1:50 PM</div>    
                </div>
            </div>
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
            document.getElementById("myNav").style.width = "280px";
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