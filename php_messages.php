<?php
 require_once("dBCred.PHP");
 session_start();

 function getTheseMessages($sender_id, $reciever_id, $conn){
    // construct SQL query
    $sql = "SELECT * FROM messages WHERE sender_id = $sender_id AND receiver_id = $receiver_id";
    // get the first set of messages
    $result = mysqli_query($conn, $sql);
    $messages_recieved = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $messages_recieved[] = $row;
    }
    //then the 2nd
    $sql = "SELECT * FROM messages WHERE sender_id = $receiver_id AND receiver_id = $sender_id";
    $result = mysqli_query($conn, $sql);
    $messages_sent = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $messages_sent[] = $row;
    }   
    $messages = array_merge($messages_recieved, $messages_sent);
    usort($messages, 'compare_dates');

    // close database connection
    mysqli_close($conn);

    // return messages array
    return $messages;

 }

 function compare_dates($a, $b) {
    $a_time = strtotime($a['date_time_sent']);
    $b_time = strtotime($b['date_time_sent']);
    return $a_time - $b_time;
}

function send_message($sender_id, $receiver_id, $message, $date_time, $conn){
    //is message set to auto increment?
    $sql = "INSERT INTO messages (sender_id, receiver_id, message_text, date_time_sent)
        VALUES ($sender_id, $receiver_id, '$message', NOW())";

// execute query
    if (mysqli_query($conn, $sql)) {
    echo "Message added successfully";
    } else {
    echo "Error: " . mysqli_error($conn);
    }



}




 ?>
