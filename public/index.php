<?php

require_once 'src/functions.php';

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
    <title>Авторизация</title>
</head>
<body>
    <h1>Вход</h1>
    <form action="src/login.php" method="POST">

        <label for="email">Email:
            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo old('email') ?>"
                <?php validation_error_attr('email'); ?>
                
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
                <?php validation_error_attr('password');?>
            >
            <?php if(has_validation_error('password')): ?>
                <small><?php echo validation_error_message('password'); ?></small>
            <?php endif; ?>
        </label>

        <button type="submit">Продолжить</button>
    </form>
    
    <p>У меня еще нет <a href="register.php">аккаунта</a></p>
</body>
</html>

<?php

