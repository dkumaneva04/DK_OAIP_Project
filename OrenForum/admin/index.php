<?php

require "../connect.php";

// Защита от SQL-инъекций
$exam_user = "SELECT * FROM files WHERE status = 'Ожидание'";
$stmt = mysqli_prepare($connect, $exam_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$resp = mysqli_fetch_all($result, MYSQLI_ASSOC);

session_start();

if(isset($_SESSION['user']['login']) && $_SESSION['user']['role'] == 'admin') {
    // Ваша логика для администратора
} else {
    header('Location: /');
    exit(); // добавляем exit, чтобы прекратить выполнение кода после редиректа
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн форум</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            background: url(../../image/body.png);
            background-repeat: no-repeat;
            background-size: cover;
        }

        header {
            border-bottom: 2px solid #000;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
        }

        .inner {
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .header__logo {
            text-decoration: none;
            color: #000;
        }

        form {
            margin-top: 20px;
            margin-right: 10px;
        }

        button, .btn {
            border: 0px;
            background: rgb(222, 36, 251);
            border-radius: 10px;
            /* height: 34px; */
            font-size: 20px;
            margin: 10px 0px;
            color: #fff;
            cursor: pointer;
            padding: 10px 10px;
            text-decoration: none;
        }
        input {
            border: 0px;
            border-bottom: 1px solid #000;
            height: 34px;
            font-size: 20px;
            margin: 10px 0px;
            outline: none;
            background-color: transparent;
        }

        .item {
            max-width: 700px;
            margin: 20px auto;
            display: flex;
            border: 1px solid #000;
            padding: 10px;
        }

        .data {
            margin-left: 15px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include ("../components/Header/header.php"); ?>
    <div class="container">
        <?php 
            if(count($resp) == 0) {
                echo "<h1 style='color: orange; text-align: center; margin-top: 40px;'>Постов на проверку нету</h1>";
            }
            for ($i=0; $i < count($resp); $i++) {

        ?> 
        <div class="item">
            <img src="/image/<?= $resp[$i]['image'] ?>" width="140" height="140" alt="">
            <div class="data">
                <p>Статус: <span style="color: orange;"><?= $resp[$i]['status'] ?></span></p>
                <h2><?= $resp[$i]['name'] ?></h2>
                <p style="margin-bottom: 20px; word-wrap: break-word; width: 530px;"><?= $resp[$i]['description'] ?></p>
                <a class="btn" href="/file/<?= $resp[$i]['file'] ?>" download>Скачать</a>
                <div style="display:flex;">
                    <?php 
                    
                    if(isset($_POST['yes'])) {
                        $id = $_POST['yes'];
                        $exam_user = "UPDATE `files` SET `status`='Одобрено' WHERE `id` = '$id'";
                        $result = mysqli_query($connect, $exam_user); 
                        echo "<script>alert('одобрено!'); location.href='/admin/index.php';</script>";
                    }
                    if(isset($_POST['id']) and isset($_POST['no'])) {
                        $id = $_POST['id'];
                        $no = $_POST['no'];
                        $exam_user = "UPDATE `files` SET `status`='Отказ', `comment`='$no' WHERE `id` = '$id'";
                        $result = mysqli_query($connect, $exam_user); 
                        echo "<script>alert('отклонена!'); location.href='/admin/index.php';</script>";
                    }
                    
                    
                    ?>
                    <form action="" method="POST"><input style="position: absolute; top: -1000px;" name="yes" type="text" value="<?= $resp[$i]['id'] ?>"><button style="background: green;">Одобрить</button></form>
                    <form action="" method="POST"><input style="position: absolute; top: -1000px;" name="id" type="text" value="<?= $resp[$i]['id'] ?>"><button style="background: red;">Отказать</button> <input type="text" name="no" placeholder="Комментарий для отказа"></form>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>