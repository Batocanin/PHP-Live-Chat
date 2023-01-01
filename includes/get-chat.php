<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.inc.php";
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";

        $getAllMessages = "SELECT * FROM messages 
        LEFT JOIN users ON users.unique_id = messages.outgoing_message_id
        WHERE (outgoing_message_id = {$outgoing_id} AND incoming_message_id = {$incoming_id}) OR (outgoing_message_id = {$incoming_id} AND incoming_message_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conn, $getAllMessages);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_message_id'] === $outgoing_id){ // ukoliko je ovo tacno onda je on message sender
                    $output .= '
                    <div class="chat outgoing">
                        <div class="details">
                            <p>'. $row['message'] .'</p>
                        </div>
                    </div>';
                } else { // on prima message
                    $output .= '<div class="chat incoming">
                        <img src="images/profile_images/'. $row['image'] .'" alt="">
                        <div class="details">
                        <p>'. $row['message'] .'</p>
                        </div>
                    </div>';
                }
            }
            echo $output;
        }
    } else {
        header('Location: ../login.php');
    }

?>