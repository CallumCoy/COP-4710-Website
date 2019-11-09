<?php
    $admin = 0;

    if(!isset($sid)){
        if(isset($_SESSION['id'])){
            $sid = $_SESSION['id'];
        } else {
            $sid = 0;
        }
    }
    
    if(!isset($rid)){
        $rid = 0;
    }
    error_log($rid);
    error_log($_SESSION['id']);
    error_log($admin);

    $query = "  SELECT 1
    FROM admins
    WHERE RSO_ID = ? && UserID = ?";

    if($stmtAd = $link->prepare($query)){
        $stmtAd->bind_param("ii", $rid, $_SESSION['id']);
        $stmtAd->execute();
        $stmtAd->store_result();
        error_log($stmtAd->num_rows());
        if ($stmtAd->num_rows()>0){
            $admin = 1;
        }
        error_log($rid);
        $stmtAd->close();
    }
    error_log($admin);

    $query = "  SELECT 1
    FROM super_admins
    WHERE UserID = ?";
    
    if($stmtAd = $link->prepare($query)){
        $stmtAd->bind_param("i", $_SESSION['id']);
        $stmtAd->execute();
        $stmtAd->store_result();
        if ($stmtAd->num_rows()>0){
            $admin = 2;
        }
        error_log($rid);
        $stmtAd->close();
    }
    error_log($admin);
?>