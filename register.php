<?php
session_start();
include("db.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username  = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users(username, password) VALUES('$username','$password')";

    if($conn->query($sql) === true){
        $message = 'Registration successful';
    }else{
        $message = 'Registration failed';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register Page</h1>
    <?php if(isset($message)):?>
        <h1><?php echo $message?></h1>
    <?php endif;?>
    <form action="register.php" method="post">
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>
        <input type="submit" name="register" value="REGISTER">
    </form>
    <form action="login.php">
        <input type="submit" name="login" value="LOGIN">
    </form>
</body>
</html>