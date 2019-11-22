<?php
    session_start();
    require_once "../PHPScript/config.php";
    include_once '../PHPScript/SetCookies.php';

    if(ISSET($_GET['Event'])){
        $eid = $_GET['Event'];
        error_log('event ID = ' . $eid);
    }

    $elid = "";

    include_once '../PHPScript/GetEventFromID.php';
    $rID = $_GET['Event'];
    error_log("$elid")
    
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
        
        
        <script>
            function openCommentBoxes(){
                document.getElementById("commentPopUp").style.display = "block";
                document.getElementById("greyscreen").style.display = "block";
            }

            //closes greyScreen, Login and signUp
            function closeThem(){
                document.getElementById("commentPopUp").style.display = "none";
                document.getElementById("greyscreen").style.display = "none";
            }
        </script>

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
                        <?php 
                                echo ($eDesc .'
                                    <br>'.
                                    date("F jS Y | h:i A", strtotime("$eStart"))) .
                                    '<br>Lat: ' . $eLat . 'Long: ' . $eLong .
                                    '<br>Building: ' . $eBuild . ' | Floor: ' . $eBuild . ' | Room: ' . $eRoom .
                                    '<br>' .
                                    $rating .'/5';
                        ?>
                    </pre>
                </div>
                
                <div class="commentSection">
                    <button name="btn" id="btn" class="btn" type="button" onclick="openCommentBoxes();">Comment</button>
                    <?php include "../PHPScript/PullComments.php";?>    
                </div>

            </div>
                <?php
                    if(isset($rID) && $rID != NULL){
                        $query = "SELECT RSO_Name, NumofMembers
                                FROM rso
                                WHERE RSO_ID = ?";

                        if($getRso = $link->prepare($query)){
                            $getRso->bind_param("i", $rID);
                            $rID = $eHostRSO;
                            $getRso->execute();
                            $getRso->bind_result($rname, $num);
                            $getRso->store_result();
                            $getRso->fetch();


                            echo ('<div class="rightColumn">
                            HOSTED BY
                            <br>' .
                            $rname
                            . '</br>
                            <div class="pic">
                                <img src="' . $ePic . '"  class="eventPic">
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

                            if ($rID != NULL) {
                                echo ('</div>
                                </div>
                                <div class="list">
                                    MEMBERS'); 
                                        $people='members';
                                        include "../PHPScript/GetPeople.php";
                                echo ('</div>
                                </div>');
                            }    
                            $getRso->close();
                        }
                    }else {

                           error_log("$query, $link->error");
                           $query = "SELECT Username, ProfilePic
                           FROM Users
                           WHERE UserID = ?";
         
                        if($stmt21 = $link->prepare($query)){
                            $stmt21->bind_param("i", $eHostUser);
                            $stmt21->execute();
                            $stmt21->bind_result($Name, $Pic);
                            $stmt21->store_result();
                            $stmt21->fetch();
                            
                            echo ('<div class="rightColumn">
                            HOSTED BY
                            <br>' .
                            $Name
                            . '</br>
                            <div class="pic">
                                <img src="' . $ePic . '"  class="eventPic">
                            </div>');

                            echo ('<div class="list">
                                    <div class="person">
                                        <div class="miniPic">
                                                <img src="' . $Pic . '"  class="eventPic">
                                            </div>                      
                                            <div class="InfoTable">
                                                <div class="Info">
                                                    ' . $Name . '
                                                </div>
                                            </div>
                                    </div>
                                    </div>');
                            
                            $stmt21->close();
                        } 
                    }
                    error_log("$query, $link->error");
                ?>
        </div>

            <?php
                if(isset($_SESSION['id'])){
                    
                $query =   'SELECT *
                            FROM commented
                            WHERE UserID = ? && EventID = ?';
                    
                    if($find = $link->prepare($query)){
                        
                        $find->bind_param("ii", $_SESSION['id'], $_GET['Event']);
                        $find->execute();
                        $find->bind_result($uid, $f, $rating, $myText, $timeP, $dayP);
                        $find->store_result();
                        
                        error_log($_GET['Event']);
                        error_log($find->num_rows());

                        echo "";

                        if ($find->num_rows()) {
                            
                            $find->fetch();
                            
                            echo   '<div id="commentPopUp" class="commentPopUp">
                                        <form action="/PHPScript/UpdateComment.php">
                                            <h1> Edit Comment </h1>
                                
                                            <div class="section"> Review </div>
                                            <div class="inputSec"><textarea name="Review" id="reveiw" class="bigTextBox" wrap="hard"> ' . $myText . ' </textarea></div>
                                            
                                            <div class="section"> Rating </div>
                                            <div class="inputSec"><input type="number" step="0.1" name="Rate" id="Rate" value="' . $rating . '" min="0" max="5" class="text" required></div>
                                            
                                            <div class="inputSec"><input type="hidden" name="Event" id="Event" class="text" value="' . $_GET['Event'] .'"></div>

                                            <br>

                                            <button type="submit" class="btn" name="action" value="update">Update</button>
                                            <button type="submit" class="btn cancel" name="action" Value="delete">Delete</button>
                                            <button type="button" class="btn cancel" onclick="closeThem();">Close</button>
                                            <div class="errBox">
                                            </div>
                                        </form>
                                    </div>';

                        } else {
                            
                            echo   '<div id="commentPopUp" class="commentPopUp">
                                        <form action="/PHPScript/UpdateComment.php">
                                            <h1> Edit Comment </h1>
                                
                                            <div class="section"> Review </div>
                                            <div class="inputSec"><textarea name="Review" id="reveiw" class="bigTextBox" wrap="hard" required></textarea></div>
                                            
                                            <div class="section"> Rating </div>
                                            <div class="inputSec"><input type="number" step="0.1" name="Rate" id="Rate" required min="0" max="5" class="text"></div>
                                            
                                            <div class="inputSec"><input type="hidden" name="Event" id="Event" class="text" value="' . $_GET['Event'] .'"></div>

                                            <br>
                                            <button type="submit" class="btn" name="action" value="create">Create</button>
                                            <button type="button" class="btn cancel" onclick="closeThem();">Close</button>
                                            <div class="errBox">
                                            </div>
                                        </form>
                                    </div>';
                        }
                    }
                }
            ?>

        <div class="greyout" id="greyscreen" onclick="closeThem(); "> </div>
        
    </body>
</html>