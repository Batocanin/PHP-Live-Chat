<?php
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.inc.php";
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    if(isset($user_id)){
        $status = "Offline now";
        $insertLogoutStatus = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$user_id}");
        if($insertLogoutStatus){
            session_unset();
            session_destroy();
            header("Location: ../login.php");
        }
    } else {
        header("Location: ../users.php");
    }
} else {
    header("Location: ../login.php");
}