<?php 

require "connect.php";
session_start();
$user_id = $_SESSION['user']['id'];

if(isset($_POST['name']) and isset($_POST['description'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $random = rand(1, 999999999999999999);

    $filename = $_FILES["file_upload"]["name"];
    $image = $_FILES["image"]["name"];

    $full_file = "$random-$filename";
    $full_image = "$random-$image";

    $tempname_file = $_FILES["file_upload"]["tmp_name"];
    $tempname_image = $_FILES["image"]["tmp_name"];

    $folder_file = "./file/" . $full_file;
    $folder_image = "./image/" . $full_image;

    if (move_uploaded_file($tempname_file, $folder_file) and move_uploaded_file($tempname_image, $folder_image)) {
        $sql = "INSERT INTO files (name, description, image, file, user_id, status,comment) VALUES ('$name', '$description', '$full_image', '$full_file', '$user_id', 'Ожидание','0')";
        $result = mysqli_query($connect, $sql);
        if($result) { 
            echo "<script>alert('успешно отправленна на рассмотрение'); location.href='profile.php';</script>"; 
        } else { 
            echo "<script>alert('ошибка!')</script>"; 
        }
        if (!$result) {
            echo "Ошибка: " . mysqli_error($connect);
        }
        
    }
}

if(isset($_POST['submit'])) {
    $random = rand(1, 999999999999999999);
    $image = $_FILES["file_up"]["name"];
    $full_image = "$random-$image";
    $tempname_image = $_FILES["file_up"]["tmp_name"];
    $folder_image = "./image/" . $full_image;
    if(move_uploaded_file($tempname_image, $folder_image)) {
        $sql = "UPDATE `users` SET `image`='$full_image' WHERE `id` = '$user_id'";
        $result = mysqli_query($connect, $sql);
        if($result) { 
            echo "<script>alert('успешно!'); location.href='profile.php';</script>"; 
        } else { 
            echo "<script>alert('ошибка!')</script>"; 
        }    
    }
}

$exam_user = "SELECT * FROM `users` WHERE `id` = '$user_id'";
$result = mysqli_query($connect, $exam_user); 
$response = $result->fetch_all(MYSQLI_ASSOC);

if($_SESSION['user']['login']) {} else {
    header('Location: '. 'index.php');
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
    <?php include ("header.php"); ?>
    <div class="container">
        <div style="margin-top: 40px;">
            <a href="status.php" class="btn">Ваши файлы</a>
            <?php if($_SESSION['user']['role'] == 'admin') { ?>
                <a href="/admin/index.php" class="btn">Админка</a>
            <?php }?>
            <?php if($_SESSION['user']['role'] == 'admin') { ?>
                <a href="/admin/edit.php" class="btn">Пользователи</a>
            <?php }?>
            <a href="logout.php" class="btn">Выйти</a>
        </div>
        <div class="contents123">
        <form class="forms" style="display: flex;
    flex-direction: column;
    max-width: max-content;
    margin: 0px auto;" class="image__user" method="POST" enctype="multipart/form-data">
            <img src="image/<?=$response[0]['image']?>" style="border: 1px solid #000; cursor: pointer" width="250" height="300" alt="">
            <div class="hover">
                <input type="file" name="file_up" style="position: absolute; font-size: 10px; top: 280px;  left: 250px; width: 200px; height: 200px; cursor: pointer; opacity: 0.001; " required>
            </div>
            <button class="sdsajh" name="submit">Загрузить</button>
        </form>
    <form class="forms" action="" method="POST" enctype="multipart/form-data">
        <h2>Добавления поста</h2>
        <input name="name" type="text" placeholder="Название">
        <textarea style="padding: 10px;" name="description" id="" cols="30" rows="10" placeholder="Описание"></textarea>
        <label for="">Картинка</label>
        <input name="image" type="file">
        <label for="">Файл</label>
        <input name="file_upload" type="file">
        <button class="sdsajh">Подать на рассмотрение</button>
    </form>
        </div>
</body>
</html>