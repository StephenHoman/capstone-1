<?php
    // Initialize the session
    session_start();
   
?>
<?php
    require_once("dBCred.PHP");
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Store Item Data</title>
   </head>

   <body>
        <center>
        <?php
            $item_name = $_REQUEST['name'];
            $item_description = $_REQUEST['description'];
            $price = $_REQUEST['price'];
            $category = $_REQUEST['category'];
            $tags = $_REQUEST['tags'];
            // $featured_item = $_REQUEST['featured'];

            // hardcoded ids for now to get it to work
            $image_id = 100;
            $user_id = $_SESSION['id'];
            $category_id = 101;
            $tag_id = 104;
            $date_posted = date("Y-m-d");
            $premium_status = 1;
            $featured_item = 0;
            $sold = 0;

            $sql = "insert into Items (item_name, item_description, category_id, tag_id, item_price, image_id, user_id,
                                        date_posted, premium_status, featured_item, sold)
                                Values('$item_name', '$item_description', $category_id, $tag_id, $price,$image_id,
                                       $user_id, '$date_posted', $premium_status, $featured_item, $sold)";


            if ($result = $conn->query($sql) == TRUE) {
        
                $_SESSION['message'] = "item been created sucessfully!";
                mysqli_close($conn);
                header("Location: create_item.php");
                exit;
                
                } else {
                echo "<strong>Error: </strong> using SQL: " . $sql . "<br />" . $conn->error;
                }         
                  

        ?>
        
    </body>

</html>