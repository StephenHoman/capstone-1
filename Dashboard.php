<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if ((!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) || ($_SESSION["PREMIUM"] != '1') ) {
    header("location: index.php");
    exit();
}
?>
<?php
    require_once('dBCred.php');
    require_once "php_update_user.php";
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <title>Dashboard</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
       
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <H3><a class="nav-link " aria-current="page" href="user_page.php">Home</a></H3>
        </li>
        
        <li class="nav-item align-center">
          <H1><a class="nav-link active" aria-current="page" href="">Dashboard</a></H1>
        </li>
         
      </ul>
       
    </div>
  </div>
</nav>
<!-- PHP CODE BELOW FOR ALL VALUES START --> 
  <?php
// item count 
$sql = "SELECT count('item_id') as count FROM mydatabase.items";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $item_count = $row['count'];
} else {
    echo "0 results";
}
?>
 <?php
// user count 
$sql = "SELECT count('user_id') as count FROM mydatabase.users";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_count = $row['count'];
} else {
    echo "0 results";
}?>
 <?php
// message count 
$sql = "SELECT count('message') as count FROM mydatabase.messages";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $message_count = $row['count'];
} else {
    echo "0 results";
}
// message count
?>
<?php
// Top User  
$sql="SELECT login.user_username, COUNT(items.item_id) AS item_count
FROM mydatabase.items
JOIN mydatabase.users ON items.user_id = users.user_id
JOIN mydatabase.login ON users.login_id = login.login_id
GROUP BY items.user_id
ORDER BY item_count DESC
LIMIT 1";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $max_count = $row['item_count'];
    $bestUser = $row['user_username'];
} else {
    echo "0 results";
}
// Top User 

?>
<?php
 
  ?>
<!-- PHP CODE ABOVE FOR ALL VALUES END -->
<!-- Div main will scale with side bar, All divs must reside within--> 
<!-- Div Main Start--> 
        <div>
        <div class="gutter">
                 <div class="row g-1">
                    <!-- COLUMN1 START --> 
                    <div class="col-2"><div class="card card_style">
                        <div><H5>Item Count:<span><?php echo ' '.$item_count. ' '; ?> </span></H5></div>
                        <div><H5>User Count:<span><?php echo ' '.$user_count. ' '; ?> </span></H5></div>
                        <div><H5>Message Count:<span><?php echo ' '.$message_count. ' '; ?> </span></H5></div>
                        <div><H5>User with most items<span><?php echo ' '.$bestUser.' '.$max_count. ' '; ?> </span></H5></div>

                  
                    </div></div>
                    <!-- COLUMN1 END --> 
                    <!-- COLUMN2 START --> 
                    <div class="col-8"><div class="card card_style">

                    <canvas id="myChart"></canvas>
                    <script>
                        // Get the data from the first query
                        <?php
                        $sql = "SELECT category.category_name, COUNT(items.item_id) as item_count
                                FROM category
                                JOIN items
                                ON  category.category_id = items.category_id
                                GROUP BY category.category_id";

                        $result = mysqli_query($conn, $sql);

                        $categories = array();
                        $item_counts = array();

                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $categories[] = $row['category_name'];
                                $item_counts[] = $row['item_count'];
                            }
                        } else {
                            echo "0 results";
                        }
                        ?>

                        // Get the data from the second query
                        <?php
                        $sql = "SELECT category_name
                                FROM category";

                        $result = mysqli_query($conn, $sql);

                        $all_categories = array();

                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $all_categories[] = $row['category_name'];
                            }
                        } else {
                            echo "0 results";
                        }
                        ?>

                        // Combine the data into a single array
                        var chartData = {
                            labels: <?php echo json_encode($all_categories); ?>,
                            datasets: [{
                                label: 'Number of Items Listed',
                                data: <?php echo json_encode($item_counts); ?>,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        };

                        // Create the chart
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: chartData,
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                    </div></div>
                    <!-- COLUMN2 END --> 



                    <!-- COlUMN3 START -->
                    <div class="col-6"><div class="card card_style">
                    <canvas id="myChart2"></canvas>
                    <script>
                        // Get the data from the users table
                        <?php
                        $sql = "SELECT DATE_FORMAT(account_creation_date, '%b %Y') as month_year, COUNT(user_id) as user_count
                        FROM mydatabase.users GROUP BY month_year";

                        $result = mysqli_query($conn, $sql);

                        $months = array();
                        $user_counts = array();

                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $months[] = $row['month_year'];
                                $user_counts[] = $row['user_count'];
                            }
                        } else {
                            echo "0 results";
                        }
                        ?>

                        // Combine the data into a single array
                        var chartData2 = {
                            labels: <?php echo json_encode($months); ?>,
                            datasets: [{
                                label: 'Number of New User Accounts Created',
                                data: <?php echo json_encode($user_counts); ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        };

                        // Create the chart
                        var ctx2 = document.getElementById('myChart2').getContext('2d');
                        var myChart2 = new Chart(ctx2, {
                            type: 'bar',
                            data: chartData2,
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>






                    </div></div>
                    <!-- COLUMN3 END -->
                    <div class="col-6"><div class="card card_style">
                    <canvas id="dailyPostingsChart"></canvas>
                    <?php
 
                      $sql = "SELECT DATE(date_posted) AS post_date, COUNT(item_id) AS post_count
                              FROM mydatabase.items
                              GROUP BY DATE(date_posted)";

                      $result = mysqli_query($conn, $sql);
                      if (!$result) {
                        echo "Error: " . mysqli_error($conn);
                        exit;
                    }
                    
                      $dates = array();
                      $postCounts = array();

                      while ($row = mysqli_fetch_assoc($result)) {
                          $dates[] = $row['post_date'];
                          $postCounts[] = $row['post_count'];
                      }
                      ?>
                      <script>
   var ctx3 = document.getElementById('dailyPostingsChart').getContext('2d');

   var chart = new Chart(ctx3, {
      type: 'line',

      data: {
         labels: <?php echo json_encode($dates); ?>,

         datasets: [{
            label: 'Daily Postings',
            data: <?php echo json_encode($postCounts); ?>,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: true
         }]
      },

      options: {
         responsive: true,
         title: {
            display: true,
            text: 'Items by day'
         },
         scales: {
            xAxes: [{
               type: 'time',
               time: {
                  unit: 'day'
               },
               display: true,
               scaleLabel: {
                  display: true,
                  labelString: 'Date'
               }
            }],
            yAxes: [{
               display: true,
               scaleLabel: {
                  display: true,
                  labelString: 'Number of Postings'
               }
            }]
         }
      }
   });
</script>



                    </div></div>
                    



                </div>
         <!-- Div Main  End-->
    </div>
</div>
<footer class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <p>&copy;   <?php echo date("Y"); ?></p>
      </div>
    </div>
  </div>
</footer>

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
     
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>  </body>
</html>