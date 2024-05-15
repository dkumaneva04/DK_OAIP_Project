<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="inner">
                
                <a class="header__logo" href="/"><h2 style="text-align: left;margin: 20px 0px;">Онлайн форум</h2></a>
                <a class="btn auth"  href="auth.php">Войти</a>
                <a class="btn auth_user" href="/profile.php"><?= $_SESSION['user']['login']; ?></a>
                        <?php
                        
                        if(isset($_SESSION['login'])) {
                            echo "<style>.auth {display: none}; .auth_user {display: block;}</style>";
                        } else {
                            echo "<style>.auth_user {display: none;}</style>";
                        }
                        
                        ?>
            </div>
        </div>
    </header>
</body>
</html>