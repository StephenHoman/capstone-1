<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit();
}
// Get the current URL query parameters
$queryParams = $_GET;

// Check if the required parameters are present
if (isset($queryParams['search']) && isset($queryParams['searchType']) && isset($queryParams['save'])) {
    // Set the boolean value to true
    $booleanValue = true;
} else {
    // Set the boolean value to false
    $booleanValue = false;
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
          <a class="nav-link" href="user_page.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Search</a>
        </li>
      </ul>
 
      <form class="d-flex" id="searchform" method="GET">
            <input type="text" class="form-control me-2" name="search" placeholder="search here" value="<?php echo $_SESSION['search'] ?? ''; ?>">
            <input type="hidden" name="searchType" value="<?php echo $searchType; ?>">
            <button type="submit" name="save" class="btn btn-outline-success" >Submit</button>
      <!--  </form> -->
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
                        <a href="user_page.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline"><?php echo $_SESSION["username"]; ?></span>
                        </a>
                    </li>
                </ul>
                <hr>
            </div>
          </div>

<!-- Search -->
<?php
$searchErr = '';
 
$itemResultCount = 0;
$userResultCount = 0;
$searchResults = array();
$searchResultsItems = array();
$searchResultsUsers = array();
$itemSuccess = false; // success token for item search
$userSuccess = false; // success token for user search

if(isset($_GET['save']) || isset($_GET['searchType'])) {
    if(!empty($_GET['search'])){
        $searchTerm = "%".$_GET['search']."%";

        $sqlItem = "select i.item_name, i.item_description, i.date_posted, t.tag_name, c.category_id, c.category_name from items i left join item_tags it on it.item_id = i.item_id left join tags t on t.tag_id = it.tag_id left join category c on c.category_id = i.category_id where i.item_name like ? or i.item_description like ? or t.tag_name like ? or c.category_name like ?";
        if($stmtItem = mysqli_prepare($conn, $sqlItem)){
            mysqli_stmt_bind_param($stmtItem, 'ssss', $search1, $search2, $search3, $search4);
            $search1 = $searchTerm;
            $search2 = $searchTerm;
            $search3 = $searchTerm;
            $search4 = $searchTerm;
            mysqli_stmt_execute($stmtItem);
            if(mysqli_stmt_error($stmtItem)) {
                $searchErr = "Error executing item search query: " . mysqli_stmt_error($stmtItem);
            }
            else {
                mysqli_stmt_bind_result($stmtItem, $item_name, $item_description, $date_posted, $tag_name, $category_id, $category_name);
                mysqli_stmt_store_result($stmtItem);
                $itemResultCount = mysqli_stmt_num_rows($stmtItem);
                while (mysqli_stmt_fetch($stmtItem)) {
                    $searchResults[] = array(
                        "type" => "item",
                        "name" => $item_name,
                        "description" => $item_description,
                        "date" => $date_posted,
                        "tag" => $tag_name,
                        "catid" => $category_id,
                        "category" => $category_name
                    );
                }
                $itemSuccess = true;
            }
        }
        else {
            $searchErr = "Error preparing item search statement: " . mysqli_error($conn);
        }

        $sqlUser = "SELECT user_username, login_id FROM login WHERE user_username LIKE ?";
        if($stmtUser = mysqli_prepare($conn, $sqlUser)){
            mysqli_stmt_bind_param($stmtUser, 's', $searchUser);
            $searchUser = $searchTerm;
            mysqli_stmt_execute($stmtUser);
            if(mysqli_stmt_error($stmtUser)) {
                $searchErr = "Error executing user search query: " . mysqli_stmt_error($stmtUser);
            }
            else {
                mysqli_stmt_bind_result($stmtUser, $user_username, $user_loginID);
                while (mysqli_stmt_fetch($stmtUser)) {
                    $searchResults[] = array(
                        "type" => "user",
                        "name" => $user_username,
                        "id"  => $user_loginID
                    );
                }
                $userSuccess = true;
                $userResultCount = count($searchResults) - $itemResultCount;
            }
        }
        else {
            $searchErr = "Error preparing user search statement: " . mysqli_error($conn);
        }

        $sqlCategory = "select category_id, category_name from category order by category_name";
        if($stmtCategory = mysqli_prepare($conn, $sqlCategory)){
          mysqli_stmt_execute($stmtCategory);
          if(mysqli_stmt_error($stmtCategory)) {
            $searchErr = "Error executing category query: " . mysqli_stmt_error($stmtCategory);
        }
        else {  
          mysqli_stmt_bind_result($stmtCategory, $category_category_id, $category_category_name);
          while (mysqli_stmt_fetch($stmtCategory)) {
              $searchCategoryResults[] = array(
                  "type" => "category",
                  "id"  => $category_category_id,
                  "name" => $category_category_name
              );
          }
          $categorySuccess = true;

        }
        }


            //// added this for pagination, tried to count off from all items 
            // where types were different but couldnt get it to work 
            $searchResultsItems = array();
            $searchResultsUsers = array();
            
              foreach ($searchResults as $result) {
                  if ($result['type'] == 'item' && isset($_GET['categories'])) {
                      $cat_id = $_GET['categories'];
                      if ($cat_id == $result['catid'] || $cat_id == -1) {
                        $searchResultsItems[] = array(
                            "type" => "item",
                            "name" => $result['name'],
                            "description" => $result['description'],
                            "date" => $result['date'],
                            "tag" => $result['tag'],
                            "category" => $result['category']
                        );
                      }
                  } elseif ($result['type'] == 'item') {
                    $searchResultsItems[] = array(
                        "type" => "item",
                        "name" => $result['name'],
                        "description" => $result['description'],
                        "date" => $result['date'],
                        "tag" => $result['tag'],
                        "category" => $result['category']
                    );
                  } elseif ($result['type'] == 'user') {
                    $searchResultsUsers[] = array(
                        "type" => "user",
                        "name" => $result['name'],
                        "id" => $result['id']
                    );
                }

              }
                  
              }//// end of this loop
                  if(count($searchResultsItems) <= 0)
                  {
                    $itemSuccess = false;
                  }
                  if(count($searchResultsUsers ) <= 0)
                  {
                    $userSuccess = false; 
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
 

 
<?php if ((($searchType === 'items' || $searchType === 'users') && (isset($_GET['search']) && $_GET['search'] !== '') && isset($queryParams['search']) && isset($queryParams['searchType']) )) { ?>
  
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
<?php 
} else {?>
    <div class="container"> 
    <div class="row sprite">
    <div class="col"></div>
    <div class="col align-content-center text-center">
      <img src="photos/Greg-magnifying glass.png" class="img-fluid img-cap" alt="Responsive image">
      <h4> Use the search bar to find users or items for sale!</h4>
    </div>
    <div class="col"></div>
  <!-- } ?> -->
  </div>
 
<!-- } ?> -->


  </div>
  <?php } ?>

  <?php if ($searchType === 'items' && isset($_GET['search']) && ($_GET['search'] !== '') && isset($queryParams['search']) && isset($queryParams['searchType'])) {
    echo '<div class="spaced">';
    echo  'Item Search Results: '.$itemResultCount.'<br>' ;
    echo '<label for="categories">Select a Category to refine your search: &nbsp</label>';
    echo '<select name="categories" id="categories" onchange="this.form.submit()">';
      echo '<option value="-1">All Categories</option>';
      foreach ($searchCategoryResults as $Category):
        echo '<option value="'.$Category['id'].'"'; if(isset($_GET['categories']) && $_GET['categories'] == $Category['id']) { echo ' selected ';}  echo '>'.$Category['name'].'</option>';
      endforeach;

    echo '</select>';
    
    echo '</div></br>';
    if( !$itemSuccess)
    { ?>
        <div class="container"> 
        <div class="row sprite">
        <div class="col"></div>
        <div class="col align-content-center text-center">
          <img src="photos/Greg-magnifying glass.png" class="img-fluid img-cap" alt="Responsive image">
          <h4> No Items Found!</h4>
        </div>
        <div class="col"></div>
      </div>
    <?php 
    } 
    if($itemSuccess)
    {
      $item_names = array_column(array_filter($searchResults, function($result) { return $result["type"] === "item"; }), "name");
      $item_names_placeholder = implode(",", array_fill(0, count($item_names), "?"));
      $stmt = mysqli_prepare($conn, "SELECT items.item_name, items.item_price, images.image_url, login.user_username FROM mydatabase.items 
      JOIN mydatabase.images ON items.image_id = images.image_id 
      JOIN mydatabase.users ON items.user_id = users.user_id 
      JOIN mydatabase.login ON users.login_id = login.login_id 
      WHERE items.item_name IN ($item_names_placeholder)");
      mysqli_stmt_bind_param($stmt, str_repeat("s", count($item_names)), ...$item_names);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $item_name, $item_price, $image_url, $user_username);
      $item_images = [];
      while (mysqli_stmt_fetch($stmt)) {
        $item_images[$item_name] = array("image_url" => $image_url, "item_price" => $item_price, "user_username" => $user_username);
      }
      mysqli_stmt_close($stmt);

      // Define the number of items to display per page
      $itemsPerPage = 10;

      // Define the current page number based on the user's request or any default value
      $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

      // Define the searchType and search parameters
      $searchType = isset($_GET['searchType']) ? htmlspecialchars($_GET['searchType']) : '';
      $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

      // Extract a portion of the $searchResults array based on the current page number and the number of items to display per page
      $startIndex = ($currentPage - 1) * $itemsPerPage;
      $pagedResults = array_slice($searchResultsItems, $startIndex, $itemsPerPage);

      // Loop through the extracted portion of the array and generate the HTML for each item
      foreach ($pagedResults as $result):
        if ($result["type"] === "item"): ?>
          <div class="container ">
            <div class="card card_style">
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="col-3">
                    <?php if (isset($item_images[$result["name"]]["image_url"])): ?>
                      <img src="<?php echo $item_images[$result["name"]]["image_url"]; ?>" alt="Item Image" class="img-thumbnail">
                    <?php endif; ?>
                  </div>
                      <div class="col text-center-vert">
                        <div class="row">
                          <div class="col-12">
                              <div class="col-6 text-start"><h4><?php echo $result["name"]; ?></h4></div>
                              <div class="col-6 text-end"><h4>$<?php echo $item_images[$result["name"]]["item_price"]; ?></h4></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12"><p><?php echo $result["description"]; ?></p></div>
                        </div>
                        <div class="row">
                          <div class="col-12"><p>Date Posted: <?php echo $result["date"]; ?></p></div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                          <?php if( $_SESSION["username"] == $item_images[$result["name"]]["user_username"] ) { ?>
                            <p>Posted by:<?php echo $item_images[$result["name"]]["user_username"]; ?> </p>
                          <?php } else {?>
                            <p>Posted by: <a  style="text-decoration:none" href="public_user.php?username=<?php echo $item_images[$result["name"]]["user_username"]; ?>"><?php echo $item_images[$result["name"]]["user_username"]; ?></a></p>
                            <?php }?>
                           </div>
                        </div>
                        <div class="row">
                          <div class="col-12"><p>Tag: <?php echo $result["tag"]; ?></p></div>
                        </div>
                        <div class="row">
                          <div class="col-12"><p>Category: <?php echo $result["category"]; ?></p></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <?php 
        endif; 
        ?>
      <?php 
      endforeach;
      ?>

      <?php 
        $totalPages = ceil(count($searchResultsItems) / $itemsPerPage);

        if ($currentPage > $totalPages && $totalPages > 0) {
          header('Location: ?page=' . $totalPages . (!empty($searchType) ? '&searchType=' . urlencode($searchType) : '') . (!empty($search) ? '&search=' . urlencode($search) : ''));
          exit;
        }

        // Add pagination links or buttons with retained parameters
        if ($totalPages > 1) 
        {
          echo '<ul class="pagination">';
          for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = $i === $currentPage ? 'active' : '';
            $url = '?page=' . $i;
            if (!empty($searchType)) {
              $url .= '&searchType=' . urlencode($searchType);
            }
            if (!empty($search)) {
              $url .= '&search=' . urlencode($search);
            }
            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
          }
          echo '</ul>';
        }

      ?>

    
    <?php
    }
    ?>  
  <?php 
  } 
  ?>
 

<?php
if ($searchType === 'users' && ($_GET['search'] !== '') && isset($queryParams['search']) && isset($queryParams['searchType'])) {
  echo '<div class="spaced">';
  echo  'User Search Results: '.$userResultCount ;
  echo '</div>';
  if( !$userSuccess)
  { ?>
    <div class="container"> 
    <div class="row sprite">
    <div class="col"></div>
    <div class="col align-content-center text-center">
      <img src="photos/Greg-magnifying glass.png" class="img-fluid img-cap" alt="Responsive image">
      <h4> No Users Found!</h4>
    </div>
    <div class="col"></div>
  </div>
  <?php
  }
  if($userSuccess){
  // Prepare a single select statement to retrieve image_url for all users in $searchResults
  $user_ids = array_column(array_filter($searchResults, function($result) { return $result["type"] === "user"; }), "id");
  $user_ids_placeholder = implode(",", array_fill(0, count($user_ids), "?"));
  $stmt = mysqli_prepare($conn, "SELECT login_id, image_url FROM mydatabase.users JOIN mydatabase.images ON users.image_id = images.image_id WHERE login_id IN ($user_ids_placeholder)");
  mysqli_stmt_bind_param($stmt, str_repeat("s", count($user_ids)), ...$user_ids);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $user_loginID, $image_url);
  $user_images = [];
  while (mysqli_stmt_fetch($stmt)) {
    $user_images[$user_loginID] = $image_url;
  }
  mysqli_stmt_close($stmt);
?>
   <?php
  // Define the number of items to display per page
  $itemsPerPage = 10;

  // Define the current page number based on the user's request or any default value
  $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

  // Define the searchType and search parameters
  $searchType = isset($_GET['searchType']) ? htmlspecialchars($_GET['searchType']) : '';
  $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

  // Extract a portion of the $searchResults array based on the current page number and the number of items to display per page
$startIndex = ($currentPage - 1) * $itemsPerPage;
$pagedResults = array_slice($searchResultsUsers, $startIndex, $itemsPerPage);

// Loop through the extracted portion of the array and generate the HTML for each item
  foreach ($pagedResults as $result):
      if ($result["type"] === "user"): ?>
        <div class="container ">
          <div class="card card_style">
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-3">
                    <?php if (isset($user_images[$result["id"]])): ?>
                      <img src="<?php echo $user_images[$result["id"]]; ?>" alt="User Image" class="img-thumbnail">
                    <?php endif; ?>
                  </div>
                  <div class="col text-center-vert">
                    <div class="row">
                      <div class="col-12">
                        <?php if( $_SESSION["username"] == $result["name"] ) { ?>
                          <h4><?php echo $result['name']; ?> </h4>
                          <?php } else {?>
                            <h4><a  style="text-decoration:none" href="public_user.php?username=<?php echo $result["name"]; ?>"><?php echo $result["name"]; ?></a></h4>
                            <?php }?>
                          </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach;

 
  // Calculate the total number of pages based on the number of items and the items per page, and round up to the nearest integer
  $totalPages = ceil(count($searchResultsUsers) / $itemsPerPage);

  // If the current page is greater than the total number of pages, redirect to the last page
  if ($currentPage > $totalPages && $totalPages > 0) {
    header('Location: ?page=' . $totalPages . (!empty($searchType) ? '&searchType=' . urlencode($searchType) : '') . (!empty($search) ? '&search=' . urlencode($search) : ''));
    exit;
  }

  // Add pagination links or buttons with retained parameters
  if ($totalPages > 1) {
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
      $activeClass = $i === $currentPage ? 'active' : '';
      $url = '?page=' . $i;
      if (!empty($searchType)) {
        $url .= '&searchType=' . urlencode($searchType);
      }
      if (!empty($search)) {
        $url .= '&search=' . urlencode($search);
      }
      echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
    }
    echo '</ul>';
  }}
?>
  

  <?php } ?>
  </div><!-- Div Main End -->

  </form>


    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>