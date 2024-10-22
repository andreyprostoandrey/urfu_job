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
    <link rel="stylesheet" href="css/res.css">
    <title>Создать вакансию</title>
</head>
<body>
<h1>Создать вакансию</h1>
    <form class="card" action="src/job-create.php" method="POST" enctype="multipart/form-data">

        <label for="title">Название:
            <input
                type="text"
                id="title"
                name="title"
                placeholder="Название вакансии"
                maxlength="155"
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
                placeholder="Описание вакансии"
                maxlength="555"><?php echo old('description') ?></textarea>
            <?php if(has_validation_error('description')): ?>
                <small style="color: #ce7e7b;"><?php echo validation_error_message('description'); ?></small>
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
    
</body>
</html>
