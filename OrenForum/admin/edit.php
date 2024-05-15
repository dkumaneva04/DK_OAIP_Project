<?php
session_start();
require "../connect.php";

$user_id = $_SESSION['user']['id'];

$exam_user = "SELECT * FROM `users` WHERE 1";
$result = mysqli_query($connect, $exam_user); 
$resp = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['login'], $_POST['email'], $_POST['password'], $_POST['fio'], $_POST['id'])) {
    $id = $_POST['id'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $fio = $_POST['fio'];
    $password = md5($_POST['password']);

    $sql = "UPDATE users SET login='$login', password='$password', fio='$fio', email='$email' WHERE id = '$id'";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        echo "<script>alert('успешно'); location.href='edit.php';</script>";
    } else {
        echo "<script>alert('ошибка!')</script>";
    }
}

if (empty($_SESSION['user']['login'])) {
    header('Location: index.php');
    exit; // Always remember to exit after a header redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн форум</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include ("../header.php"); ?>
    <div class="container">
        <h1>Пользователи:</h1>
        <?php 
        if(count($resp) == 0) {
            echo "<h1 style='color: orange; text-align: center; margin-top: 40px;'>У вас еще нету книг</h1>";
        }
            for ($i=0; $i < count($resp); $i++) {

        ?> 
        <div class="item">
            <img src="../image/<?= $resp[$i]['image'] ?>" width="140" height="140" alt="">
            <div class="data">
                <h3>ФИО:<?= $resp[$i]['fio'] ?></h3>
                <h3>Логин: <?= $resp[$i]['login'] ?></h3>
                <h3>Пароль: <?= $resp[$i]['password'] ?></h3>
                <h3>Роль: <?= $resp[$i]['role'] ?></h3>
                <h3>E-mail: <?= $resp[$i]['email'] ?></h3>
                <a class="btn open" href="#openModal_<?=$resp[$i]['id']?>">Изменить</a>
            </div>
        </div>

        <div id="openModal_<?=$resp[$i]['id']?>" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Изменение</h3>
                    <a href="#close" title="Close" class="close">×</a>
                </div>
                <div class="modal-body">    
                    <form action="" method="POST">
                        <input name="id" type="text" placeholder="Логин" value="<?= $resp[$i]['id'] ?>" style="position: absolute; top: -10000px;">
                        <input name="login" type="text" placeholder="Логин" value="<?= $resp[$i]['login'] ?>">
                        <input name="password" type="password" placeholder="Пароль" value="">
                        <input name="fio" type="text" placeholder="ФИО" value="<?= $resp[$i]['fio'] ?>">
                        <input name="email" type="text" placeholder="E-mail" value="<?= $resp[$i]['email'] ?>">
                        <button>Изменить</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <style>
        .data {
            position: relative;
        }
        .open {
            position: absolute;
            right: 0;
            bottom: 1px;
        }

        .modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0,0,0,0.5); 
    z-index: 1050;
    opacity: 0; 
    -webkit-transition: opacity 200ms ease-in; 
    -moz-transition: opacity 200ms ease-in;
    transition: opacity 200ms ease-in;
    pointer-events: none; 
    margin: 0;
    padding: 0;
}

.modal:target {
    opacity: 1; 
	  pointer-events: auto; 
    overflow-y: auto;
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: 10px;
}
@media (min-width: 576px) {
  .modal-dialog {
      max-width: 500px;
      margin: 30px auto; 
  }
}

.modal-content {
    position: relative;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: .3rem;
    outline: 0;
}
@media (min-width: 768px) {
  .modal-content {
      -webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
      box-shadow: 0 5px 15px rgba(0,0,0,.5);
  }
}

.modal-header {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 15px;
    border-bottom: 1px solid #eceeef;
}
.modal-title {
    margin-top: 0;
    margin-bottom: 0;
    line-height: 1.5;
    font-size: 1.25rem;
    font-weight: 500;
}

.close {
    float: right;
    font-family: sans-serif;
    font-size: 24px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
    text-decoration: none;
}

.close:focus, .close:hover {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    opacity: .75;
}

.modal-body {
  position: relative;
    -webkit-box-flex: 1;
    -webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 15px;
    overflow: auto;
}
    </style>
</body>
</html>