<?php
require "connect.php";

if(isset($_POST['login']) and isset($_POST['email']) and isset($_POST['password']) and isset($_POST['fio'])) {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $fio = $_POST['fio'];
    $password = md5($_POST['password']);

    $exam_user = "SELECT * FROM users WHERE login = '$login'";
    $exam_result = mysqli_query($connect, $exam_user); 
    $num = mysqli_num_rows($exam_result);
    
    if($num == 0) {
        $sql = "INSERT INTO users (login, email, password, fio, role, image) VALUES ('$login', '$email', '$password', '$fio', 'user', 'default.jpg')";
        $result = mysqli_query($connect, $sql);
        if($result) { 
            echo "<script>alert('Регистрация прошла успешна'); location.href='auth.php';</script>"; 
        } else { 
            echo "<script>alert('Произошла ошибка при регистрации!')</script>"; 
        }    
    } else { 
        echo "<script>alert('Пользователь с таким именем существует!')</script>"; 
    }
}

session_start();

if(isset($_SESSION['login'])) {
	$login = $_SESSION['login'];
    header("Location: profile.php");
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
        <h2>Регистрация</h2>
        <input name="login" type="text" placeholder="Логин">
        <input name="password" type="password" placeholder="Пароль">
        <input name="fio" type="text" placeholder="ФИО">
        <input name="email" type="text" placeholder="E-mail">
        <button>Зарегистрироваться</button>
        <p><a href="auth.php">Авторизация</a> если есть аккаунт</p>
    </form>
</body>
</html>