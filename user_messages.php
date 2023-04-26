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
require_once "update_recipient_id.php";
require_once('php_messages.php');
  
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

    <title>Messages</title>
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
          <a class="nav-link " aria-current="page" href="user_page.php">Dashboard</a>
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
            
                        <li class="nav-item">
                        <a href="user_page.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline"><?php echo $_SESSION["username"]; ?></span>
                        </a>
                    </li>
                        <!-- messageModal button -->
                        <li class="w-100">
                    <a href="user_messages.php" class="nav-link px-0" >
                        <i class="fs-4 bi bi-envelope"></i>
                        <span class="ms-1 nav-link px-0 align-middle d-sm-inline collapse">
                        <button type="button" class="styledBtn btn btn-primary">Messages</button>
                        </span>
                    </a>
                            </li>

             
                            


                </ul>
                <hr>
                
            </div>
          </div>
        <!-- Div Main  Start-->
        <div class="col py-3">
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
                           /* printf(
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
                            echo $email . "<br>";*/
                            $_SESSION["USERID"] = $user_id;
                            $_SESSION["LOGINID"] = $login_id;
                            $_SESSION["IMAGEID"] = $image_id;
                            $_SESSION["PREMIUM"] = $premium;
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
            }
        ?>
           
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
 
        <div class="card" style="width: 100%; max-height: 500px;" >
        <div class="col-md-6">
         
        <select name="selected_value" class="form-select" id="select_box">
        <option value="">Previous Conversations</option>
        <?php echo $recipient_id;?>
        <?php foreach($message_usernames as $message_user_id => $message_user_username): ?>
            <option value="<?= $message_user_id ?>"><?= $message_user_username ?></option>
        <?php endforeach; ?>  
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        </select>
    
        </div>
        <script>
  // Get a reference to the select element
  var selectBox = document.getElementById("select_box");

  // Add an event listener for the "change" event
  selectBox.addEventListener("change", function() {
    // Get the selected value
    var selectedValue = selectBox.value;

    // Send an AJAX request to update the recipient ID and load the messages
    $.ajax({
      url: "user_message_thread.php",
      type: "POST",
      data: {
        selected_value: selectedValue,
        user_id: <?php echo $user_id; ?>
      },
      success: function(response) {
        // Replace the contents of the container with the loaded messages
        $( "div.demo-container" ).html(response);
      },
      error: function() {
        alert("Failed to load messages.");
      }
    });
  });
  // Refresh the messages every 5 seconds
  setInterval(function() {
    var selectedValue = selectBox.value;
    $.ajax({
      url: "user_message_thread.php",
      type: "POST",
      data: {
        selected_value: selectedValue,
        user_id: <?php echo $user_id; ?>
      },
      success: function(response) {
        // Replace the contents of the container with the loaded messages
        $( "div.demo-container" ).html(response);
      },
      error: function() {
        alert("Failed to load messages.");
      }
    });
  }, 1000); // 5000 milliseconds = 5 seconds

</script>
 
<?php 
 
 // Check if the selected value was posted
 if(isset($_SESSION['recipient_id'])){
 $recipient_id = $_SESSION['recipient_id'];
}
 ?>

        
                <?// this and the next line with overflow-auto are the parts that enable the page to be able to scroll?> 
        <div class="card" style="width: 100%; max-height: 500px;" > <?// this and the next line with overflow-auto are the parts that enable the page to be able to scroll?> 
                <div class="card-body overflow-auto">
      <div class="container "><?// container  ?> 
      <div class="demo-container"> </div>
            <!-- Jquery will put messages here from User_message_thread.php --> 
       </div><?// container  ?> 
        </div><?//end card ?>
            </div><?//end card body ?>
            <form id="message-form">
            <textarea class="form-control" rows="5" id="comment" name="text"></textarea> 
            <input type="hidden" name="recipient_id" value="<?= $recipient_id ?>">
            <input type="hidden" name="sender_id" value="<?= $user_id ?>">
            <button type="submit" name="submit_message">Send Message</button>
        </form>


 
      </div>

       

  </div>
    </div>
    </div></div>
<!-- message modal end --> 



             
         
        <!-- Div Main  End-->
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

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
     
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>