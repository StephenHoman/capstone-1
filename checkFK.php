<?php

require_once("dBCred.PHP");

if (isset($_SESSION['LOGINID']) && isset($_SESSION['USERID'])) {
    echo $_SESSION['LOGINID'];
    $sql = "SELECT login_id FROM mydatabase.users_login WHERE user_id = ?";
         
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_id);
        
        // Set parameters
        $param_id = $_SESSION['USERID'];
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {                    
                echo "found user";
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $login_id);
                
                echo "success";
            }
        } else {
            echo "error1";
        }
            
        // Prepare an insert statement
        $sql = "INSERT INTO mydatabase.users_login (login_id, user_id) VALUES (?, ?)";
         
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $param_login, $param_id);
            
            // Set parameters
            $param_login = $_SESSION['LOGINID'];
            $param_id = $_SESSION['USERID'];
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                 
            } else {
                echo "error2";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>
