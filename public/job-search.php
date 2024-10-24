<?php

require_once 'src/functions.php';

$user = current_user();
$jobs = current_jobs();
check_auth();

$jobs_per_page = 4; // Количество вакансий на странице
$total_jobs = count($jobs); // Общее количество вакансий
$total_pages = ceil($total_jobs / $jobs_per_page); // Общее количество страниц

// Получаем текущую страницу
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages)); // Ограничиваем номер страницы

// Вычисляем индекс начальной и конечной вакансий для текущей страницы
$start_index = ($current_page - 1) * $jobs_per_page;
$current_jobs = array_slice($jobs, $start_index, $jobs_per_page); // Вакансии для текущей страниц
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
<h1>Поиск вакансии</h1>
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
                <?php $date = explode(" ", $job['created_at']); ?>
                <img src="<?php echo $job['image']?>">
                <p class="title"><b><?php echo $job['title']; ?></b></p>
                <p class="text"><b>Описание:</b> <?php echo $job['description']; ?>...</p>
                <p class="text"><b>Дата создания:</b> <?php echo $date[0]; ?></p>
                <p class="text"><b>Режим работы:</b><br><?php echo $job['shift']; ?></p>
                <p class="text"><b>Зарплата:</b><br><?php echo $job['salary']; ?></p>
                <p class="text"><b>Заказчик:</b><br><?php echo $job['email']; ?></p>
                <a href="job.php?id=<?php echo $job['id']; ?>">Подробнее</a>
             </div>
            
        <?php endforeach; ?>
    </div>
    <div class="pagination">
    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
        <a href="?page=<?php echo $page; ?>" class="<?php echo ($page === $current_page) ? 'active' : ''; ?>">
            <?php echo $page; ?>
        </a>
    <?php endfor; ?>
    </div>
    <p><a href="jobs.php">Назад к списку вакансий</a></p>
</body>
</html>