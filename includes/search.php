<?php
session_start();
include_once "config.inc.php";
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$outgoing_id = $_SESSION['unique_id'];
$output = '';
$getUserSearch = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND firstname LIKE '%{$searchTerm}%' OR lastname LIKE '%{$searchTerm}%'");
if(mysqli_num_rows($getUserSearch) > 0){
    while($row = mysqli_fetch_assoc($getUserSearch)){
        $outgoing_id = $_SESSION['unique_id'];
        $getLastMessage = "SELECT * FROM messages WHERE (incoming_message_id = {$row['unique_id']} OR outgoing_message_id = {$row['unique_id']}) AND (outgoing_message_id = {$outgoing_id} OR incoming_message_id = {$outgoing_id}) ORDER by msg_id DESC LIMIT 1";
        $query = mysqli_query($conn, $getLastMessage);
        $lastMessage = mysqli_fetch_assoc($query);
        if(mysqli_num_rows($query) > 0){
            $result = $lastMessage['message'];
        } else {
            $result = "No message available";
        }
        (strlen($result) > 28) ? $message = substr($result, 0, 28).'...' : $message = $result;
        ($outgoing_id == $lastMessage['outgoing_message_id']) ? $you = "You: " : $you = "";
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        $output .= '
        <a href="chat.php?user_id='. $row['unique_id'] .'">
            <div class="content">
                <img src="images/profile_images/'. $row['image'] .'" alt="">
                <div class="details">
                    <span>'. $row['firstname'] . " " . $row['lastname'] .'</span>
                    <p>'. $you . $message .'</p>
                </div>
            </div>
            <div class="status-dot"><i class="fas fa-circle"></i></div>
        </a>';
    }
} else {
    $output .= "No user found related to your search term";
}
echo $output;