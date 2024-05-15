<?php
session_start();
require "connect.php";

if(isset($_POST['login']) && isset($_POST['password'])) {
    $login = mysqli_real_escape_string($connect, $_POST['login']); 
    $password = md5($_POST['password']);
    
    $sql = "SELECT * FROM users WHERE login = '$login' and password = '$password'";
    $result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
    $count = mysqli_num_rows($result);
    
    if($count == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "email" => $user['email'],
            "fio" => $user['fio'],
            "role" => $user['role'],
        ];
        
        $_SESSION['login'] = $user['login'];
        header('Location: profile.php');
        exit();
    } else {
        echo "<script>alert('❌ Логин или Пароль неверный!!!');</script>";
    }
}

if(isset($_SESSION['login'])) {
    header('Location: profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн форум</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include ("header.php"); ?>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Авторизация</span></div>
        <form method="POST" action="#">
          <div class="row">
            <input name="login" type="text" placeholder="Login" required>
          </div>
          <div class="row">
            <input name="password" type="password" placeholder="Пароль" required>
          </div>
          <div class="row button">
            <input type="submit" value="Войти">
          </div>
          <div class="signup-link"><a href="reg.php">Регистрация</a></div>
        </form>
      </div>
    </div>

</body>
</html>