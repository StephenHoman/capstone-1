<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit();
}
?>
<?php
require_once "dBCred.PHP";
require_once "php_update_user.php";
 require_once('php_messages.php');
$recipient_id = '100'; 
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    <!-- Custom Style Sheet --> 
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- JS Scripts -->
    <script src="script.js"></script> 
    
        <script>
        // fixes sizing issue when page is scaled to under 768px, the profile image would 
        // no longer flex correctly. This bit quickly fixes it. 
        document.addEventListener("DOMContentLoaded", function() {
        size()
          });
          document.addEventListener("resize", function() {
        size();
          });
        </script>
 <?php
            // Prepare a select statement
            $sql = "SELECT * FROM mydatabase.users WHERE login_id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_id);
                $param_id = $_SESSION["id"];
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt); // Check if username exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Bind result variables
                        mysqli_stmt_bind_result(
                            $stmt,
                            $user_id,
                            $user_description,
                            $email,
                            $login_id,
                            $image_id,
                            $address_line_one,
                            $address_line_two,
                            $state,
                            $city,
                            $zip_code,
                            $account_creation_date,
                            $last_online,

                            $transaction_count,
                            $premium
                        );
                        while (mysqli_stmt_fetch($stmt)) {
 
                            $_SESSION["USERID"] = $user_id;
                            $_SESSION["LOGINID"] = $login_id;
                            $_SESSION["IMAGEID"] = $image_id;
                            $_SESSION["PREMIUM"] = $premium;
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
            }
            $sql = "SELECT image_url FROM mydatabase.images WHERE image_id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_id);
                $param_id = $image_id;
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);  
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $image_url);
                        while (mysqli_stmt_fetch($stmt)) {
                            $_SESSION["image_url"] = $image_url;
                         }
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            require_once "checkFK.php";
            ?>
    <title>Home</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <img src="photos/fillerlogo.jpg" class="  img-thumb   " id="profile" alt="profile image"> 
               
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="user_page.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./search_page.php">Search</a>
        </li>
         
      </ul>
       
    </div>
  </div>
</nav>
  <?
  
  ?>

<!-- Div main will scale with side bar, All divs must reside within--> 
<!-- Div Main Start--> 
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                 
                <a href="user_page.php" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">#<?php echo $_SESSION[
                        "id"
                    ]; ?> - <?php echo $_SESSION["username"]; ?> </span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                     <?php if(($_SESSION["PREMIUM"] == '1') )  { ?>
                        <li class="w-100">
                        <a href="Dashboard.php" class="nav-link px-0" >
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 nav-link px-0 align-middle d-sm-inline collapse">Dashboard</span> </a>
                              </span>
                            </a>     
                        
                    
                            </li>
            
                    </li>
                        <?php }?>
                        <!-- message  button -->
                        <li class="w-100">
                    <a href="user_messages.php" class="nav-link px-0" >
                        <i class="fs-4 bi bi-envelope"></i>
                        <span class="ms-1 nav-link px-0 align-middle d-sm-inline collapse">
                        <button type="button" class="styledBtn btn btn-primary">Messages</button>
                        </span>
                    </a>
                            </li>

                    <!-- itemModal button -->
                    <li class="w-100">
                    <a href="#" class="nav-link px-0" data-bs-toggle="modal" data-bs-target="#itemModal">
                        <i class="fs-4 bi bi-plus-circle"></i>
                        <span class="ms-1 nav-link px-0 align-middle d-sm-inline collapse">
                        <button type="button" class="styledBtn btn btn-primary">List Item</button>
                        </span>
                    </a>
                    </li>

                    <!-- userModal button -->
                    <li class="w-100">
                    <a href="#" class="nav-link px-0" data-bs-toggle="modal" data-bs-target="#userModal">
                        <i class="fs-4 bi bi-gear"></i>
                        <span class="ms-1 nav-link px-0 align-middle d-sm-inline collapse">
                        <button type="button" class="styledBtn btn btn-primary">Update Info</button>
                        </span>
                    </a>
                            </li>

                    <!-- logoutModal button -->  
                            <li class="w-100">
                    <a href="#" class="nav-link px-0" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fs-4 bi bi-box-arrow-right"></i>
                                <span class="ms-1 nav-link px-0 align-middle d-sm-inline collapse">
                                <button type="button" class="styledBtn btn btn-primary">Log Out</button>
                                </span>
                        </a>
                            </li>
                            


                </ul>
                <hr>
                
            </div>
          </div>
        <!-- Div Main  Start-->
        <div class="col py-3">
             
        
            
        <div class="form-group mb-3">
      

        </div>
        
        <div class="text-center mb-3">
            
        </div>
        <div class="container text-left">
                <div class="row">
                <div class="col-12 col-sm-10">
                    <div class="card card_style">
                    <div class="card-body">
                    <div class=" py-3">
             
             <div class="container text-left">
                <div class="row">


                            
                            <!-- User image, left of card -->
                            <div class="col-4 col-sm-4 col-md-4 col-xs-5">
                                <div class="container"><!--start container -->
                                <div class="row text-center"><!--start row -->

                                        <div class="col-12">    
                                        <img src="<?php echo $_SESSION["image_url"]; ?>" class="img-rounded rounded-circle img-profile embed-responsive " id="profile" alt="profile image"> 
                            </div>

                                        
                                        
                                    </div><!--end row -->
                                </div><!--end container -->
                            </div>
                            <!-- Left of User image card end -->
                            <div class="col">
                                <div class="row">
                                            <div class="col-12 profile-card__name">    
                                                <?php echo " " . $_SESSION["username"]; ?>
                                            </div>
                                            <div class="col-12 profile-card__name">    
                                                <?php echo $user_description; ?> 
                            </div>
                            
                                </div>    
                              
                                <div class="row">
                            <div class="col">
                                        <strong>Email:</strong> <?php echo $email; ?> 
                            </div>
                                    <div class="col">
                                    <i class="bi bi-geo-alt"></i><?php echo $city . ', ' . $state; ?> 
                                    </div>
                                </div>

                            <div class="row">

                            <div class="col">
                                    <strong>Last Online:</strong> <?php echo $last_online; ?> 
                            </div>
                                <div class="col-12 ">    
                                    <strong>Account Creation Date:</strong> <?php echo $account_creation_date; ?>
                                </div>
                                <div class="col-12  ">    
                                    <strong>Transaction Count:</strong> <?php echo $transaction_count; ?>
                                </div>
                </div>
                </div>
                </div>
             </div>
          
          
 
 
 
 
         </div>
        </div>
</div>
<?php
$user_id; // replace with the desired user ID
$sql = "SELECT item_name, item_description, category_id, tag_id, item_price, image_id, user_id, date_posted, premium_status, featured_item, sold
        FROM Items
        WHERE user_id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
?>
        <div class="container text-left">
            <div class="row">
          
                 <script>

                    </script>
                 
                    <div class="card item_card">
                        <div class="card-header">
                            <div class="container">
                            <div class="row">
                            <div class="col-4 text-start"><?php echo $row['item_name']; ?></div>
                            <div class="col-4 text-center"> </div>
                            <div class="col-4 text-end"><button type="button" class="btn-close  " aria-label="Close" id="<?php echo $row['item_name']; ?>" onclick="deleteItem(this.id)"></button></div>

                            </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="py-3">
                                <div class="row">
                                <div class="col-4 col-sm-4 col-md-4">

                                    <?php
                                      $image_id = $row['image_id'];
                                        $sql2 = "SELECT image_url FROM images WHERE image_id = ?";
                                        if ($stmt2 = mysqli_prepare($conn, $sql2)) {
                                            mysqli_stmt_bind_param($stmt2, 'i', $image_id);
                                            mysqli_stmt_execute($stmt2);
                                            $result2 = mysqli_stmt_get_result($stmt2);
                                            if ($row2 = mysqli_fetch_assoc($result2)) {
                                            $image_url = $row2['image_url'];
                                            } else {
                                            $image_url = "photos/profile_image/default.webp"; // Replace with your default image URL
                                            }
                                            mysqli_stmt_close($stmt2);
                                        } else {
                                            $image_url = "photos/profile_image/default.webp"; // Replace with your default image URL
                                        }
                                        ?>
                                        <img src="<?php echo $image_url; ?>" class="img-rounded  img-item embed-responsive" alt="item image">
                                         </div>


                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col">
                                                <strong>Item Description:</strong> <?php echo $row['item_description']; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <strong>Category ID:</strong> <?php echo $row['category_id']; ?>
                                            </div>
                                            <div class="col">
                                                <strong>Tag ID:</strong> <?php echo $row['tag_id']; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <strong>Item Price:</strong> <?php echo $row['item_price']; ?>
                                            </div>
                                            <div class="col">
                                                <strong>Premium Status:</strong> <?php echo $row['premium_status']; ?>
                                            </div>
                                            <div class="col">
                                                <strong>Featured Item:</strong> <?php echo $row['featured_item']; ?>
                                            </div>
                                            <div class="col">
                                                <strong>Sold:</strong> <?php echo $row['sold']; ?>
                                            </div>
                                            </div>
                                    </div>
                                    </div>
                            </div>

                    </div>
              
            </div>
    </div>
        </div>
<?php 
    }
    mysqli_stmt_close($stmt);
}
?> 


         
        <!-- Div Main  End-->
    </div>
</div>

<!-- Logout Modal Start --> 
<div class="modal" id="logoutModal"  tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Logout?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer">
        <div class="container">
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-primary btn_yes" onclick="window.location.href='logout.php';">Yes</button>
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary btn_no" data-bs-dismiss="modal">No</button>
            </div>
        </div>
        </div>
         
      </div>
    </div>
  </div>
</div>
 
<!-- Logout Modal End --> 



<!-- user info update modal start --> 
<!-- The Modal -->
<div class="modal" id="userModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Info</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <?php  ?>
      <!-- Modal body -->
      <div class="modal-body">
       
         <form action="<?= htmlspecialchars(
             $_SERVER["PHP_SELF"]
         ) ?>" method="POST" enctype="multipart/form-data">
           <h3 class="mb-4"> <?php echo $_SESSION["username"]; ?> </h3>
             
 
           <div class="mb-3">
              <label for="formFile" class="form-label">Upload a new Profile Image</label>
                <input class="form-control" type="file" id="formFile" name="formFile"  >
            </div>



            
           <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $email ?>">
            </div>
            </div>
            
            <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-5 col-form-label">Address Line One</label>
            <div class="col-sm-7">
            <input type="text" class="form-control" id="addressLineOne" name="addressLineOne" placeholder="<?= $address_line_one ?>">
            </div>
            </div>

            <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-5 col-form-label">Address Line Two</label>
            <div class="col-sm-7">
            <input type="text" class="form-control" id="addressLineTwo" name="addressLineTwo" placeholder="<?= $address_line_two ?>">
            </div>
            </div>

            <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-1 col-form-label">State</label>
            <div class="col-sm-2">
            <input type="text" class="form-control" id="state" name="state"  placeholder="<?= $state ?>">
            </div>
            <label for="inputPassword" class="col-sm-1 col-form-label">City</label>
            <div class="col-sm-4">
            <input type="text" class="form-control" id="city" name="city"  placeholder="<?= $city ?>">
            </div>
            <label for="inputPassword" class="col-sm-1 col-form-label">Zip</label>
            <div class="col-sm-3">
            <input type="text" class="form-control" id="zip"name="zip" placeholder="<?= $zip_code ?>">
            </div>
            </div>

            <div class="g-3 row">
            <label for="description" class="col-sm-12 col-form-label">User Description</label>
            <textarea class="form-control" maxlength="200" rows="4" id="userDescription" name="userDescription" placeholder="<?= $user_description ?>"></textarea> 
            <p class="h6 text-muted small">limit 200 Characters</p>
            </div>

              
            
           <button class="btn btn-primary shadow-2 mb-4">Update Info</button>
           
         </form>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- user info update modal end --> 






<!-- messagemodal start --> 
<!-- The Modal -->
<?php
$sql = "SELECT u.user_id, l.user_username 
FROM Login l 
JOIN Users u ON l.login_id = u.login_id 
JOIN Messages m ON (u.user_id = m.sender_user_id OR u.user_id = m.receiver_user_id) AND (m.sender_user_id = ? OR m.receiver_user_id = ?)
WHERE u.user_id != ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
mysqli_stmt_bind_param($stmt, "iii", $user_id, $user_id, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $message_user_id, $message_user_username);
$message_usernames = array();
while (mysqli_stmt_fetch($stmt)) {
 $message_usernames[$message_user_id] = $message_user_username;
}
mysqli_stmt_close($stmt);
}?>
<div class="modal" id="messageModal">
  <div class="modal-dialog">
    <div class="modal-content">
  
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Messages</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <?php  ?>
      <!-- Modal body -->
      <div class="modal-body">
       
             



        <div class="card" style="width: 100%; max-height: 500px;" >
        <div class="col-md-6">
         
        <select name="selected_value" class="form-select" id="select_box">
        <option value="">Select Username</option>
        <?php echo $recipient_id;?>
        <?php foreach($message_usernames as $message_user_id => $message_user_username): ?>
            <option value="<?= $message_user_id ?>"><?= $message_user_username ?></option>
        <?php endforeach; ?>  
        </select>
    
        </div>
  <script>
  // Get a reference to the select element
  var selectBox = document.getElementById("select_box");

  // Add an event listener for the "change" event
  selectBox.addEventListener("change", function() {
    // Get the selected value
    var selectedValue = selectBox.value;

    // Send an AJAX request to update the recipient ID
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "user_messages.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Update the value of $recipient_id
        var recipientId = xhr.responseText;
        console.log(recipientId);
      }
    };
    xhr.send("selected_value=" + selectedValue);
  });
</script>

<?php 
 
 // Check if the selected value was posted

 ?>
 
 
  
    
 
  
        
                <?// this and the next line with overflow-auto are the parts that enable the page to be able to scroll?> 
        <div class="card" style="width: 100%; max-height: 500px;" > <?// this and the next line with overflow-auto are the parts that enable the page to be able to scroll?> 
                <div class="card-body overflow-auto">
      <div class="container "><?// container  ?> 
                 
                <!-- message thread start-->
                <?php
// Get the messages between the user and the selected recipient
$sql = "SELECT * FROM Messages WHERE (sender_user_id = ? AND receiver_user_id = ?) OR (sender_user_id = ? AND receiver_user_id = ?) ORDER BY date_time_sent ASC";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "iiii", $user_id, $recipient_id, $recipient_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Loop through the messages and display them
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine the sender and recipient
        if($row['sender_user_id'] == $user_id)
        {?>
            <div class="row"> 
            <div class="col-2 " style="background-color: pink;">
             
            </div>

            <div class="col-1 " style="background-color: pink;">
             
            </div>

            <div class="col-7 text-end" style="background-color: green;">
            <?php echo $row["message"]; ?>
            </div>

            <div class="col-2">
            <img src="Session User" class="rounded-circle img-profile embed-responsive " id="profile" alt="profile image"> 
            </div>
            </div>
            <?
        }else 
        {
            ?>
            <div class="row">  
                    <div class="col-2">
                        <img src="recipient image " class="rounded-circle img-profile embed-responsive " id="profile" alt="profile image"> 
                    </div>
                    <div class="col-7 text-start" style="background-color: green;">
                            <?php echo $row["message"]; ?>
                    </div>
                    <div class="col-1 " style="background-color: pink;">
                     
                    </div>
                    <div class="col-2 " style="background-color: pink;">
                             
                            </div>
                  
                </div>
            <?php
        }
         
 
    }

    mysqli_stmt_close($stmt);
}
?> 
                <!-- message thread end --> 


       </div><?// container  ?> 
        </div><?//end card ?>
            </div><?//end card body ?>
            
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">
            <textarea class="form-control" rows="5" id="comment" name="text"></textarea> 
            <input type="hidden" name="recipient_id" value="<?= $recipient_id ?>">
            <input type="hidden" name="sender_id" value="<?= $user_id ?>">
            <button type="submit" name="submit_message">Send Message</button>
            </form>
 
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
    </div>
    </div></div>
<!-- message modal end --> 









<!-- Get Category data for form drop down -->
<?php
    $sql = "SELECT category_id, category_name FROM mydatabase.category";
    $all_categories = mysqli_query($conn,$sql);
?>

<!-- Item List modal start --> 
<!-- The Modal -->
<div class="modal" id="itemModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">List Item </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <?php //require_once "insert_item.php"; ?>
      <!-- Modal body -->
      <div class="modal-body">
       
          <h3 class="mb-4"> <?php echo $_SESSION["username"]; ?> </h3>
          <div class="text-center mb-3">
								<div class="card">
									<div class="card-header"> Create an Item </div>
									<div class="card-body">

                                        <!-- Start of form -->
										<form action="insert_item.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION[
                                            "USERID"
                                        ]; ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Item Name:</label>
        <input name="name" type="text" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="itemFormFile" class="form-label">Upload a new Profile Image</label>
        <input class="form-control" type="file" id="itemFormFile" name="itemFormFile">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Item Description:</label>
        <textarea name="description" cols="45" rows="3" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price:*</label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input name="price" type="number" min="0.00" step="0.01" class="form-control" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Item Category:*</label>
        <select name="category" class="form-select" required>
            <option value="default" selected disabled>Please select an item category</option>
            <?php
                while ($category = mysqli_fetch_array(
                        $all_categories,MYSQLI_ASSOC)):;
            ?>
            <option value="<?php echo $category["category_id"]; ?>">
                <?php echo $category["category_name"]; ?>
            </option>
            <?php
                endwhile;
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="tags" class="form-label">Item Tags:</label>
        <textarea name="tags" cols="30" rows="2" class="form-control" placeholder="Please separate each tag with a comma and a space." required></textarea>
    </div>

    <div class="mb-3">
        <label for="featured" class="form-label">Make this your profile's featured item?:</label>
        <div class="form-check">
            <input name="featured" type="radio" value="yay" id="featured-yes" class="form-check-input">
            <label for="featured-yes" class="form-check-label">Yes</label>
        </div>
        <div class="form-check">
            <input name="featured" type="radio" value="nay" id="featured-no" class="form-check-input" checked>
            <label for="featured-no" class="form-check-label">No</label>
        </div>
    </div>

    <div>
        <input type="submit" value="Create Item" class="btn btn-primary">
    </div>

                                        </form>
										<!-- End of form -->
									</div>
    
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Item List modal end --> 






    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>