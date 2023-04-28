
<!-- message thread start-->
<?php
session_start();
require_once('dBCred.php');
$recipient_id = $_POST['selected_value'];
$_SESSION['recipient_id'] = $_POST['selected_value'];
// Get the messages between the user and the selected recipient

if(isset($_POST['selected_value']) && isset($_POST['user_id']) ){
    $user_id = $_POST['user_id'];
    $recipient_id = $_POST['selected_value'];
    $_SESSION['recipient_id'] = $recipient_id;
    $sql = "SELECT images.image_url FROM images JOIN users_image ON images.image_id = users_image.image_id WHERE users_image.user_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $recipient_id);
        mysqli_stmt_execute($stmt);
        $imgURL = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($imgURL))
        {
            $URL = $row["image_url"] ;
        }
         
    }
    else{}



$sql = "SELECT * FROM messages WHERE (sender_user_id = ? AND receiver_user_id = ?) OR (sender_user_id = ? AND receiver_user_id = ?) ORDER BY date_time_sent ASC";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "iiii", $user_id, $recipient_id, $recipient_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Loop through the messages and display them
    $prev_sender_id = null;
$current_sender_id = null;
$messages = ""; // message content for current sender

while ($row = mysqli_fetch_assoc($result)) {
    $current_sender_id = $row['sender_user_id'];

    if ($current_sender_id == $prev_sender_id) {
        // same sender, concatenate message
        $messages .= $row["message"] . "<br>";
    } else {
        // new sender, print previous messages and reset message content
        if ($prev_sender_id == $user_id) {
            // user is the sender
            echo '<div class="row">
                    <div class="col-2 "  ></div>
                    <div class="col-1 "  ></div>
                    <div class="col-7 text-end card card_style"  >'.$messages.'</div>
                    <div class="col-2">
                        <img src="'.$_SESSION["image_url"].'" class="rounded-circle img-profile embed-responsive " id="profile" alt="profile image">
                    </div>
                  </div>
                  <br></br>
                  ';
                  
        }  else {
            if($messages)
            {
            echo '<div class="row">
                    <div class="col-2">
                        <img src="'.$URL.'" class="rounded-circle img-profile embed-responsive " id="profile" alt="profile image">
                    </div>
                    <div class="col-7 text-start card card_style"  >'.$messages.'</div>
                    <div class="col-1 "  ></div>
                    <div class="col-2 "  ></div>
                  </div>
                  <br></br>
                  ';
            }
            else{}}
        $messages = $row["message"] . "<br>";
        $prev_sender_id = $current_sender_id;
    }
}
// print out any remaining messages for the last sender
if ($prev_sender_id == $user_id) {
    echo '<div class="row">
            <div class="col-2 "  ></div>
            <div class="col-1 "  ></div>
            <div class="col-7 text-end card card_style"  >'.$messages.'</div>
            <div class="col-2">
                <img src="'.$_SESSION["image_url"].'" class="rounded-circle img-profile embed-responsive " id="profile" alt="profile image">
            </div>
          </div>
          <br></br>
          ';
} else {
    if($messages)
    {
    echo '<div class="row">
            <div class="col-2">
                <img src="'.$URL.'" class="rounded-circle img-profile embed-responsive " id="profile" alt="profile image">
            </div>
            <div class="col-7 text-start card card_style"  >'.$messages.'</div>
            <div class="col-1 "  ></div>
            <div class="col-2 "  ></div>
          </div>
          <br></br>
          ';
    }
    else{}
}


    mysqli_stmt_close($stmt);
}
}
?>

                <!-- message thread end --> 
