<?php
    require_once "config.php"

    // Define the variables and set to empty values
    $email = $username = $password = $confirmPassword = "";
    $emailErr = $usernameErr = $passwordErr =  $comfirmPasswordErr = "";

    //process the form info
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty(trim($_POST["email"]))){
            $emailErr = "Please enter a email.";
        } else {
            //preparing a select statement
            $sql = "SELECT UserId FROM users WHERE Email = ?";
            
            if ($stmt =mysqli_prepare($link, $sql)) {
                //binds the parameter with the following statement
                mysqli_stmt_bind_param($stmt, "s", $param_email);

                // Sets the parameters
                $param_email = trim($_POST["email"]);

                //tries the statement
                if (mysqli_stmt_excute($stmt)) {
                    # get the restults
                    mysqli_stmt_store_results($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        # we ran into a duplicate
                        $emailErr "this email has already been used";
                    } else {
                        $email = trim($_POST["email"]);
                    }
                } else {
                    echo "Something seems to have happened please try again at a later time";
                }
            }

            #close the statement
            mysqli_stmt_close($stmt);
        }

        if (empty(trim($_POST["name"]))) {
            # no name given
            $usernameErr = "Please give me a name, even if it's fake";
        }

        if (empty(trim($_POST["password"]))) {
            # no password givenm
            $passwordErr = "Please enter a password";
        } elseif (strlen(trim($_POST["password"]) < 8)) {
            $passwordErr = "Please give a password that is atleast 8 characters, it's for you safety";
        } else {
            $password = trim($_POST["password"]);
        }

        if (empty)(trim($_POST["passwordCheck"]))) {
            # did not check password
            $comfirmPasswordErr = "Please check you password, even I manage to screw mine up from time to time";
        } else{
            $confirmPassword = trim($_POST["passwordCheck"]);
            if (empty($passwordErr) && ($password != $comfirmPasswordErr)) {
                $comfirmPasswordErr = "The passwords did not match";
            }
        }

        #assuring no errors were called up until now
        if (empty($emailErr) && empty($usernameErr) && empty($passwordErr) && empty($comfirmPasswordErr)) {
            # prepare a insert statement
            $sql = "INSERT INTO users (Username, Password, Email) VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                # bind the statement and parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);

                #set the parameters
                $param_username = $username;
                
                #hashing the password
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                $param_email = $email;

                if (mysqli_stmt_excute($stmt)) {
                    # logs in TODO code the log in
                } else{
                    echo "something went wrong. I'm sowwy ;-;";
                }
            }

            #close the statement
            mysqli_stmt_close($stmt);
        }

        #close the connection
        mysqli_close($link);
    }
>