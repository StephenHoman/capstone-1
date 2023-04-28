<?php
    require_once('dBCred.php');



if ((isset($_POST['text']) && isset($_POST['recipient_id']) && isset($_POST['sender_id'])) ) {
  $text = $_POST['text'];
  $recipient_id = $_POST['recipient_id'];
  $sender_id = $_POST['sender_id'];
  $response = array();
  // Insert message into the database
  $sql = "INSERT INTO messages (sender_user_id, receiver_user_id, message, date_time_sent) VALUES (?, ?, ?, NOW())";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "iis", $sender_id, $recipient_id, $text);
    if (mysqli_stmt_execute($stmt)) {
      $response['success'] = true;
    } else {
      $response['success'] = false;
      $response['message'] = "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
  } else {
    $response['success'] = false;
    $response['message'] = "Error: " . mysqli_error($conn);
  }
  
     echo json_encode($response);
}

?>
