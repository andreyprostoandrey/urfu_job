<?php

require_once 'src/functions.php';

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
    <title>Создать вакансию</title>
</head>
<body>
<h1>Создать вакансию</h1>
    <form class="card" action="src/job-create.php" method="POST" enctype="multipart/form-data">

        <label for="title">Должность:
            <input
                type="text"
                id="title"
                name="title"
                placeholder="Максимум 15 символов"
                maxlength="15"
                value="<?php echo old('title') ?>"
                <?php echo validation_error_attr('title'); ?>
            >
            <?php if(has_validation_error('title')): ?>
                <small><?php echo validation_error_message('title'); ?></small>
            <?php endif; ?>
        </label>
         
        <label for="description">Описание:
            <textarea
                style="<?php if(has_validation_error('description')): ?>
                    <?php echo "border: 0.0625rem solid #964a50;" ?>
                    <?php endif; ?>"
                name="description"
                id="description" 
                placeholder="Максимум 555 символов"
                maxlength="555"><?php echo old('description') ?></textarea>
            <?php if(has_validation_error('description')): ?>
                <small style="color: #ce7e7b;"><?php echo validation_error_message('description'); ?></small>
            <?php endif; ?>
        </label>

        <label for="shift">Режим работы:</label>
            <input 
                type="text" 
                id="shift" 
                name="shift"
                maxlength="25"
                placeholder="Максимум 25 символов"
                value="<?php echo old('shift') ?>"
                <?php echo validation_error_attr('shift'); ?>>
            <?php if(has_validation_error('shift')): ?>
                <small style="color: #ce7e7b;"><?php echo validation_error_message('shift'); ?></small>
            <?php endif; ?>
        </label>

        <label for="salary">Зарплата:</label>
            <input 
                type="text" 
                id="salary" 
                name="salary"
                maxlength="25"
                placeholder="Максимум 25 символов"
                value="<?php echo old('salary') ?>"
                <?php echo validation_error_attr('salary'); ?>>
            <?php if(has_validation_error('salary')): ?>
                <small style="color: #ce7e7b;"><?php echo validation_error_message('salary'); ?></small>
            <?php endif; ?>
        </label>

        <label for="image">Изображение:
            <input 
                type="file"
                id="image"
                name="image"
                <?php echo validation_error_attr('image'); ?>
            >
            <?php if(has_validation_error('image')): ?>
                <small><?php echo validation_error_message('image'); ?></small>
            <?php endif; ?>
        </label>

        <button type="submit">Продолжить</button>
    </form>
    <p><a href="jobs.php">Назад к списку вакансий</a></p>
</body>
</html>
