<?php
    // Include config file
    require_once('DBCred.php');
    // Include register file
    require_once('php_register.php');
    require_once('php_registerDetails.php');
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
     
     
   

    <title>Hello, world!</title>
    <div class="container text-center   ">
  <div class="row ">

  <div class=" col-2 align-self-start "></div>


    <div class=" col-8 align-self-center ">
    

    <div class="card">
  <div class="card-header">
    Featured
  </div>
  <div class="card-body">
  <form action=" php_registerDetails.php" method="POST" enctype="multipart/form-data">
           <h3 class="mb-4"> <?php echo $_SESSION['username']; ?> </h3>
             
 
           <div class="mb-3">
              <label for="formFile" class="form-label">Upload a new Profile Image</label>
                <input class="form-control" type="file" id="formFile" name="formFile"  >
            </div>
                
            <input  type="hidden" id="login_id" name="login_id" value= "<?=$_SESSION['id'];?>" >

            
           <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
            <div class="col-sm-7">
                <input type="text"  class="form-control" id="email" name="email" >
            </div>
            </div>
            
            <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-5 col-form-label">Address Line One</label>
            <div class="col-sm-7">
            <input type="text" class="form-control" id="addressLineOne" name="addressLineOne" placeholder="<?=$address_line_one;?>">
            </div>
            </div>

            <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-5 col-form-label">Address Line Two</label>
            <div class="col-sm-7">
            <input type="text" class="form-control" id="addressLineTwo" name="addressLineTwo" placeholder="<?=$address_line_two;?>">
            </div>
            </div>

            <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-1 col-form-label">State</label>
            <div class="col-sm-2">
            <input type="text" class="form-control" id="state" name="state"  placeholder="<?=$state;?>">
            </div>
            <label for="inputPassword" class="col-sm-1 col-form-label">City</label>
            <div class="col-sm-4">
            <input type="text" class="form-control" id="city" name="city"  placeholder="<?=$city;?>">
            </div>
            <label for="inputPassword" class="col-sm-1 col-form-label">Zip</label>
            <div class="col-sm-3">
            <input type="text" class="form-control" id="zip"name="zip" placeholder="<?=$zip_code;?>">
            </div>
            </div>

            <div class="g-3 row">
            <label for="description" class="col-sm-12 col-form-label">User Description</label>
            <textarea class="form-control" maxlength="200" rows="4" id="userDescription" name="userDescription" placeholder="<?=$user_description;?>"></textarea> 
            <p class="h6 text-muted small">limit 200 Characters</p>
            </div>

              
            
           <button class="btn btn-primary shadow-2 mb-4">Update Info</button>
           
         </form>
  </div>
</div>
</div><!-- end col -->

<div class="col-2  align-self-end"></div>

     
     </div><!-- end row --> 
   </div> <!-- end container -->



 
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
  </html>