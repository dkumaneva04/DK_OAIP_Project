<?php 

require "connect.php";

session_start();
$id = $_GET['id'];

$exam_user = "SELECT * FROM `files` WHERE `status` = 'Одобрено' and `id` = '$id'";
$result = mysqli_query($connect, $exam_user); 
$resp = $result->fetch_all(MYSQLI_ASSOC);

$user_id = $_SESSION['user']['id'];

$exam_comment = "SELECT * FROM `comment` INNER JOIN `users` ON comment.user_id = users.id WHERE `files_id` = '$id'";
$result_comment = mysqli_query($connect, $exam_comment); 
$response = $result_comment->fetch_all(MYSQLI_ASSOC);

if(isset($_POST['comment'])) {
    if($user_id) {
        $comment = $_POST['comment'];

        $exam_comment = "INSERT INTO `comment`(`comment`, `files_id`, `user_id`) VALUES ('$comment','$id','$user_id')";
        $result_comment = mysqli_query($connect, $exam_comment); 
        echo "<script>alert('Комментарий успешно добавлен'); location.href='card.php?id=$id';</script>"; 
    } else {
        echo "<script>alert('Авторизируйтесь чтобы добавить комментарий');</script>"; 
    }
}

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
        <div class="item__card">
            <div class="item">
                <img src="/image/<?= $resp[0]['image'] ?>" width="140" height="140" alt="">
                <div class="data">
                    <h2><?= $resp[0]['name'] ?></h2>
                    <p style="margin-bottom: 20px; word-wrap: break-word; width: 530px;"><?= $resp[0]['description'] ?></p>
                    <a class="btn" href="/file/<?= $resp[0]['file'] ?>" download>Скачать</a>
                </div>
            </div>
            <div class="add__comment">
                <form style="display: flex;
    flex-direction: column;
    max-width: 690px;
    margin: 0px auto;" action="" method="POST">
                    <textarea name="comment" id="" cols="89" rows="10" placeholder="Комментарий" style="padding: 10px; outline: none;"></textarea>
                    <button>Оставить комментарий</button>
                </form>
            </div>
            <div class="comment">
                <h2>Комментарии:</h2>
                <div>
                    <?php 
                    if(count($response) == 0) {
                        echo "<h1 style='color: red; text-align: center; margin-top: 40px;'>Комментариев нету</h1>";
                    }
                        for ($i=0; $i < count($response); $i++) {

                    ?> 
                    <div class="item">
                        <span>
                            <h3>пользователь: <?= $response[$i]['login']?></h3>
                            <p>комментарий: <?= $response[$i]['comment']?></p>
                        </span>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>