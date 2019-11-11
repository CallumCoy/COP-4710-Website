<?php
    $targDir ="../Sources/Images/";
    $pic = $targDir . basename($_FILES["uploadImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($pic,PATHINFO_EXTENSION));
        
    $check = getimagesize($_FILES["uploadImage"]["tmp_name"]);
    if($check !== false) {
        error_log("File is an image - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
        error_log("File is not an image.");
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($pic)) {
        error_log("Sorry, file already exists.");
        $uploadOk = 0;
    }

    if ($_FILES["uploadImage"]["size"] > 2000000) {
        error_log("Sorry, your file is too large.");
        $uploadOk = 0;
    } 

    #images only
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        error_log("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        error_log("Sorry, your file was not uploaded.");
    } else {
        if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $pic)) {
            error_log("The file ". basename( $_FILES["uploadImage"]["name"]). " has been uploaded.");
        } else {
            error_log("Sorry, there was an error uploading your file.");
        }
    }
?>