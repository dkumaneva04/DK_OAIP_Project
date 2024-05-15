<?php
session_start();
require "connect.php";

if(isset($_POST['login']) and isset($_POST['password'])) {
	$login = $_POST['login'];
	$password = md5($_POST['password']);
				
    $sql = "SELECT * FROM users WHERE login = '$login' and password = '$password'";
    $result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION['login'] = $login;
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "email" => $user['email'],
            "fio" => $user['fio'],
            "role" => $user['role'],
        ];
    } else {
        echo "<script>alert('Логин или Пароль неверный!!!');</script>";
    }
} 

if(isset($_SESSION['login'])) {
	$login = $_SESSION['login'];
	header('Location: profile.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн форум</title>
</head>
<body>
    <?php include ("components/Header/header.php"); ?>
    <form action="" method="POST">
        <h2>Авторизация</h2>
        <input name="login" type="text" placeholder="Логин">
        <input  name="password" type="password" placeholder="Пароль">
        <button>Войти</button>
        <p><a href="reg.php">Регистрация</a> если нету аккаунта</p>
    </form>
</body>
</html>