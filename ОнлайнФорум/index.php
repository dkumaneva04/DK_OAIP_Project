<?php 

require "connect.php";

$exam_user = "SELECT * FROM `files` WHERE `status` = 'Одобрено'";
$result = mysqli_query($connect, $exam_user); 
$resp = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн форум</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include ("components/Header/header.php"); ?>
    <div class="container">
        <?php 
        if(count($resp) == 0) {
            echo "<h1 style='color: red; text-align: center; margin-top: 40px;'>Постов нету на сайте</h1>";
        }
            for ($i=0; $i < count($resp); $i++) {

        ?> 
        <div class="item">
            <img src="/image/<?= $resp[$i]['image'] ?>" width="140" height="140" alt="">
            <div class="data">
                <h2><?= $resp[$i]['name'] ?></h2>
                <p style="margin-bottom: 20px; word-wrap: break-word; width: 530px;"><?= $resp[$i]['description'] ?></p>
                <a class="btn" href="/file/<?= $resp[$i]['file'] ?>" download>Скачать</a>
                <a class="btn" href="card.php?id=<?=$resp[$i]['id']?>">Подробнее</a>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>