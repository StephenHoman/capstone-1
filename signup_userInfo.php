<?php
 
// Define variables and initialize with empty values
$user_description = $zip_code = $city = $state = $address_line_two = $address_line_one = $image_url   = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if user image is empty
    if(empty(trim($_POST["formFile"] )))
    { // add size limit and other stuff for format w
      //  instead of running a normal query, just delete the old file and upload new one.  
      // dont mess with sql value
    }
        else
    {
        $image_url = trim($_POST["formFile"]);
    }

    // Check if Address Line one  is empty
    if(empty(trim($_POST["addressLineOne"])))
    {   // write error for value
         $password_err = "Please enter your password.";
    }
        else
    {
        $address_line_one = trim($_POST["addressLineOne"]);
    }

     // Check if Address Line one  is empty
     if(empty(trim($_POST["addressLineTwo"])))
     {   // write error for value
          $password_err = "Please enter your password.";
     }
         else
     {
         $address_line_two = trim($_POST["addressLineTwo"]);
     }

    // Check if Address Line one  is empty
    if(empty(trim($_POST["state"])))
    {   // write error for value
        $password_err = "Please enter your password.";
    }
        else
    {
        $state = trim($_POST["state"]);
    }

    // Check if Address Line one  is empty
    if(empty(trim($_POST["city"])))
    {   // write error for value
        $password_err = "Please enter your password.";
    }
        else
    {
        $city = trim($_POST["city"]);
    }

    // Check if Address Line one  is empty
    if(empty(trim($_POST["zip"])))
    {   // write error for value
        $password_err = "Please enter your password.";
    }
        else
    {
        $zip_code = trim($_POST["zip"]);
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