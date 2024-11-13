<?php
session_start();
include("db.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username  = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $res = $conn->query($sql);

    if($res->num_rows > 0){
        $_SESSION['username'] = $username;
    }
}

if(isset($_SESSION['username'])){
    $message = 'Welcome ' . $_SESSION['username'] . '!';
    header('Location: home.php');
}else{
    $message = 'Login failed';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login Page</h1>
    <?php if(isset($message)):?>
        <h1><?php echo $message?></h1>
    <?php endif;?>
    <form action="login.php" method="post">
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>
        <input type="submit" name="login" value="LOGIN">
    </form>
    <form action="logout.php">
        <input type="submit" name="logout" value="LOGOUT">
    </form>
    <form action="register.php">
        <input type="submit" name="register" value="REGISTER">
    </form>
</body>
</html>