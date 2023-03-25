<?php


function testConversation(){
    //message_id | sender_user_id | receiver_user_id | message | date_time_sent 	
    $conversation = array(
        array(
            "message_id" => 01,
            "sender_user_id" => 19,
            "receiver_user_id" => 22,
            "message" => "can I buy this thing?",
            "date_time_sent" => 22,
        ),
        array(
            "message_id" => 02,
            "sender_user_id" => 22,
            "receiver_user_id" => 19,
            "message" => "Yes, but it costs money!",
            "date_time_sent" => 23,
        ),
        array(
            "message_id" => 03,
            "sender_user_id" => 19,
            "receiver_user_id" => 22,
            "message" => "How much money?",
            "date_time_sent" => 24,
        ),
        array(
            "message_id" => 04,
            "sender_user_id" => 22,
            "receiver_user_id" => 19,
            "message" => "It costs 10 United States Dollars",
            "date_time_sent" => 25,
        ),
        array(
            "message_id" => 05,
            "sender_user_id" => 19,
            "receiver_user_id" => 22,
            "message" => "Will you do 5 United States Dollars?",
            "date_time_sent" => 26,
        ),
        array(
            "message_id" => 06,
            "sender_user_id" => 22,
            "receiver_user_id" => 19,
            "message" => "You drive a hard bargain! But yes, I will do 5 dollarz",
            "date_time_sent" => 27,
        )
        );  
        return $conversation; 
}

function createConversation($conversation, $user_id){
    //this works, but it needs a way to pull user images from the database. I included dummy images from my computer for this part.
    $user_img = 'CAT.jpg';
    $other_img = 'QUEEN.jpg';
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

function runTest(){
    createConversation(testConversation(), 22);
}


  ?>