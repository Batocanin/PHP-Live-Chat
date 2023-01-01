<?php 
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'live-chat';
    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if(!$conn){
        echo 'Connection problem with database' . mysqli_connect_error($conn);
    }