<?php
#start up the seciton
session_start();

#see if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    # relocate
    header("location: /../index.php");
    exit;
}

# get the database up and running
require_once "config.php";

$email = $password = "";
$emailError = $passwordError = "";

#Process the info upon recieving the POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # find out if you actually got a username
    if (empty(trim($_POST["email"]))) {
        $emailError = "Please enter a Email.";
    } else{
        $email = trim($_POST["email"]);
    }

    #check if the password is empty
    if (empty(trim($_POST["password"]))) {
        $passwordError = "Please enter a Password.";
    } else {
        $password = trim($_POST["password"]);
    }

    #assure no error was recieved
    if (empty($emailError) &&empty($passwordError)) {
        #prep the query
        $sql = "SELECT UserID, Email, Pasword FROM users WHERE Email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

                echo 'hi';
            if (mysqli_stmt_execute($stmt)) {
                #store the results
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    # Bind the results with a variable
                    mysqli_stmt_bind_result($stmt,$id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        echo password_hash($password, PASSWORD_DEFAULT);
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            #starting the session for the user that just logged in
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            
                            include "SetCookies.php";

                            header("location: /../index.php");
                        } else {
                            $passwordError = "incorrect password was provided.";
                        }
                    }
                } else {
                    $emailError = "email not found in our system, please make an account or check for any typos";
                }
            } else {
            echo "Something seems to have broken down, please cross you finger and try again";
            }
        }

        mysqli_stmt_close($stmt);
    }
    echo $emailError . " " . $passwordError;
    mysqli_close($link);
}

?>