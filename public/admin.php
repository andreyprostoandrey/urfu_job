<?php

require_once 'src/functions.php';
// Админ панель

// Определяем пользователя
check_auth();
$user = current_user();
is_admin($user);
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
    <title>Админ панель</title>
</head>
<body class="container">
    <h1 style="text-align: center">Алмин панель</h1>
    <form class="card" action="src/buttons.php" method="post">
        <label class="container" for="action">
            <button type="submit" name="action" value="jobs-admin">Обработать вакансии</button>
        </label>  
        <label class="container" for="action">
            <button type="submit" name="action" value="replies-admin">Обработать заявки</button>
        </label>  
        <label class="container" for="action">
            <button type="submit" name="action" value="home">Личный кабинет</button>
        </label>
    </form>
</body>
</html>