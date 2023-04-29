<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_GET['username'])) {
    header("location: index.php");
    exit();
}
if ( $_SESSION["username"] == $_GET['username']){
    header("location: search_page.php");
}
?>
<?php
    require_once('dBCred.php');
    //require_once "php_update_user.php";
 

?>

<!doctype html>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <title>Search</title>
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
          <a class="nav-link" href="user_page.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Search For Items</a>
        </li>
 
      </ul>
 
    </div>
  </div>
</nav>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="user_page.php" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">#<?php echo $_SESSION["id"]; ?> - <?php echo $_SESSION["username"]; ?> </span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline"><?php echo $_SESSION["username"]; ?></span>
                        </a>
                    </li>
                </ul>
                <hr>
            </div>
          </div>
        <!-- Div Main  Start-->
        <div class="col py-3">
             
        <div class="text-center mb-3">
        <?php
        // Prepare a select statement
$sql = "SELECT u.*
FROM mydatabase.login l
JOIN mydatabase.users u ON l.login_id = u.login_id
WHERE l.user_username = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $_GET['username'];
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

            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            $sql = "SELECT image_url FROM mydatabase.images WHERE image_id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_image_id);
                $param_image_id = $image_id;
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);  
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $image_url);
                        mysqli_stmt_fetch($stmt);
                          
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
}

            ?>
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
                                        <img src="<?php echo $image_url; ?>" class="img-rounded rounded-circle img-profile embed-responsive " id="profile" alt="profile image"> 
                            </div>

                                        
                                        
                                    </div><!--end row -->
                                </div><!--end container -->
                            </div>
                            <!-- Left of User image card end -->
                            <div class="col">
                                <div class="row">
                                            <div class="col-12 profile-card__name">    
                                                <?php echo " " . $_GET['username']; ?>
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
          <br></br>
        <div class="container text-left">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2> Start a conversation <h2>
                </div>
                <div class="col-12 ">
                    <div class="card card_style">
                    <div class="card-body">
                    <div class=" py-3">
             
                    
                        <div>
                        <form id="message-form">
                        <textarea class="form-control" rows="5" id="comment" name="text"></textarea> 
                        <input type="hidden" name="recipient_id" value="<?= $user_id ?>">
                        <input type="hidden" name="sender_id" value="<?= $_SESSION["USERID"] ?>">
                        <button type="submit" name="submit_message">Send Message</button>
                        </form>
                        </div>
                    </div>
                    </div>
                    </div>
             </div>
          
 
<script>
$(function() {
  // Handle form submission using AJAX
  $('#message-form').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: 'php_messages.php',
      data: formData,
      success: function(response) {
        // Handle successful response here (e.g. display a success message)
        console.log(response);
        $("#comment").val("");
      },
      error: function(xhr, status, error) {
        // Handle error response here (e.g. display an error message)
        console.log(xhr.responseText);
        $("#message-status").html(response).addClass("success").fadeIn();
      }
    });
  });
});
</script>
 
 
 
         </div>
        </div>


</div>
</div>
    </div>
    <?php
$user_id; // replace with the desired user ID
$sql = "SELECT item_name, item_description, category_id, tag_id, item_price, image_id, user_id, date_posted, premium_status, featured_item, sold
        FROM items
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


 



    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>