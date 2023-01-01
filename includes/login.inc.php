<?php
session_start();
include_once 'config.inc.php';
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(!empty($email) && !empty($password)){
    $getUser = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");
    if(mysqli_num_rows($getUser) > 0){
        $row = mysqli_fetch_assoc($getUser);
        $status = "Active now";
        $insertStatus = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$row['unique_id']}'");
        if($insertStatus){
            $_SESSION['unique_id'] = $row['unique_id'];
            echo 'success';
        }
    } else {
        echo 'Email or Password is incorrect!';
    }
} else {
    echo 'All input fields are required!';
}
