<?php
 
 require_once('dBCred.php');

$item_name = $price = $category = $tags = '';
$image_id = $user_id = $category_id = $tag_id = $premium_status = $sold = 0;
$date_posted = date("Y-m-d");
$featured_item = 0;

function uploadProfileImage($photoInput, $conn)  {
    $uploadDir = 'photos/item_image';
    $tempName = $photoInput['tmp_name'];
    $fileName = basename($photoInput['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $hashedName = hash('sha256', time() . $fileName) . '.' . $fileType;
    $targetFile = $uploadDir . '/' . $hashedName;
    $directory =  $targetFile;
    $_SESSION['image_url'] = $targetFile;
    require_once("dBCred.php");

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
            { echo mysqli_error($conn);
                return $directory;
            }
            else
            {echo mysqli_error($conn);
                echo "image Failed- sql error";
            }
        }
     
        return 'photos/profile_image/default.webp';
    
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
    if (isset($_FILES['itemFormFile']) && $_FILES['itemFormFile']['error'] == UPLOAD_ERR_OK) {
        // File was uploaded successfully
        $newFileName = uploadProfileImage($_FILES['itemFormFile'], $conn);
        $_SESSION['item_image_url'] = $newFileName;
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
                            $_SESSION['item_image_id'] = $image_id;
            
                                        }
                                    }}}
                        } else {
                            echo 'Error moving uploaded file.';
            
                        }
                        
            
                    }
                 
            $item_name =  trim($_POST['name']);
            $item_description =  trim($_POST['description']);
            $price =  trim($_POST['price']);
            $category_id = $_POST['category'];
            $tags =  trim($_POST['tags']);
            // $featured_item = $_REQUEST['featured'];

            // hardcoded ids for now to get it to work
            $image_id = $_SESSION['item_image_id'];
            $user_id = trim($_POST['user_id']);

            $tag_id = 104;
            $date_posted = date("Y-m-d");
            $premium_status = 1;
            $featured_item = 0;
            $sold = 0;

            $sql = "insert into items (item_name, item_description, category_id, tag_id, item_price, image_id, user_id,
                                        date_posted, premium_status, featured_item, sold)
                                Values('$item_name', '$item_description', $category_id, $tag_id, $price, $image_id,
                                       $user_id, '$date_posted', $premium_status, $featured_item, $sold)";

echo $sql;
            if ($result = $conn->query($sql) == TRUE) {
        
                $_SESSION['message'] = "item been created sucessfully!";
                


                $sql = "SELECT item_id FROM mydatabase.items WHERE image_id = ?";
            if($stmt = mysqli_prepare($conn, $sql))
            {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_image_id);
                $param_image_id =  $image_id;
                if(mysqli_stmt_execute($stmt))
                { 
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    // Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1)
                    {                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $item_id);
                        while (mysqli_stmt_fetch($stmt)) {
                            $_SESSION['item_id'] = $item_id;
            
                                        }
                                    }}}
                        } else {
                            echo 'Error moving uploaded file.';
            
                        }

                $sql = "INSERT INTO mydatabase.item_images( item_id, image_id) VALUES (?,?) ";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ii", $param_item_id, $param_image_id);
                    
                    // Set parameters
                    $param_item_id = $item_id;
                    $param_image_id =  $image_id ;
                    
                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        
                    } else {
                        echo "error2";
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }


                mysqli_close($conn);
                header("Location: user_page.php");
                exit;
                
                } else {
                echo "<strong>Error: </strong> using SQL: " . $sql . "<br />" . $conn->error;
                }         
                  


 
                    
            




        ?>
        
