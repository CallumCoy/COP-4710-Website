<?php

    echo '<span style="font-size:35px;cursor:pointer" onclick="openNav()"> > </span>

        <div id="myNav" class="overlay">
           <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
           <div class="overlay-content">';

        if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true)) {
            echo '<a href="/PHPPage/editRSOPage.php?name=null"></a>';

            require_once "config.php";
            $sql = "SELECT 1
                     FROM admins
                     WHERE UserID = ?";

            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, $paramID);

                $paramID = $_SESSION["id"];
                if (mysqli_stmt_execute($link)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0){
                        echo '<a href="/PHPScript/LoadMyRSOAdmin.php"></a>';
                    }
                }
                mysqli_stmt_close($stmt);
            }

            $sql =" SELECT 1
                    FROM members
                    WHERE UserID = ?";

            if($stmt->prepare($link, $sql)){
                $stmt->bind_param($_SESSION["id"]);
                $stmt->execute();
                $stmt->store_result();

                if($stmt->num_rows() > 0){
                    echo '<a href="/PHPScript/LoadMyRSO.php"></a>';
                }
            }

            mysqli_close($link);
        }

            '<a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
           </div>
        </div>'
?>