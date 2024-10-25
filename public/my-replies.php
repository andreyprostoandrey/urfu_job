<?php

require_once 'src/functions.php';
// Просмотр пользовательских заявок

// Обрабатываем текущего пользователя
$user = current_user();
$email = $user['email'];

// Подключаемся к таблице заявок по почте пользователя
$pdo = getPDO();
$stmt = $pdo->prepare("SELECT * FROM replies WHERE email = :email");
$stmt->execute(['email' => $email]);
$replies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

// Собираем в массив id вакансий, по которым пользователь откликнулся
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
    <title>Мои заявки</title>
</head>
<body>
<h1>Мои заявки</h1>
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
                                <p class="text"><b>Статус:</b> <?php if($reply['status'] != null): echo $reply['status']; ?><?php endif; ?>
                                <?php if($reply['status'] == null): echo "Ожидает" ?></p><?php endif; ?>
                                <?php if($reply['status'] == null): ?>
                                <a style="text-align: center;" href="src/delete-reply.php?id=<?php echo $reply['id']; ?>">Отменить заявку</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <?php require 'src/page-transfer2.php'; ?>
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