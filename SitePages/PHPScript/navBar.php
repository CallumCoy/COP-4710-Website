<?php
    echo '<ul class="topBar"> 
    <li><a href="../index.php">Home</a></li>
    <li><a href="../PHPPage/EventListPage.php">Events</a></li>
    <li><a href="../PHPPage/LoadMyRSO.php">RSC</a></li>';

    include 'AreTheyAdmin.php';

    if($admin > 1){
        echo '<li><a href="../PHPPage/SchoolList.php">School</a></li>';
    } else if(isset($_SESSION['sid'])) {
        echo '<li><a href="../PHPPage/LoadSchool.php">School</a></li>';
    }

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