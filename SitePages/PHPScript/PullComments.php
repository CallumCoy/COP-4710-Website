<?php
#work in prgress

    $query =   'SELECT *
                FROM commented
                WHERE EventID = ?';

    if($getCom = $link->prepare($query)){
        $getCom->bind_param('i', $eid);
        $getCom->execute();
        $getCom->bind_result($uid, $eid, $rate, $review, $postTime, $postDate);
        $getCom->store_result();
        
        while($getCom->fetch()){
            if($uid == $_SESSION["id"]){

                $query =   'SELECT Username, ProfilePic
                            FROM users
                            WHERE UserID = ?';
            
                if($getCom = $link->prepare($query)){
                    $getCom->bind_param('i', $uid);
                    $getCom->execute();
                    $getCom->bind_result($uName, $uPic);

                    if($uid != $_SESSION['id']){
                        echo '<div class="commentBox">
                            <div class="leftCommentBox">
                                <div class="commmentPic">
                                        <img src="' . $uPic . '" alt="Space" class="eventPic">
                                </div>
                                ' . $uName . '
                            </div>
                            <div class="rightCommentbox">
                                <div class="comment">
                                    <pre>' . $review . '</pre>
                                </div>
                                <div class="timeStamp"> ' . date("F jS Y | h:i A", strtotime("$eStart")) . ' </div>
                            </div>
                            <div class="break"></div>
                            <div class="rating"> ' . $rate . '/5 </div>
                        </div>';
                    } else {
                        echo '<div class="commentBox">
                            <div class="leftCommentBox">
                                <div class="commmentPic">
                                        <img src="' . $uPic . '" alt="Space" class="eventPic">
                                </div>
                                ' . $uName . '
                            </div>
                            <form action="/../PHPPage/LoadEventPage.php?eid="' . $eid . '>
                                <div class="rightCommentbox">
                                    <div class="comment">
                                        
                                        <pre>' . $review . '</pre>
                                    </div>
                                    <div class="timeStamp"> ' . date("F jS Y | h:i A", strtotime("$eStart")) . ' </div>
                                </div>
                                <div class="break"></div>
                                <div class="rating"> <> ' . $rate . '/5 </div>
                            </form>
                        </div>';

                    }
                }
            }
        }
    }
?>