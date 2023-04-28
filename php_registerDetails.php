<?php
    require_once('dBCred.php');
    // Define variables and initialize with empty values
$user_description = $zip_code = $city = $state = $address_line_two = $address_line_one    = "";


function uploadProfileImage($photoInput, $conn)  {
    $uploadDir = 'photos/profile_image';
    $defaultImagePath = 'photos/profile_image/default.webp';
    
    // Check if user uploaded an image
    if ($photoInput['error'] == UPLOAD_ERR_OK) {
        $tempName = $photoInput['tmp_name'];
        $fileName = basename($photoInput['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $hashedName = hash('sha256', time() . $fileName) . '.' . $fileType;
        $targetFile = $uploadDir . '/' . $hashedName;
        $directory =  $targetFile;
        
        // Move uploaded file to new location with new name
        if(move_uploaded_file($tempName, $targetFile)){
            // Prepare an insert statement
     
            $sql = "INSERT INTO mydatabase.images (image_id, image_url) VALUES (NULL, ?)";
     
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_image_url);
             
                // Set parameters
                $param_image_url = $directory;
            }
            else{
                echo "failed at line 24";
            }
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            { 
                echo mysqli_error($conn);
                return $directory;
            }
            else
            {
                echo mysqli_error($conn);
                echo "image Failed- sql error";
            }
        }
        return $defaultImagePath;
    } else {
        // Use default image and hash its path
        $hashedName = hash('sha256', time() . $defaultImagePath) . '.webp';
        $targetFile = $uploadDir . '/' . $hashedName;
        $directory = $targetFile;
        
        if (!copy($defaultImagePath, $targetFile)) {
            echo "Failed to copy default image";
            return false;
        }
        
        // Insert default image path into database
        $sql = "INSERT INTO mydatabase.images (image_id, image_url) VALUES (NULL, ?)";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_image_url);
             
            // Set parameters
            $param_image_url = $directory;
        }
        else{
            echo "failed at line 24";
        }
            
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt))
        { 
            echo mysqli_error($conn);
            return $directory;
        }
        else
        {
            echo mysqli_error($conn);
            echo "image Failed- sql error";
        }
        
        return $directory;
    }
}
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
     
        if (isset($_POST['email'])) {
            // File was uploaded successfully
            require_once("dBCred.php");
            $newFileName = uploadProfileImage($_FILES['formFile'], $conn);
            $_SESSION['image_url'] = $newFileName;
            if ($newFileName) {
                // File was uploaded successfully
                echo 'File was uploaded successfully with name ' . $newFileName;
                $sql = "SELECT image_id FROM mydatabase.images WHERE image_url = ?";
                if($stmt = mysqli_prepare($conn, $sql))
                {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_image_url);
                    $param_image_url =  $newFileName  ;
                    if(mysqli_stmt_execute($stmt))
                    { 
                         
                        // Store result
                        mysqli_stmt_store_result($stmt);
                        // Check if username exists, if yes then verify password
                        if(mysqli_stmt_num_rows($stmt) == 1)
                        {                    
                             
                            // Bind result variables
                            mysqli_stmt_bind_result($stmt, $image_id);
                            while (mysqli_stmt_fetch($stmt)) {
                                $_SESSION['image_id'] = $image_id;

                            }
                        }}}
            } else {
                echo 'Error moving uploaded file.';

            }
            

        }
     
    
    



        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) )
        {   
            $user_id          = $_SESSION["id"]; 
            $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';

            $login_id         = trim($_POST["login_id"]);
            $image_id         = $_SESSION['image_id'];
            
            $address_line_one = trim($_POST["addressLineOne"]);
            $state            = trim($_POST["state"]);
            $city             = trim($_POST["city"]);
            $zip              = trim($_POST["zip"]);
            $user_description = trim($_POST["userDescription"]);
            $transaction_count= 0;
            $premium_user     = 0;
            // Prepare an insert statement
              $sql = "INSERT INTO mydatabase.users (user_id, user_description, email, login_id, image_id, address_line_one, users.state, city, zip_code, account_creation_date, last_online, transaction_count, premium_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), CURDATE(), ?, ?)";
               
              if($stmt = mysqli_prepare($conn, $sql)){
                  // Bind variables to the prepared statement as parameters
                  mysqli_stmt_bind_param($stmt, "isssisssiii", $param_user_id, $param_user_description, $param_email, $param_login_id, $param_image_id, $param_address_line_one, $param_state, $param_city, $param_zip, $param_transaction_count, $param_premium_user);
                  $param_user_id = $user_id;
                  $param_user_description = $user_description;
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
                    
                            echo "success";
                
                  }
                      else
                  {
                      echo("Failed to execute the prepared statement: " . mysqli_stmt_error($stmt));
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
        $login_id          = trim($_POST["login_id"]);
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
        $login_id          = trim($_POST["login_id"]);

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


    header("location: index.php");
    session_destroy();

}