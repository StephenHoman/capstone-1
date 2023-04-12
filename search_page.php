<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit();
}

if (isset($_GET['search'])) {
  // Save the search value in a session variable
  $_SESSION['search'] = $_GET['search'];
  
  // Perform the search
  // ...
} else {
  // The user didn't submit the form, so use the saved search value (if any)
  $search = $_SESSION['search'] ?? '';
}
?>
<?php
require_once "dBCred.PHP";
require_once "php_update_user.php";
require_once('php_messaging.php');
$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : 'items';
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
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
 
      <form class="d-flex" id="searchform" method="GET">
            <input type="text" class="form-control me-2" name="search" placeholder="search here" value="<?php echo $_SESSION['search'] ?? ''; ?>">
            <input type="hidden" name="searchType" value="<?php echo $searchType; ?>">
            <button type="submit" name="save" class="btn btn-outline-success" >Submit</button>
        </form>
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

<!-- Search -->
<?php
$searchResults = array();
$searchErr = '';
$itemResultCount = 0;
$userResultCount = 0;
if(isset($_GET['save']) || isset($_GET['searchType'])) {
    if(!empty($_GET['search'])){
        $searchTerm = "%".$_GET['search']."%";

        $sqlItem = "select i.item_name, i.item_description, i.date_posted, t.tag_name from items i left join item_tags it on it.item_id = i.item_id left join tags t on t.tag_id = it.tag_id where i.item_name like ? or i.item_description like ? or t.tag_name like ?";
        if($stmtItem = mysqli_prepare($conn, $sqlItem)){
            mysqli_stmt_bind_param($stmtItem, 'sss', $search1, $search2, $search3);
            $search1 = $searchTerm;
            $search2 = $searchTerm;
            $search3 = $searchTerm;
            mysqli_stmt_execute($stmtItem);
            mysqli_stmt_bind_result($stmtItem, $item_name, $item_description, $date_posted, $tag_name);
            mysqli_stmt_store_result($stmtItem);
                $itemResultCount = mysqli_stmt_num_rows($stmtItem);
            while (mysqli_stmt_fetch($stmtItem)) {
                $searchResults[] = array(
                    "type" => "item",
                    "name" => $item_name,
                    "description" => $item_description,
                    "date" => $date_posted,
                    "tag" => $tag_name
                );
            }
        }

        $sqlUser = "SELECT user_username FROM login WHERE user_username LIKE ?";
        if($stmtUser = mysqli_prepare($conn, $sqlUser)){
            mysqli_stmt_bind_param($stmtUser, 's', $searchUser);
            $searchUser = $searchTerm;
            mysqli_stmt_execute($stmtUser);
            mysqli_stmt_bind_result($stmtUser, $user_username);
            while (mysqli_stmt_fetch($stmtUser)) {
                $searchResults[] = array(
                    "type" => "user",
                    "name" => $user_username
                );
            }
            $userResultCount = count($searchResults) - $itemResultCount;
        }
    }
}
?>
<div class="col py-3">
 

<script>
  const itemsLink = document.getElementById('items-link');
  const usersLink = document.getElementById('users-link');

  itemsLink.addEventListener('click', () => {
    itemsLink.classList.add('active');
    usersLink.classList.remove('active');
  });

  usersLink.addEventListener('click', () => {
    usersLink.classList.add('active');
    itemsLink.classList.remove('active');
  });

  var searchResults = <?php echo json_encode($searchResults); ?>;
  


</script>
 

 

<div class="nav justify-content-left">
  <ul class="nav justify-content-left">
    <li class="nav-itemUser">
      <a id="items-link" class="nav-linkUser<?php if ($searchType === 'items') echo ' active'; ?>" href="?searchType=items<?php if (isset($_GET['search'])) echo '&search=' . $_GET['search']; ?>">Items</a>
    </li>
    <li class="nav-itemUser">
      <a id="users-link" class="nav-linkUser<?php if ($searchType === 'users') echo ' active'; ?>" href="?searchType=users<?php if (isset($_GET['search'])) echo '&search=' . $_GET['search']; ?>">Users</a>
    </li>
  </ul>
</div>


<?php if ($searchType === 'items') { ?>
  <div>
    <table id="itemTable" width=100% >
      <tr>
        <td width=75%>Item Search Results: <?php echo $itemResultCount; ?></td>
        <td width=25%>User Search Results: <?php echo $userResultCount; ?></td>
      </tr>
      <tr>
        <td width=75%>
          <table>
            <thead>
              <tr>
                <th>Item Name</th>
                <th>Item Description</th>
                <th>Date Posted</th>
                <th>Tags</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($searchResults as $result) {
            if ($result["type"] === "item") { ?>
                <tr>
                    <td><?php echo $result["name"]; ?></td>
                    <td><?php echo $result["description"]; ?></td>
                    <td><?php echo $result["date"]; ?></td>
                    <td><?php echo $result["tag"]; ?></td>
                </tr>  
            <?php }
        } ?>
            </tbody>
          </table>
        </td>
         
      </tr>
    </table>
  </div>
<?php } if($searchType === 'users') { ?>
  <div>
    <table id="userTable"  width=100%>
      <tr>
         
        <td width=25%>User Search Results: <?php echo $userResultCount; ?></td>
      </tr>
      <tr>
        <td width=75%>
          <table>
            <thead>
              <tr>
                <th>User Name</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($searchResults as $result) {
            if ($result["type"] === "user") { ?>
                <tr>
                    <td><?php echo $result["name"]; ?></td>
                </tr>
              
            <?php }
        } ?>
            </tbody>
          </table>
        </td>
        <td width=25%></td>
      </tr>
    </table>
  </div>
<?php } ?>
  </div><!-- Div Main End -->




    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>