<?php

require_once 'src/functions.php';

check_auth();

$user = current_user();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link 
        rel="stylesheet" 
        href="css/style.css">
    <title>Личный кабинет</title>
</head>
<body>
    <h1>Добро пожаловать <?php echo $user['username'] ?>!</h1>
    <form action="src/logout.php" method="post">
        <button role="button">Выйти</button>
    </form>
</body>
</html>

<?php