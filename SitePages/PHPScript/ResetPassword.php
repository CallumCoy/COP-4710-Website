<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

require_once "config.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Validate new password
    if(empty(trim($_POST["Pas"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["Pas"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["Pas"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["PasCom"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["PasCom"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET Password = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            $param_id = $_SESSION["id"];
            $param_password = $_SESSION["Pas"];

            if (mysqli_stmt_exucute($stmt)) {
                session_destroy();
                exit();
            } else {
                echo "Something happened boss and we don't know what.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>