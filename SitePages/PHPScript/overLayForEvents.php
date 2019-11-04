<?php

    echo '<span style="font-size:35px;cursor:pointer" onclick="openNav()"> > </span>

        <div id="myNav" class="overlay">
           <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
           <div class="overlay-content">';

        #Adds some options if the user is logged in
        if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true)) {
            
            echo '<form action="EventListPage.php" method="get">
                    <input list="Events" name="Name" class="Name">';
                        include "ListOfEvents.php";
            echo '  <button type="submit" class="EventSearch"> GO </button>
                  </form>';


            #shows an extra option if the user is an admin of any RSOs
            require_once "config.php";
            $sql = "SELECT *
                     FROM events
                     WHERE HostingUserID = ?";

            if($stmt = mysqli_prepare($link, $sql)){

                mysqli_stmt_bind_param($stmt, "i", $paramID);

                $paramID = $_SESSION["id"];

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0){
                        echo '<a href="/PHPPage/EventListPage.php?UHost=' . $_SESSION['id'] . '">Edit My Events</a>';
                    }
                }
                mysqli_stmt_close($stmt);
            }

            if($_SESSION != NULL){
                echo '<a href="/PHPPage/LoadMyEvents.php?level=Viewer">View My Events</a>';
            }
        }

            echo '<a href="#">Clients</a>
            <a href="#">Contact</a>
           </div>
        </div>';
?>