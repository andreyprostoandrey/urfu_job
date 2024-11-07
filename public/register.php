<?php

require_once 'src/functions.php';
// Регистрация на сайте

// Проверяем авторизацию
check_guest();
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
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <form class="card" action="src/register.php" method="POST">
        <label for="username">Имя пользователя:
            <input 
                type="text" 
                id="username" 
                name="username"
                placeholder="ФИО"
                maxlength="100"
                value="<?php echo old('username') ?>"
                <?php echo validation_error_attr('username'); ?>
            >
            <?php if(has_validation_error('username')): ?>
                <small><?php echo validation_error_message('username'); ?></small>
            <?php endif; ?>
        </label>

        <label for="group_id">Группа:
            <input 
                type="text" 
                id="group_id" 
                name="group_id"
                placeholder="Номер группы"
                maxlength="100"
                value="<?php echo old('group_id') ?>"
                <?php echo validation_error_attr('group_id'); ?>
            >
            <?php if(has_validation_error('group_id')): ?>
                <small><?php echo validation_error_message('group_id'); ?></small>
            <?php endif; ?>
        </label>

        <label for="email">Email:
            <input
                type="email"
                id="email"
                name="email"
                maxlength="100"
                value="<?php echo old('email') ?>"
                <?php echo validation_error_attr('email'); ?>
            >
            <?php if(has_validation_error('email')): ?>
                <small><?php echo validation_error_message('email'); ?></small>
            <?php endif; ?>
        </label>

        <label for="password">Пароль:
            <input 
                type="password" 
                id="password" 
                name="password" 
                maxlength="255"
                <?php echo validation_error_attr('password');?>
            >
            <?php if(has_validation_error('password')): ?>
                <small><?php echo validation_error_message('password'); ?></small>
            <?php endif; ?>
        </label>

        <label for="confirm_password">Подтверждение пароля:
            <input 
                type="password" 
                id="confirm_password" 
                name="confirm_password" 
                maxlength="255"
            >
        </label>

        <button type="submit">Зарегистрироваться</button>
    </form>
    <?php clear_validation(); ?>
    <p>У меня уже есть <a href="index.php">аккаунт</a></p>
</body>
</html>
