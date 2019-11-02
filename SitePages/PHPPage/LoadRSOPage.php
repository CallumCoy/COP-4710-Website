<?php
    session_start();
    require_once "../PHPScript/config.php";
    include_once '../PHPScript/SetCookies.php';

    if(ISSET($_GET['RSO'])){
        $rID = $_GET['RSO'];
        error_log($rID);
    }

    include_once '../PHPScript/getRSOImproved.php';
?>
<html>
    <head>
        <title>
            <?php echo $orName; ?>
        </title>
        <link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/ItemPage.css" rel="stylesheet">
        <link href="../CSS/ItemPage_LeftColumn.css" rel="stylesheet">
    </head>
    <body>

        <?php require '../PHPScript/navBar.php';?>

        <div class="header" style="display: table;"> 
            <div class="Info" style="font-size: 32px;">
                <?php echo $orName; ?>
            </div>
        </div>
        <div class="page">
            <div class="leftColumn">
                <div class="desc">
                    <?php echo $desc; ?>
                </div>
            </div>
            <div class="rightColumn">
                <div class="pic">
                    <img src="..\Sources\Images\413977.jpg" alt="Space" class="eventPic">
                </div>
                Num of Members:
                <br>
                <?php
                    $query = "SELECT NumofMembers
                              FROM rso
                              WHERE RSO_ID = ?";

                    if($stmt2 = $link->prepare($query)){
                        $stmt2->bind_param("i", $rID);
                        $stmt2->execute();
                        $stmt2->bind_result($num);
                        $stmt2->store_result();
                        $stmt2->fetch();

                        echo $num;
                    }
                ?>
                <div class="list">
                    ADMIN
                    <div class="person">
                        
                        <?php 
                        $aName = $aPic = $aEmail = "";
                        $admin = 'admins';
                        include "../PHPScript/getAdmin.php";
                        ?>
                    </div>
                </div>
                <div class="list">
                    MEMBERS
                        <?php 
                        $type='members';
                        include "../PHPScript/GetPeople.php";
                        ?>
                </div>
            </div>
        </div>
        
    </body>
</html>