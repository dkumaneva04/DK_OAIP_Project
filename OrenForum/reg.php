<?php
require "connect.php";

session_start();

if(isset($_SESSION['login'])) {
    header("Location: profile.php");
    exit();
}

if(isset($_POST['login'], $_POST['email'], $_POST['password'], $_POST['fio'])) {
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $fio = mysqli_real_escape_string($connect, $_POST['fio']);
    $password = mysqli_real_escape_string($connect, password_hash($_POST['password'], PASSWORD_DEFAULT));

    $exam_user = "SELECT * FROM users WHERE login = '$login'";
    $exam_result = mysqli_query($connect, $exam_user);
    $num = mysqli_num_rows($exam_result);

    if($num == 0) {
        $sql = "INSERT INTO users (login, email, password, fio, role, image) VALUES ('$login', '$email', '$password', '$fio', 'user', 'default.jpg')";
        $result = mysqli_query($connect, $sql);
        if($result) {
            echo "<script>alert('Регистрация прошла успешно 😊'); window.location.href='auth.php';</script>";
            exit();
        } else {
            echo "<script>alert('Произошла ошибка при регистрации! ☹️')</script>";
        }
    } else {
        echo "<script>alert('Пользователь с таким именем уже существует! 😕')</script>";
    }
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