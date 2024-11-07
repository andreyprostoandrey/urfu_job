<?php

require_once 'src/functions.php';
// Личный кабинет

// Определяем пользователя
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
    <link rel="stylesheet" href="css/style.css">
    <title>Личный кабинет</title>
</head>
<body class="container">
    <h1 style="text-align: center">Добро пожаловать, <?php echo $user['username'] ?>!</h1>
    <form class="card" action="src/buttons.php" method="post">
        <label class="container" for="action">
            <button type="submit" name="action" value="my-replies">Мои заявки</button>
        </label>  
        <label class="container" for="action">
            <button type="submit" name="action" value="jobs">Смотреть вакансии</button>
        </label>  
        <label class="container" for="action">
            <button type="submit" name="action" value="job-create">Создать вакансию</button>
        </label>
        <label class="container" for="action">
            <button type="submit" name="action" value="logout">Выйти</button>
        </label>
        <?php if ($user['id'] == 1): ?>
            <label class="container" for="action">
                <button type="submit" name="action" value="admin">Админ панель</button>
            </label>
        <?php endif; ?>
    </form>
</body>
</html>