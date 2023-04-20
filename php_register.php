<?php

session_start();

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate username
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter a username.";
    }
        else
    {
        // Prepare a select statement
        $sql = "SELECT user_username FROM mydatabase.login WHERE user_username =  ?";
        
        if($stmt = mysqli_prepare($conn, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
                {   
                    $_SESSION['signup_error'] = true;
                    $username_err = "This user is already taken.";
                }
                    else
                {
                    $username = trim($_POST["username"]);
                }
            }
                else
            {
            
                $_SESSION['signup_error'] = true;
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"])))
    {   
        $_SESSION['signup_error'] = true;
        $password_err = "Please enter a password.";     
        }
            elseif
            (strlen(trim($_POST["password"])) < 6)
        {
            $_SESSION['signup_error'] = true;
        $password_err = "Password must have atleast 6 characters.";
    }
        else
    {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"])))
    {
        $confirm_password_err = "Please confirm password.";     
    }
        else
    {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password))
        {
            $_SESSION['signup_error'] = true;
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
   if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
  {
        // Prepare an insert statement
        $sql = "INSERT INTO mydatabase.login (login_id, user_username, user_password) VALUES (Null, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            echo "password hashed";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                
                // Prepare an insert statement
            $sql = "SELECT  login_id FROM mydatabase.login WHERE user_username = ?";
         
            if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
                {                    
                    echo "found user";
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $login_id );
                    if(mysqli_stmt_fetch($stmt))         
                    $_SESSION["id"] = $login_id;
                    $_SESSION["username"] = $param_username;

                    header("location: signup_details.php");

                echo "success";
            } 
                else
            {
                $_SESSION['signup_error'] = true;
                echo "Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
            $_SESSION['signup_error'] = true;
        }}
    }}}
    // Close connection
    mysqli_close($conn);
    $_SESSION['signup_error'] = true;
}