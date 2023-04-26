<?php
require_once "dBCred.PHP";

// Get the item name from POST
$itemName = mysqli_real_escape_string($conn, $_POST["itemName"]);

// Start a transaction
mysqli_begin_transaction($conn);

try {
  // Delete the item images from the item_images table
  $sql = "DELETE FROM item_images WHERE item_id = (SELECT item_id FROM items WHERE item_name = '$itemName')";
  mysqli_query($conn, $sql);

  // Delete the item from the items table
  $sql = "DELETE FROM items WHERE item_name = '$itemName'";
  mysqli_query($conn, $sql);

  
  // Delete the orphaned images from the images table
    $sql = "DELETE FROM images WHERE image_id NOT IN (SELECT image_id FROM item_images)";
    mysqli_query($conn, "START TRANSACTION");
    mysqli_query($conn, "DELETE FROM item_images WHERE image_id NOT IN (SELECT image_id FROM item_images)");
    mysqli_query($conn, $sql);
    mysqli_query($conn, "COMMIT");

  // Commit the transaction
  mysqli_commit($conn);

  echo "Item deleted successfully";
  
} catch (Exception $e) {
  // Roll back the transaction if there's an error
  mysqli_rollback($conn);

  echo "Error deleting item: " . $e->getMessage();
}

// Close the database connection
mysqli_close($conn);
?>
