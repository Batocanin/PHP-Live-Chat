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
        <section class="chat-area">
            <header>
                <?php 
                include_once 'includes/config.inc.php';
                $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                $getUser = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
                if(mysqli_num_rows($getUser) > 0){
                    $user = mysqli_fetch_assoc($getUser);
                }
                ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="images/profile_images/<?php echo $user['image'] ?>" alt="">
                <div class="details">
                    <span><?php echo $user['firstname'] . " " . $user['lastname'] ?></span>
                    <p><?php echo $user['status'] ?></p>
                </div>
            </header>
            <div class="chat-box">
            </div>
            <form action="" class="typing-area" autocomplete="off">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" >
                <input type="text" name="incoming_id" value="<?php echo $user_id ?>" >
                <input type="text" name="message" class="input-field" placeholder="Type a message here...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <script src="js/chat.js"></script>
</body>
</html>