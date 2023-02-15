<?php
// Initialize the session
//session_destroy();
session_start();
 
// Tell server that you will be tracking session variables
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: user_page.php");
  exit;
}
?>
 <?php
    require_once("dBCred.PHP");
    require_once("php_login.php");
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

    <!-- JS Scripts -->
    <script src="script.js"></script> 
     
     
   

    <title>Log in</title>
  </head>
  <div class="container text-center   ">
  <div class="row ">

  <div class=" col align-self-start "></div>


    <div class=" col  align-self-center ">
    

    <div class="card menuBG"  >
   
    <div id="carouselLogin" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="photos/landing-images/pexels-erik-mclean-5543136.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="photos/landing-images/pexels-cottonbro-studio-5090640.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="photos/landing-images/pexels-tima-miroshnichenko-6827340.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
</div>





  <div class="card-body ">
    <h5 class="card-title">Signup or login!</h5>
      <!-- Login Modal -->
      <div class="container mt-3 ">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> Login </button>
 </div>
  </div>
</div>
</div><!-- end col -->

<div class="col   align-self-end"></div>

     
     </div><!-- end row --> 
   </div> <!-- end container -->
 
 <!-- The Modal -->
 <div class="modal fade" id="myModal">
   <div class="modal-dialog">
     <div class="modal-content">
       <!-- Modal Header -->
       <div class="modal-header">
         <h4 class="modal-title">Existing user</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
       </div>
       <!-- Modal body -->
       <div class="modal-body">
         <form action="
					<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
           <h3 class="mb-4">Login</h3>
           <div class="input-group mb-3" <?= (!empty($username_err)) ? 'has-error' : ''; ?>>
             <input type="text" class="form-control" name="username" placeholder="username" value="<?= $username; ?>">
           </div>
           <span class="help-block"> <?= $username_err; ?> </span>
           <div class="input-group mb-4" <?= (!empty($password_err)) ? 'has-error' : ''; ?>>
             <input type="password" class="form-control" name="password" placeholder="password" value="<?= $password; ?>">
           </div>
           <span class="help-block"> <?= $password_err; ?> </span>
           <div class="form-group text-left">
             <div class="checkbox checkbox-fill d-inline">
               <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
               <label for="checkbox-fill-a1" class="cr"> Save Details</label>
             </div>
           </div>
           <button class="btn btn-primary shadow-2 mb-4">Login</button>
           <p class="mb-2 text-muted"><a href="signup.php">Create Account</a>
           </p>
            
           </p>
         </form>
       </div>
       <!-- Modal footer -->
       <div class="modal-footer">
         <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>
 <!-- Login Modal -->
 <!--  End       -->

 
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>