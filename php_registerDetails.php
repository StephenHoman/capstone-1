<?php
 
// Define variables and initialize with empty values
$user_description = $zip_code = $city = $state = $address_line_two = $address_line_one    = "";
require_once("dBCred.PHP");

function uploadProfileImage($photoInput) {
    $uploadDir = 'photos/profile_image';
    $tempName = $photoInput['tmp_name'];
    $fileName = basename($photoInput['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $hashedName = hash('sha256', time() . $fileName) . '.' . $fileType;
    $targetFile = $uploadDir . '/' . $hashedName;

    // Move uploaded file to new location with new name
    if (move_uploaded_file($tempName, $targetFile)) {
        return $targetFile;
    } else {
        return 'photos/profile_image/default.webp';
    }
}
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
     
        if (isset($_FILES['formFile']) && $_FILES['formFile']['error'] == UPLOAD_ERR_OK) {
            // File was uploaded successfully
            $newFileName = uploadProfileImage($_FILES['formFile']);
            if ($newFileName) {
                // File was uploaded successfully
                echo 'File was uploaded successfully with name ' . $newFileName;
            } else {
                echo 'Error moving uploaded file.';
            }
        }
     
    
    



        if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
        {   
            $email            = trim($_POST["email"]);
            $login_id          = trim($_POST["login_id"]);
            $image_id         = $newFileName;
            $address_line_one = trim($_POST["addressLineOne"]);
            $state            = trim($_POST["state"]);
            $city             = trim($_POST["city"]);
            $zip              = trim($_POST["zip"]);
            
            $transaction_count= 0;
            $premium_user     = 0;
            // Prepare an insert statement
              $sql = "INSERT INTO mydatabase.users (user_id, email, login_id, image_id, address_line_one, users.state, city, zip_code, account_creation_date, last_online, transaction_count, premium_user) VALUES (Null, ?, ?, ?, ?, ?, ?, ?, CURDATE(), CURDATE(), ?, ?)";
               
              if($stmt = mysqli_prepare($conn, $sql)){
                  // Bind variables to the prepared statement as parameters
                  mysqli_stmt_bind_param($stmt, "ssssssiii",  $param_email, $param_login_id, $param_image_id, $param_address_line_one, $param_state, $param_city, $param_zip, $param_transaction_count, $param_premium_user);
                  
                  $param_email = $email;
                  $param_login_id = $login_id;
                  $param_image_id = $image_id;
                  $param_address_line_one = $address_line_one;
                  $param_state = $state;
                  $param_city = $city;
                  $param_zip  = $zip;
                  $param_transaction_count = $transaction_count;
                  $param_premium_user = $premium_user;
                   
                  
                  // Attempt to execute the prepared statement
                  if(mysqli_stmt_execute($stmt))
                  {
                    
                          if(mysqli_stmt_fetch($stmt))         
                            {
                            header("location: index.php");
                            session_destroy();
                            echo "success";
                            }
                        } 
                      else
                  {
                      echo "Something went wrong. Please try again later.";
                  }
                  // Close statement
                  mysqli_stmt_close($stmt);
              }}
          
          // Close connection
          mysqli_close($conn);
    



















     // Check if Address Line one  is empty
     if(empty(trim($_POST["addressLineTwo"])))
     {   // write error for value
          $password_err = "Please enter your password.";
     }
     else
    {
        $address_line_two = trim($_POST["addressLineTwo"]);

        $sql = "UPDATE mydatabase.users SET address_line_one = '$address_line_two' WHERE login_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            $param_id = $login_id;
        
            if (mysqli_stmt_execute($stmt)) {
                echo "Address updated successfully";
                 
            } else {
                echo "Error updating address: " . mysqli_error($conn);
                
            }
        }
    }
      
    // Check if Address Line one  is empty
    if(empty(trim($_POST["userDescription"])))
    {   // write error for value
        $password_err = "Please enter your password.";
    }
    else
    {
        $user_description = trim($_POST["userDescription"]);

        $sql = "UPDATE mydatabase.users SET user_description = '$user_description' WHERE login_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            $param_id = $login_id;
        
            if (mysqli_stmt_execute($stmt)) {
                echo "Address updated successfully";
                 
            } else {
                echo "Error updating address: " . mysqli_error($conn);
                
            }
        }
    }

}