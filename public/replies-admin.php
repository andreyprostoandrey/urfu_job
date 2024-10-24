<?php

require_once 'src/functions.php';
// Обработка админом заявок от пользователей

// Находим и проверяем пользователя
check_auth();
$user = current_user();
is_admin($user);

// Подключаемся к базе данных и возвращаем заявки, у которых пустой статус
$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM replies WHERE status IS NULL");
$replies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

// Собираем в массив id вакансий, по которым есть отклики
$job_ids = [];
foreach($replies as $reply) {
    $res = array_push($job_ids, $reply['job_id']);
}

// Обращаемся к базе данных и собираем информацию о вакансиях
$jobs = [];
foreach($job_ids as $job_id) {
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = :id");
    $stmt->execute(['id' => $job_id]);
    $job = $stmt->fetch(\PDO::FETCH_ASSOC);
    if ($job != false){
        $res = array_push($jobs, $job);
    }
    
}

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
    <title>Обработка заявок</title>
</head>
<body>
    <h1>Обработка заявок</h1>
    <div>
        <?php foreach($replies as $reply):
                    foreach($current_jobs as $job):
                        if($reply['job_id'] == $job['id']):?>
                            <div class="job-card">
                                <?php $date = explode(" ", $reply['created_at']); 
                                $short_desc = substr($reply['resume'], 0, 52) . "...";?>
                                <img src="<?php echo $job['image']?>">
                                <p class="title"><b><?php echo $job['title']; ?></b></p>
                                <p class="text"><b>Описание:</b> <?php echo $short_desc; ?>...</p>
                                <p class="text"><b>Дата создания:</b> <?php echo $date[0]; ?></p>
                                <p class="text"><b>Автор заявки:</b><br><?php echo $reply['email']; ?></p>
                                <p class="text"><b>Время подачи заявки:</b> <?php echo $reply['created_at']; ?></p>
                                <a href="reply.php?id=<?php echo $reply['id']; ?>">Подробнее</a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <?php require 'src/page-transfer2.php'; ?>
    <form class="card" action="src/buttons.php" method="post">
        <label for="jobs">
            <button class="container" type="submit" name="action" value="home">В личный кабинет</button>
        </label>
    </form>
</body>
</html>