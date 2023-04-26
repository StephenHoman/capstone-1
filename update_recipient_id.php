<?php
if (isset($_POST['selected_value'])) {
    $_SESSION['recipient_id']  = $_POST['selected_value'];// Use $recipient_id as needed
}
?>