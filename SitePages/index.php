<!DOCTYPE html>
<html>
    <head>
        <title>
            Events
        </title>
        <link href="CSS/Base.css" rel="stylesheet">
        <link href="CSS/SlideOutMenu.css" rel="stylesheet">
        <link href="CSS/SearchPage.css" rel="stylesheet">
    </head>
    <body>
        
        <span style="font-size:35px;cursor:pointer" onclick="openNav()"> > </span>
        <?php
        
        <div id="myNav" class="overlay">
           <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
           <div class="overlay-content">
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
           </div>
        </div>
        ?>
        <ul class="topBar">
            <li><a href="">Home</a></li>
            <li><a href="">Events</a></li>
            <li><a href="">RSC</a></li>
            <li><a href="">Schools</a></li>

            <li class="right"><a href="">LogOut</a></li>
            <li class="right"><a href="">Profile</a></li>
        </ul>
        
        
        <div class="map">
        </div>
        
        
        <div class="eventList col-EventList">
            <div class="event">
                <div class="eventPicDiv">
                    <img src="Sources\Images\413977.jpg" alt="Space" class="eventPic">
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
        

        <script>
            function openNav() {
            document.getElementById("myNav").style.width = "250px";
            }

            function closeNav() {
            document.getElementById("myNav").style.width = "0%";
            }
        </script>

    </body>
</html>