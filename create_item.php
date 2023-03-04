<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: index.php");
    exit;
}
?>
	<?php
    require_once("dBCred.PHP");
 
  ?>
		<!doctype html>
		<html lang="en">

		<head>
			<!-- Required meta tags -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
			<!-- Custom Style Sheet -->
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
			<title>Create Item</title>
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
								<a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none"> <img src="photos/profile_image/default.webp" class="img-rounded img-profile embed-responsive " id="profile" alt="profile image"> </a>
								<a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none"> <span class="fs-5 d-none d-sm-inline">#<?php echo $_SESSION['id']; ?> - <?php echo $_SESSION['username']; ?> </span> </a>
								<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
									<li class="nav-item">
										<a href="#" class="nav-link align-middle px-0"> <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline"><?php echo $_SESSION['username']; ?></span> </a>
									</li>
									<li>
										<a href="#submenu1" data-bs-toggle="collapse" role="button" class="nav-link px-0 align-middle"> <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
										<ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
											<li class="w-100">
												<a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a>
											</li>
											<li>
												<a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a>
											</li>
										</ul>
									</li>
									<li>
										<a href="#" class="nav-link px-0 align-middle"> <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
									</li>
									<li>
										<a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle "> <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
										<ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
											<li class="w-100">
												<a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
											</li>
											<li>
												<a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
											</li>
										</ul>
									</li>
									<li>
										<a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle"> <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Categories</span> </a>
										<ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
											<li class="w-100">
												<a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a>
											</li>
										</ul>
									</li>
									<li>
										<a href="#" class="nav-link px-0 align-middle"> <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline"><p class="text-muted"><a href="logout.php">Logout</a></p></span> </a>
									</li>
								</ul>
								<hr> </div>
						</div>

						<!-- Div Main  Start-->
						<div class="col py-3">
                            <div class="form-group mb-3">
                                <?php    
                                $_SESSION['username'] = "stormbatscorpionmars";
                                $_SESSION['id'] = 100;
                                ?>

                                <?php
                                if (isset($_SESSION['username'])) :
                                echo $_SESSION['id'];
                                echo $_SESSION['username'];
								echo $_SERVER['HTTP_REFERER'];
                                endif
                                ?>

								<?php
								if (isset($_SESSION['message'])) {
									echo '<script>alert("Item Successfully Created!")</script>';
									unset($_SESSION['message']);
								}
								?>
							</div>
							<div class="text-center mb-3">
								<div class="card">
									<div class="card-header"> Create an Item </div>
									<div class="card-body">

                                        <!-- Start of form -->
										<form name="itemcreate" action="insert_item.php" method="post">
											<label for="name">Item Name:</label>
                                            <br/>
											<input name="name" type="text" required/>
											<br/>

											<br/>
											<label for="description">Item Description:</label>
											<br/>
											<textarea name="description" cols="45" rows="3" required></textarea>
											<br/>

											<!-- Leaving out images for now -->
											<!--<br/>
											<label for="image">Upload Item Image(s):</label>
											<br/>
											<input name="image" type="file" multiple/>
											<br/>-->

											<br/>
											<label for="price">Price:*</label>
											<br/> $
											<input name="price" type="number" min="0.00" step="0.01" required/>
											<br/>

											<!-- For categories I'm working on a way to populate the options with the categories list in the database -->
											<br/>
											<label for="category">Item Category:*</label>
											<br/>
											<select name="category" required>
												<option value="" disabled selected>Select a Category</option>
												<option value="1">Tech</option>
												<option value="2">Other</option>
											</select>
											<br/>

											<br/>
											<label for="tags">Item Tags:</label>
											<br/>
											<textarea name="tags" cols="30" rows="2" placeholder="Please separate each tag with a comma and a space." required></textarea>
											<br/>

											<br/>
											<label for="featured">Make this your profile's featured item?:</label>
											<br/>
											<input name="featured" type="radio" value="yay" />Yes
											<br/>
											<input name="featured" type="radio" value="nay" checked="checked" />No
											<br/>

											<br/>
											<div>
												<input type="submit" value="Create Item">
												<input type="submit" value="Cancel">
											</div>

                                        </form>
										<!-- End of form -->
									</div>
                                    
                                    <?php
                                    // Prepare a select statement
                                    if($stmt = mysqli_prepare($conn, $sql))
                                    {
                                        //Bind variables to the prepared statement as parameters
                                        mysqli_stmt_bind_param($stmt, "s", $param_id);
                                        $param_id = $_SESSION['id'];
                                        
                                        if(mysqli_stmt_execute($stmt))
                                        { 
                                            // Store result
                                            mysqli_stmt_store_result($stmt);
                                            // Check if username exists, if yes then verify password
                                            if(mysqli_stmt_num_rows($stmt) == 1)
                                            {
                                                // Bind result variables
                                                mysqli_stmt_bind_result($stmt, $user_id, $user_description, $email, $login_id,$image_id, $address_line_one, $address_line_two, $state, $city, $zip_code, $account_creation_date, $last_online, $transaction_count, $premium);
                                                while (mysqli_stmt_fetch($stmt)) {

                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    
                                </div>
							</div>
							<!-- Div Main  End-->
						</div>
					</div>
					<!-- Optional JavaScript -->
					<!-- jQuery first, then Popper.js, then Bootstrap JS -->
					<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
					<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
					<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
		</body>

		</html>