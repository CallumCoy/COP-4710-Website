<?php
    echo '<ul class="topBar"> 
    <li><a href="../index.php">Home</a></li>
    <li><a href="../PHPPage/EventListPage.php">Events</a></li>
    <li><a href="../PHPPage/LoadMyRSO.php">RSC</a></li>
    <li><a href="../PHPPage/LoadSchool.php">School</a></li>
    ';

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        echo '<li class="right"><a href="#"> Profile </a></li>
        <li class="right"><a href="/PHPScript/LogOut.php"> logOut </a></li>
        </ul>';
    } else{
        echo '<li class="right"><a onclick="openSignUp();" href="#"> Sign Up </a></li>
        <li class="right"><a onclick="openLogin();" href="#"> Login </a></li>
        </ul>';
    }
?>