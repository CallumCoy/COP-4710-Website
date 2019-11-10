<?php
    include_once '../PHPScript/IsLoggedIn.php';

    $uid = $name = $desc = $pic = $error = "";

    $uid = trim($_GET["uid"]);
    $Email = trim($_GET["Email"]);
    $name = trim($_GET["Name"]);
    $desc = trim($_GET["Desc"]);
    $pic = trim($_GET["myPhoto"]);

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
?>