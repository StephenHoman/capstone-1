<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit();
}
?>
<?php
require_once "dBCred.PHP";
require_once "php_update_user.php";
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

    <title>Hello, world!</title>
  </head>
  <body>
  
  <?
  
  ?>

<!-- Div main will scale with side bar, All divs must reside within--> 
<!-- Div Main Start--> 
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="photos/fillerlogo.jpg" class="img-rounded img-profile embed-responsive " id="profile" alt="profile image"> 
                </a>
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">#<?php echo $_SESSION[
                        "id"
                    ]; ?> - <?php echo $_SESSION["username"]; ?> </span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline"><?php echo $_SESSION[
                                "username"
                            ]; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" role="button" class="nav-link px-0 align-start">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 nav-link px-0 align-middle d-sm-inline">Dashboard</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="ms-1 nav-link px-0 align-middle d-sm-inline">Item</span> 1 </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="ms-1 nav-link px-0 align-middle d-sm-inline">Item</span> 2 </a>
                            </li>
                        </ul>
                    </li>
 
                    <li class="w-100">
       <!-- userModal button --> <a href="#" class="nav-link px-0"> <span class="ms-1 nav-link px-0 align-middle d-sm-inline"><button type="button" class="styledBtn btn btn-primary" data-bs-toggle="modal" data-bs-target="#itemModal">List Item</button></span></a>
                            </li>
                    <li  class="w-100">
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 nav-link px-0 align-middle d-sm-inline">Bootstrap</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="ms-1 nav-link px-0 align-middle d-sm-inline">Item</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="ms-1 nav-link px-0 align-middle d-sm-inline">Item</span> 2</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 nav-link px-0 align-middle d-sm-inline">Settings</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100">
       <!-- userModal button --> <a href="#" class="nav-link px-0"> <span class="ms-1 nav-link px-0 align-middle d-sm-inline"><button type="button" class="styledBtn btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Update Info</button></span></a>
                            </li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1   d-sm-inline"><p class="text-muted"><a href="logout.php">Logout</a></p></span> </a>
                    </li>
                </ul>
                <hr>
                
            </div>
          </div>
        <!-- Div Main  Start-->
        <div class="col py-3">
             

            
        <div class="form-group mb-3">
        <?php if (isset($_SESSION["username"])): ?>
             <?php echo $_SESSION["id"]; ?> 
             <?php echo $_SESSION["username"]; ?> 
             <?php endif; ?>     

        </div>
        
        <div class="text-center mb-3">
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
                            printf(
                                " %d %s %s %d %d %s %s %s %s %d %d %d %d %d \n",
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
                            echo $email . "<br>";
                            $_SESSION["USERID"] = $user_id;
                            $_SESSION["LOGINID"] = $login_id;
                            $_SESSION["IMAGEID"] = $image_id;
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
                    mysqli_stmt_store_result($stmt); // Check if username exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $image_url);
                        while (mysqli_stmt_fetch($stmt)) {
                            $_SESSION["image_url"] = $image_url;
                            printf("%s \n", $image_url);
                        }
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            require_once "checkFK.php";
            ?>
        </div>
        <div class="col py-3">
             
            <div class="container text-center">
            <div class="row">
            <div class="col">
            <img src="<?php echo $_SESSION[
                "image_url"
            ]; ?>" class="img-rounded img-profile embed-responsive " id="profile" alt="profile image"> 
            </div>
            <div class="col">
            Column
            </div>
            <div class="col">
            Column
            </div>
            </div>
            </div>
         
		 




        </div>
        <!-- Div Main  End-->
    </div>
</div>

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
      <?php require_once "insert_item.php"; ?>
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
            <option value="" disabled selected>Select a Category</option>
            <option value="1">Tech</option>
            <option value="2">Other</option>
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
        <input type="submit" value="Cancel" class="btn btn-secondary">
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