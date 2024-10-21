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
    <title>Авторизация</title>
</head>
<body>
    <h1>Авторизация</h1>
    <form action="index.php" method="POST">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Продолжить</button>
    </form>

    <p>У меня еще нет <a href="register.php">аккаунта</a></p>
</body>
</html>

<?php

