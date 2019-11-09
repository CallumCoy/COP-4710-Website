<?php
    session_start();
    require_once "../PHPScript/config.php";
    include_once '../PHPScript/SetCookies.php';

    include '../PHPScript/AreTheyAdmin.php';

    if(!isset($_SESSION['sid']) && !isset($_GET['sid'])){
        header('location: ../index.php');                
    } elseif(!isset($_GET['sid'])){
        $sid = $rID = $_SESSION['sid'];
    } else {
        $sid = $rID = $_GET['sid'];
    }

    $query = "SELECT SchoolName, SchoolPic, SchoolDesc, NumOfStudents, NumOfRSOs
              FROM school
              WHERE SchoolID = ?";
    
    $sName = $sPic = $sDesc = $sNumStu = $sNumRSO = "";

    if($stmt = $link->prepare($query)){
        $stmt->bind_param("i", $sid);
        $stmt->execute();
        $stmt->bind_result($sName, $sPic, $sDesc, $sNumStu, $sNumRSO);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->close();
    } else {
        error_log("why no look up? Error: " . $event->error);
        header('location: ../index.php');
    }

?>
<html>
    <head>
        <title>
            <?php echo $sName; ?>
        </title>
        <link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/ItemPage.css" rel="stylesheet">
        <link href="../CSS/ItemPage_LeftColumn.css" rel="stylesheet">
    </head>
    <body>

        <?php require '../PHPScript/navBar.php';?>

        <div class="header" style="display: table;"> 
            <div class="Info" style="font-size: 32px;">
                <?php echo $sName; ?>
            </div>
        </div>
        <div class="page">
            <div class="leftColumn">
                <div class="desc">
                    <?php echo $sDesc; ?>
                </div>
            </div>
            <div class="rightColumn">
                <div class="pic">
                    <img src="..\Sources\Images\413977.jpg" alt="Space" class="eventPic">
                </div>
                Num of Students:
                <br>
                <?php echo $sNumStu; ?>
                <br> 
                Num of RSOs:
                <br>
                <?php echo $sNumRSO; ?>
                <br>
                <div class="list">
                    SUPER ADMIN
                    <div class="person">
                        
                        <?php 
                        $aName = $aPic = $aEmail = "";
                        $admin = 'super_admins';
                        include "../PHPScript/getAdmin.php";
                        ?>
                    </div>
                </div>
                <div class="list">
                    STUDENTS
                        <?php 
                        $type = $people='students';
                        $rID = $sid;
                        include "../PHPScript/GetPeople.php";
                        ?>
                </div>
            </div>
        </div>
        
    </body>
</html>