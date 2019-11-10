<?php
    session_start();
    require_once "../PHPScript/config.php";
    include_once '../PHPScript/SetCookies.php';

    if(ISSET($_GET['Event'])){
        $eid = $_GET['Event'];
        error_log('event ID = ' . $eid);
    }

    include_once '../PHPScript/GetEventFromID.php';
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
                    <pre>
                        <?php echo ($eDesc .'
                                    <br>'.
                                    date("F jS Y | h:i A", strtotime("$eStart")));
                        ?>
                    </pre>
                </div>
                
                <div class="commentSection">
                    <?php include "../PHPScript/PullComments.php";?>    
                </div>

            </div>
                <?php
                    $query = "SELECT RSO_Name, NumofMembers
                              FROM rso
                              WHERE RSO_ID = ?";

                    if($stmt2 = $link->prepare($query)){

                            $stmt2->bind_param("i", $rID);
                            $rID = $eHostRSO;
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

            <?php
                if(isset($_SESSION['id'])){
                    
                $query =   'SELECT *
                            FROM commented
                            WHERE UserID = ? && EventID = ?';
                    
                    if($find = $link->prepare($query)){
                        
                        $find->bind_param("ii", $_SESSION['id'], $eid);
                        $fine->execute();
                        $find->bind_result($uid, $Event, $rating, $text, $timeP, $dayP);
                        $find->store_result();

                        if ($find->num_rows()) {
                            
                            $find->fetch();
                            
                            echo   '<div id="comment" class="comment">
                                        <form action="/PHPScript/UpdateComment.php" method="post">
                                            <h1> Edit Comment </h1>
                                
                                            <div class="section"> Review </div>
                                            <div class="inputSec"><textarea name="Review" id="reveiw" class="bigTextBox" wrap="hard" value="' . $text . 'required"</textarea></div>
                                            
                                            <div class="section"> Rating </div>
                                            <div class="inputSec"><input type="number" step="0.1" name="Lat" id="Lat" value="' . $rating . '" min="0" max="5" class="text" required></div>
                                            
                                            <div class="inputSec"><input type="hidden" name="Event" id="Event" class="text" value="' . $Event .'"></div>

                                            <br>
                                            <button type="submit" class="btn" name="action" value="update">Update</button>
                                            <button type="submit" class="btn cancel" onclick="closeThem()" name="action" Value="delete">Delete</button>
                                            <div class="errBox">
                                            </div>
                                        </form>
                                    </div>';
                                    
                        } else {
                            
                            echo   '<div id="comment" class="comment">
                                        <form action="/PHPScript/UpdateComment.php" method="post">
                                            <h1> Edit Comment </h1>
                                
                                            <div class="section"> Review </div>
                                            <div class="inputSec"><textarea name="Review" id="reveiw" class="bigTextBox" wrap="hard" required"></textarea></div>
                                            
                                            <div class="section"> Rating </div>
                                            <div class="inputSec"><input type="number" step="0.1" name="Lat" id="Lat" required min="0" max="5" class="text"></div>
                                            
                                            <div class="inputSec"><input type="hidden" name="Event" id="Event" class="text" value="' . $Event .'"></div>

                                            <br>
                                            <button type="submit" class="btn" name="action" value="create">Create</button>
                                            <div class="errBox">
                                            </div>
                                        </form>
                                    </div>';
                        }
                    }
                }
            ?>

        <div class="greyout" id="greyscreen" onclick="closeThem(); "> </div>
        
        <script>
            function openComment(){
                document.getElementById("login").style.display = "none";
                document.getElementById("comment").style.display = "block";
                document.getElementById("greyscreen").style.display = "block";
            }

            //closes greyScreen, Login and signUp
            function closeThem(){
                document.getElementById("login").style.display = "none";
                document.getElementById("sigcommentnUp").style.display = "none";
                document.getElementById("greyscreen").style.display = "none";
            }
        </script>
        
    </body>
</html>