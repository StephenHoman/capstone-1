<?php
 
// Define variables and initialize with empty values
$username = $password          = "";
$username_err = $password_err  = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if username is empty
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter username.";
    }
        else
    {
        $username = trim($_POST["username"]);
    }
    // Check if password is empty
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter your password.";
    }
        else
    {
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if(empty($username_err) && empty($password_err))
    {
        echo "preparing statement";
        // Prepare a select statement
        $sql = "SELECT login_id, user_username, user_password FROM mydatabase.login WHERE user_username = ?";
        if($stmt = mysqli_prepare($conn, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            echo "statement bound";
            // Set parameters
            $param_username = $username;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            { 
                echo "storing result";
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
                {                    
                    echo "found user";
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $login_id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            echo "Password Matches";
                            session_start();
                            // Store data in session variables
                            echo ($_SESSION["loggedin"] = true);
                            echo ($_SESSION["id"] = $login_id);
                            echo ($_SESSION["username"] = $username);                            
                            echo "redirecting to user page ";
                            
                            // Redirect user to welcome page
                            header("location: user_page.php");
                        }
                        else
                        {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                }
                else
                {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
            echo " 1st close";
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    echo "2nd close";
    // Close connection
    mysqli_close($conn);
}