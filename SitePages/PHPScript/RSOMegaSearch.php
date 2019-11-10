<?php
    $error = "";
    $search = "";
    $numOfGets = count($_GET);
    error_log("hi");
    
    if(isset($_GET["view"])){
        $numOfGets = $numOfGets - 1;
        $view = $_GET["view"];
    } else {
        $view = 1;
    }

    if(isset($_GET["Name"])){
        $search =  $search . "RSO_Name LIKE '%" . $_GET['Name'] . "%'";
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }
    
    if(isset($_GET["School"])){
        $search =  $search . "SchoolID = " . $_GET['School'];
        $numOfGets = $numOfGets - 1;
        if($numOfGets != 0){
            $search = $search . ' && ';
        }
    }
    
    include "../PHPScript/AreTheyAdmin.php";

    $query = "  SELECT RSO_ID, RSO_Name, RSO_Desc, RSO_ProfPic, NumofMembers
                FROM rso 
                WHERE " . $search . '
                ORDER BY RSO_Name';
    
    
    if($stmt = $link->prepare($query)){
        $stmt->execute();
        $stmt->bind_result($rid, $orName, $desc, $pic, $num);
        $stmt->store_result();
        error_log("get rso mega search : " . $stmt->error);

        while($stmt->fetch()){
            if($num > 4){
                echo   '<a href="../PHPPage/LoadRSOPage.php?RSO=' . $rid . '"> <div class="event" >
                            <div class="eventPicDiv">
                                <img src="' . $pic . '" alt="Space" class="eventPic">
                            </div>
                            <div class="information">
                                <h3>' . $orName .'</h3>
                                <div class="text">
                                    <pre>
                                        ' . $desc .'
                                    </pre>
                                </div>  
                                <div class="startInfo"></div>    
                            </div>
                        </div> </a>';
            } else{
                echo   '<a href="../PHPPage/LoadRSOPage.php?RSO=' . $rid . '"> <div class="event" >
                            <div class="eventPicDiv">
                                <img src="' . $pic . '" alt="Space" class="eventPic">
                            </div>
                            <div class="information">
                                <h3>' . $orName .'</h3>
                                <div class="text">
                                    <pre>
                                        ' . $desc .'
                                    </pre>
                                </div>  
                                <div class="startInfo"></div>    
                            </div>
                        </div> </a>';
            }
        }
    }
?>