<?php

require_once 'src/functions.php';
// Вывод всех одобренных вакансий

// Находим текущего пользователя
check_auth();
$user = current_user();

// Подключаемся к базе данных и выводим одобренные вакансии
$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM jobs WHERE status = 'agree'");
$jobs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

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
    <title>Список вакансий</title>
</head>
<body>
    <h1>Вакансии</h1>
    <div>
        <?php foreach ($current_jobs as $job): ?>
            <div class="job-card">
                <?php $date = explode(" ", $job['created_at']);
                $short_desc = substr($job['description'], 0, 52) . "...";?>
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
    <form class="card" action="src/buttons.php" method="post">
        <label for="jobs">
            <button class="container" type="submit" name="action" value="job-search">Поиск вакансий</button>
        </label>
        <label for="jobs">
            <button class="container" type="submit" name="action" value="job-create">Создать вакансию</button>
        </label>
        <label for="jobs">
            <button class="container" type="submit" name="action" value="home">В личный кабинет</button>
        </label>
    </form>
</body>
</html>