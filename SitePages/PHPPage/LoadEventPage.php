<?php
    session_start();
    include_once '../PHPScript/SetCookies.php';
    require_once "../PHPScript/config.php";

    if(ISSET($_GET['Event'])){
        $eID = $_GET['Event'];
        error_log('event ID = ' . $eID);
    }

    include_once '../PHPScript/getEvent.php';
?>
<html>
    <head>
        <title>
            <?php echo $eName; ?>
        </title>
        <link href="../CSS/Base.css" rel="stylesheet">
        <link href="../CSS/ItemPage.css" rel="stylesheet">
        <link href="../CSS/ItemPage_LeftColumn.css" rel="stylesheet">
    </head>
    <body>

        <?php require '../PHPScript/navBar.php';?>

        <div class="header" style="display: table;"> 
            <div class="Info" style="font-size: 32px;">
                <?php echo $eName; ?>
            </div>
        </div>
        <div class="page">
            <div class="leftColumn">
                <div class="desc">
                    <?php echo ($eDesc .'
                                <br> '.
                                $eStart); ?>
                </div>
            </div>
                <?php
                    $query = "SELECT RSO_Name, NumofMembers
                              FROM rso
                              WHERE RSO_ID = ?";

                    if($stmt2 = $link->prepare($query)){

                        $stmt2->bind_param("i", $rID);
                        $rID = $host;
                        $stmt2->execute();
                        $stmt2->bind_result($rname, $num);
                        $stmt2->store_result();
                        $stmt2->fetch();

                        echo ('<div class="rightColumn">
                        HOSTED BY
                        <br>' .
                        $rname
                        . '</br>
                        <div class="pic">
                            <img src="..\Sources\Images\413977.jpg" alt="Space" class="eventPic">
                        </div>
                        Num of Members:
                        <br>');

                        echo ($num . '
                        
                        <div class="list">
                        ADMIN
                        <div class="person">');
                            
                            $aName = $aPic = $aEmail = "";
                            $admin = 'admins';
                            include "../PHPScript/getAdmin.php";

                    echo ('</div>
                    </div>
                    <div class="list">
                        MEMBERS'); 
                            $people='members';
                            include "../PHPScript/GetPeople.php";
                    echo ('</div>
                    </div>');
                    }
                ?>
        </div>
        
    </body>
</html>