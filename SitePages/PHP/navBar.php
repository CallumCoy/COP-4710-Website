<?php
    echo
        `<ul class="topBar">
            <li><a href="">Home</a></li>
            <li><a href="Layout/EventMod.html">Events</a></li>
            <li><a href="Layout/ItemPage.html">RSC</a></li>
            <li><a href="">Schools</a></li>
        `;
            
        
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        echo
            `<li class="right"><a href="#"> Profile </a></li>
            <li class="right"><a href="PHP/LogOut.php"> logOut </a></li>
        </ul>`;
    } else{
        echo
            `<li class="right"><a onclick="openSignUp();" href="#"> Sign Up </a></li>
            <li class="right"><a onclick="openLogin();" href="#"> Login </a></li>
        </ul>`; 
    }
?>