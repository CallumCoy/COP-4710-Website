<?php
    session_start();
    require_once '../PHPScript/config.php';
    include_once '../PHPScript/IsLoggedIn.php';
    include_once '../PHPScript/SetCookies.php';

    $uid = $name = $desc = $pic = $error = "";

    $uid = trim($_SESSION["id"]);
    $Email = trim($_POST["Email"]);
    $name = trim($_POST["Name"]);
    $desc = trim($_POST["Desc"]);

    include '../PHPScript/SetUpPicture.php';

    if($_SESSION['id'] == $uid){

        $query =   'UPDATE users
        SET Username = ?, ProfilePic = ?, Email = ?, Bio = ?
        WHERE UserID = ?';

        if($update = $link->prepare($query)){
            $update->bind_param('ssssi', $name, $pic, $Email, $desc, $uid);
            $update->execute();
            $update->close();
        }
    } 

    header("location: ../PHPPage/EventListPage.php");
?>