<?php
#work in prgress

    $query =   'SELECT *
                FROM commented
                WHERE EventID = ?';

    if($getCom = $link->prepare($query)){
        $getCom->bind_param('i', $eid);
        $getCom->execute();
        $getCom->bind_result($uid, $c, $rate, $review, $postTime, $postDate);
        $getCom->store_result();
        
        while($getCom->fetch()){
            if($uid = $_SESSION["id"]){

                $query =   'SELECT Username, ProfilePic
                            FROM users
                            WHERE UserID = ?';
            
                if($getCom2 = $link->prepare($query)){
                    $getCom2->bind_param('i', $uid);
                    $getCom2->execute();
                    $getCom2->bind_result($uName, $uPic);
                    $getCom2->store_result();
                    $getCom2->fetch();

                    
                        echo '<div class="commentBox">
                            <div class="leftCommentBox">
                                <div class="commmentPic">
                                        <img src="' . $uPic . '"  class="eventPic">
                                </div>
                                ' . $uName . '
                            </div>
                            <div class="rightCommentbox">
                                <div class="comment">
                                    
                                    <pre>' . $review . '</pre>
                                </div>
                                <div class="timeStamp"> ' . date("F jS Y | h:i A", strtotime("$postTime")) . ' </div>
                            </div>
                            <div class="break"></div>
                            <div class="rating">' . $rate . '/5 </div>
                        </div>';

                }
            }
        }
    }
?>