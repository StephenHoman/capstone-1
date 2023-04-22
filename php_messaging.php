<?php

//this needs something to get user images, and each piece might needs some work to be put together -NS




function send_Message($user_id, $reciever_id, $message, $conn){
    //sends a message from one user to another.
    $sql = "INSERT INTO messages (sender_user_id, receiver_user_id, message, date_time_sent) VALUES
    (". $user_id .",". $reciever_id . "," . $message . "," . date('Y-m-d H:i:s') . ");";
    $result = mysqli_query($conn, $sql);
}





function getMessages($user_id, $conn){

    // SQL query to select messages for the user ID entered
    $sql = "SELECT * FROM messages WHERE sender_user_id = $user_id OR receiver_user_id = $user_id";
    // Execute SQL query
    $result = mysqli_query($conn, $sql);
    // Check if query was successful
    if ($result) {
        // Fetch all rows as an array
        $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // Free result set
        mysqli_free_result($result);
        mysqli_close($conn);
        
        // Return messages array
        return $messages;
    } else {
        //error text
        echo "Error executing query: " . mysqli_error($conn);
        return array();
    }
    }




function createConversation($conversation, $user_id, $user_img, $other_img){
    //outputs an entire series of messages as a conversation. 
    foreach ($conversation as $message) {
        if($message['sender_user_id']==$user_id){
            displaySentMessage($user_img, $message['message']);
        }else{
            displayRecievedMessage($other_img, $message['message']);
        }
    }
}

function displayRecievedMessage($imageUrl, $message){
    //returns a row with a user profile picture, and a message, alligns left. 
    echo 
    '<div class="media">
    <div class="media-left">
    <div class="panel-body">
      <img src="'. $imageUrl.'" class="media-object pull-left" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;" alt="User">
    </div>
    </div>
    <div class="media-body">
    <div class="well">'.$message.'</div>
    </div>
  </div>'
  ;
}

function displaySentMessage($imageUrl, $message){
            //returns a row with a user profile picture, and a message, alligns right. 
    echo 
    '<div class="media">
    <div class="media-body">
        <div class="well">'.$message.'</div>
    </div>
    <div class="media-right">
        <div class="panel-body">
            <img src="'. $imageUrl.'" class="media-object pull-right" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;" alt="User">
        </div>
    </div>
</div>'
  ;
}


  ?>