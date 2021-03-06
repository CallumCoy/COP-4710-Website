<?php

    echo '<span style="font-size:35px;cursor:pointer" onclick="openNav()"> > </span>

        <div id="myNav" class="overlay">
           <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
           <div class="overlay-content">';

        #Adds some options if the user is logged in
        if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true)) {
            include "AreTheyAdmin.php";
            
            if($admin > 0){
                echo '<a href="/PHPPage/EventListPage.php?admin=' . $admin . '&view=0">Approve Events</a>';
            }

            $sql = "SELECT 1
                     FROM events
                     WHERE HostingUserID = ?";

            if($stmt = mysqli_prepare($link, $sql)){

                mysqli_stmt_bind_param($stmt, "i", $paramID);

                $paramID = $_SESSION["id"];

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0){
                        echo '<a href="/PHPPage/EventListPage.php?UHost=' . $_SESSION['id'] . '&view=0">Edit My Events</a>';
                    }
                }
                mysqli_stmt_close($stmt);
                
                echo '<a href="/PHPPage/EventListPage.php?UHost=' . $_SESSION['id'] . '&view=1">View My Events</a>';
                echo '<a href="/PHPPage/NewEvent.php">Make a Events</a>';
            }

            echo '<br> 
                    <br> Search By Event Name
                    <form action="EventListPage.php" method="get">
                    <input list="Events" name="Name" class="Name overLap">';
                        include "ListOfEvents.php";
            echo '  <br>
                    <br> Hosting RSO
                    <select list="RSOsid" name="Host" class="RSOs overLap">';
                        include "listOfRSOsID.php";
            echo '  </select>
                    <br> 
                    <br> Hosting School </br>
                    <select list="Schools" name="School" class="RSOs overLap">';
                        include "ListOfSchools.php";
            echo '  </select>
                    <br> 
                    <br> Start Time </br>
                    <input type="date" name="StartDate" class="overLap">
                    <br> 
                    <br>
                    <input type="time" name="StartTime" class="overLap">  
                    <br> 
                    <br>
                    Show Past Events <input type="checkbox" name="Old" class="overLap">  
                    <br> 
                    <br>
                    <button type="submit" class="RSOSearch"> Search </button>
                    </form>';
        }

            echo    '</div>
            </div>';
?>