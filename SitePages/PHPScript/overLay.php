<?php

    echo '<span style="font-size:35px;cursor:pointer" onclick="openNav()"> > </span>

        <div id="myNav" class="overlay">
           <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
           <div class="overlay-content">';

        #Adds some options if the user is logged in
        if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true)) {
            
            echo '<form action="/PHPScript/getRSOInfo.php" method="get">
                    <input list="RSOs" name="RSOs" class="RSOs">';
                        include "listOfRSOs.php";
            echo '  <button type="submit" class="RSOSearch"> GO </button>
                  </form>';


            #shows an extra option if the user is an admin of any RSOs
            require_once "config.php";
            $sql = "SELECT *
                     FROM admins
                     WHERE UserID = ?";

            if($stmt = mysqli_prepare($link, $sql)){

                mysqli_stmt_bind_param($stmt, "i", $paramID);

                $paramID = $_SESSION["id"];

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0){
                        echo '<a href="/PHPPage/LoadMyRSO.php?level=admins">Edit My RSOs</a>';
                    }
                }
                mysqli_stmt_close($stmt);
            }

            $sql =" SELECT *
                    FROM members
                    WHERE UserID = ?";

            if($stmt2 = $link->prepare($sql)){
                $stmt2->bind_param("i", $_SESSION["id"]);
                $stmt2->execute();
                $stmt2->store_result();

                if($stmt2->num_rows() > 0){
                    echo '<a href="/PHPPage/LoadMyRSO.php?level=members">View My RSOs</a>';
                }
                $stmt2->close();
            }
        }

            echo '<a href="#">Clients</a>
            <a href="#">Contact</a>
           </div>
        </div>';
?>