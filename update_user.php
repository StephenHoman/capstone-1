<?php
 
// Define variables and initialize with empty values
$user_description = $zip_code = $city = $state = $address_line_two = $address_line_one    = "";
$login_id = $_SESSION['id'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
   




    if (isset($_FILES['formFile']) && $_FILES['formFile']['error'] == UPLOAD_ERR_OK) {
        $image_url = $_SESSION['image_url'];
        // File was uploaded successfully
        $file_name = $_FILES['formFile']['name'];
        $file_tmp_name = $_FILES['formFile']['tmp_name'];
        $file_type = $_FILES['formFile']['type'];
        $file_size = $_FILES['formFile']['size'];
        $upload_dir = 'photos/profile_image';
    
        // Split the path of the old file to get the folder name and the file name
        $old_file_path = $image_url;
        $path_parts = explode("/", $old_file_path);
        $folder_name = $path_parts[1]; // "profile_image"
        $old_file_name = $path_parts[2]; // updates the file name to the one matching this user in the DB
        // Delete the old file (if it exists)
        $old_file_path = $upload_dir . '/' . $old_file_name;
        if (file_exists($old_file_path)) 
        {
            unlink($old_file_path);
        }
        // Construct the new path for the new file
        
        $new_file_path = $upload_dir . '/' . $path_parts[2];;
    
        // Move uploaded file to new location with new name
        if (move_uploaded_file($file_tmp_name, $new_file_path)) {
            // File was moved successfully
    
           
    
            // Do any additional processing as needed
    
            echo 'File was uploaded and replaced successfully.';
        } else {
            echo 'Error moving uploaded file.';
        }
    }



















    // Check if Address Line one  is empty
    if(empty(trim($_POST["addressLineOne"])))
    {   // write error for value
         
    }
    else
    {
        $address_line_one = trim($_POST["addressLineOne"]);

        $sql = "UPDATE mydatabase.users SET address_line_one = '$address_line_one' WHERE login_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            $param_id = $login_id;
        
            if (mysqli_stmt_execute($stmt)) {
                echo "Address updated successfully";
                 
            } else {
                echo "Error updating address: " . mysqli_error($conn);
                mysqli_stmt_close($stmt);
            }
        }
    }
    
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
    if(empty(trim($_POST["state"])))
    {   // write error for value
        $password_err = "Please enter your password.";
    }
    else
    {
        $state = trim($_POST["state"]);

        $sql = "UPDATE mydatabase.users SET users.state = '$state' WHERE login_id = ?";
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
    if(empty(trim($_POST["city"])))
    {   // write error for value
        $password_err = "Please enter your password.";
    }
    else
    {
        $city = trim($_POST["city"]);

        $sql = "UPDATE mydatabase.users SET city = '$city' WHERE login_id = ?";
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
    if(empty(trim($_POST["zip"])))
    {   // write error for value
        $password_err = "Please enter your password.";
    }
    else
    {
        $zip_code = trim($_POST["zip"]);

        $sql = "UPDATE mydatabase.users SET zip = '$zip_code' WHERE login_id = ?";
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


    mysqli_stmt_close($stmt);
                // Redirect user to welcome page
                header("location: user_page.php");
}

