<?php

require_once 'src/functions.php';

$user = current_user();
$email = $user['email'];

$pdo = getPDO();
$stmt = $pdo->prepare("SELECT * FROM replies WHERE email = :email");
$stmt->execute(['email' => $email]);
$replies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$job_ids = [];
foreach($replies as $reply) {
    $res = array_push($job_ids, $reply['job_id']);
}

$jobs = [];
foreach($job_ids as $job_id) {
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = :id");
    $stmt->execute(['id' => $job_id]);
    $job = $stmt->fetch(\PDO::FETCH_ASSOC);
    if ($job != false){
        $res = array_push($jobs, $job);
    }
    
}

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
    <title>Мои заявки</title>
</head>
<body>
<h1>Список заявок</h1>
    <div>
        <?php foreach($replies as $reply):
                    foreach($current_jobs as $job):
                        if($reply['job_id'] == $job['id']):?>
                            <div class="job-card">
                                <?php $date = explode(" ", $job['created_at']); 
                                $short_desc = substr($job['description'], 0, 52) . "...";?>
                                <img src="<?php echo $job['image']?>">
                                <p class="title"><b><?php echo $job['title']; ?></b></p>
                                <p class="text"><b>Описание:</b> <?php echo $short_desc; ?>...</p>
                                <p class="text"><b>Дата создания:</b> <?php echo $date[0]; ?></p>
                                <p class="text"><b>Заказчик:</b><br><?php echo $job['email']; ?></p>
                                <p class="text"><b>Время подачи заявки:</b> <?php echo $reply['created_at']; ?></p>
                                <a style="text-align: center;" href="src/delete-reply.php?id=<?php echo $reply['id']; ?>">Удалить заявку</a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
        <a href="?page=<?php echo $page; ?>" class="<?php echo ($page === $current_page) ? 'active' : ''; ?>">
            <?php echo $page; ?>
        </a>
    <?php endfor; ?>
    </div>
    <form class="card" action="src/buttons.php" method="post">
        <label for="action">
            <button class="container" type="submit" name="action" value="home">В личный кабинет</button>
        </label>
        <label for="action">
            <button class="container" type="submit" name="action" value="jobs">Смотреть вакансии</button>
        </label>
        <label for="action">
            <button class="container" type="submit" name="action" value="job-search">Поиск вакансий</button>
        </label>
    </form>
    </body>
</html>