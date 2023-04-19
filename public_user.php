<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_GET['username'])) {
    header("location: index.php");
    exit();
}

?>
<?php
require_once "dBCred.PHP";
require_once "php_update_user.php";

require_once('php_messages.php');

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
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
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
          
          
 
 
 
 
         </div>
        </div>
</div>

 



    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>