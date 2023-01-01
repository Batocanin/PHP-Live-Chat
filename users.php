<?php 
session_start();
if(!isset($_SESSION['unique_id'])){
    header('Location: login.php');
}
?>

<?php 
    include_once 'includes/header.php';
?>
<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php 
                include_once 'includes/config.inc.php';
                $getUser = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                if(mysqli_num_rows($getUser) > 0){
                    $user = mysqli_fetch_assoc($getUser);
                }
                ?>
                <div class="content">
                        <img src='images/profile_images/<?php echo $user['image'] ?>' alt="">
                        <div class="details">
                            <span><?php echo $user['firstname'] . " " . $user['lastname'] ?></span>
                            <p><?php echo $user['status'] ?></p>
                        </div>
                    </div> 
                    <a href="includes/logout.php?user_id=<?php echo $user['unique_id'] ?>" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
            </div>
        </section>
    </div>

    <script src="js/users.js"></script>
</body>
</html>