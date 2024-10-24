<?php

require_once 'src/functions.php';
// Поиск и вывод вакансий по названию

// Находим пользователя и вансию
$user = current_user();
$jobs = current_jobs();
check_auth();

require_once "src/page-transfer.php"
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
    <title>Поиск</title>
</head>
<body>
<h1>Поиск вакансий</h1>
<form action="src/job-search.php" method="POST">
        <label for="title_search">Введите название вакансии:
            <input
                type="text"
                id="title_search"
                name="title_search"
                placeholder="Максимум 15 символов"
                maxlength="15"
                <?php echo validation_error_attr('title_search'); ?>
            >
            <?php if(has_validation_error('title_search')): ?>
                <small><?php echo validation_error_message('title_search'); ?></small>
            <?php endif; ?>
        </label>
        <button type="submit">Продолжить</button>
    </form>
    <div>
        <?php foreach ($jobs as $job): ?>
            <div class="job-card">
                <?php $date = explode(" ", $job['created_at']);
                $short_desc = substr($job['description'], 0, 52) . "..."; ?>
                <img src="<?php echo $job['image']?>">
                <p class="title"><b><?php echo $job['title']; ?></b></p>
                <p class="text"><b>Описание:</b> <?php echo $short_desc; ?></p>
                <p class="text"><b>Дата создания:</b> <?php echo $date[0]; ?></p>
                <p class="text"><b>Режим работы:</b><br><?php echo $job['shift']; ?></p>
                <p class="text"><b>Зарплата:</b><br><?php echo $job['salary']; ?></p>
                <p class="text"><b>Заказчик:</b><br><?php echo $job['email']; ?></p>
                <a href="job.php?id=<?php echo $job['id']; ?>">Подробнее</a>
             </div>
        <?php endforeach; ?>
    </div>
    <?php require 'src/page-transfer2.php'; ?>
    <p><a href="jobs.php">Назад к списку вакансий</a></p>
</body>
</html>