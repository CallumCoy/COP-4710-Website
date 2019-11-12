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
                <pre>
                    <div class="desc">
                        <?php 
                            
                            echo "<div> " . $desc . " </div>";
                                                        
                            $query =   'SELECT 1
                                        FROM admins
                                        WHERE RSO_ID = ? && UserID = ?';

                            if($stmt2 = $link->prepare($query)){
                                $stmt2->bind_param('ii', $rID, $_SESSION['id']);
                                $stmt2->execute();
                                $stmt2->store_result();
                                
                                if($stmt2->num_rows() == 0){
                                    if($_SESSION['sid'] == $sid){
                                        $query =   'SELECT 1
                                                    FROM members
                                                    WHERE UserID = ? && RSO_ID = ?';

                                        
                                        if($stmt = $link->prepare($query)){
                                            $stmt->bind_param('ii', $_SESSION['id'], $rID);
                                            $stmt->execute();
                                            $stmt->store_result();

                                            if($stmt->num_rows() == 0){
                                                echo '<form action="../PHPScript/BecomeMember.php">
                                                        <div><input type="hidden" name="rid" id="rid" class="text" value="' . ($rID) . '"></div>
                                                        <div><input type="submit" class="signUp" Value="Join"></div>
                                                    </form>';
                                            } else {
                                                echo '<form action="../PHPScript/LeaveMember.php"">
                                                        <div><input type="hidden" name="rid" id="rid" class="text" value="' . ($rID) . '"></div>
                                                        <div><input type="submit" class="signUp" Value="Leave"></div>
                                                    </form>';
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                    </div>
                </pre>
            </div>
            <div class="rightColumn">
                <div class="pic">
                    <img src="<?php echo $pic;?>"  class="eventPic">
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
                        $people='members';
                        include "../PHPScript/GetPeople.php";
                        ?>
                </div>
            </div>
        </div>
        
    </body>
</html>