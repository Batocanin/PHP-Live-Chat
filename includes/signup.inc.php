<?php
session_start();
include_once 'config.inc.php';
$firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
$lastName = mysqli_real_escape_string($conn, $_POST['lastname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $checkEmails = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($checkEmails) > 0){
            echo "$email - This email already exist";
        } else {
            if(isset($_FILES['image'])){
                $image_name = $_FILES['image']['name'];
                $temp_image_name = $_FILES['image']['tmp_name'];

                $image_explode = explode('.', $image_name);
                $image_ext = end($image_explode); // uzima poslednji string iz array-a tj extenziju

                $extensions = ['png', 'jpeg', 'jpg', 'gif'];
                if(in_array($image_ext, $extensions) === true){
                    $time = time();
                    $new_image_name = $time.$image_name;
                    if(move_uploaded_file($temp_image_name, "../images/profile_images/".$new_image_name)){ // ako je user upload sliku, nastavlja registraciju
                        $status = "Active now";
                        $random_id = rand(time(), 1000000); // random id za usera

                        $insertUser = mysqli_query($conn, "INSERT INTO users (unique_id, firstname, lastname, email, password, image, status) VALUES ('{$random_id}', '{$firstName}', '{$lastName}', '{$email}', '{$password}', '{$new_image_name}', '{$status}')");
                        if($insertUser){ // ukoliko je user insertovan
                            $selectUser = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                            if(mysqli_num_rows($selectUser) > 0){
                                $row = mysqli_fetch_assoc($selectUser);
                                $_SESSION['unique_id'] = $row['unique_id'];
                                echo "success";
                            }
                        } else {
                            echo "Somethign went wrong!";
                        }
                    }
                } else {
                    echo "Please select an Image file - jpeg, jpg, png, gif!";
                }
            } else {
                echo "Please select an Image file!";
            }
        }
    } else {
        echo "$email - This is not a valid email!";
    }
} else {
    echo "All input field are required!";
}