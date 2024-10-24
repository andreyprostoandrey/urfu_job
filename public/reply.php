<?php

require_once 'src/functions.php';
// Разворот карточки вакансии

// Находим пользователя
check_auth();
$user = current_user();

// Получаем id заявки из строки запроса методом GET
$id = $_GET['id'] ?? null;

// Подключаемся к базе и проверяем, есть ли такая заявка в ней
$pdo = getPDO();
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM replies WHERE id = ?");
    $stmt->execute([$id]);
    $reply = $stmt->fetch();
    if (!$reply) {
        die("Заявка не найдена.");
    }
} else {
    die("Некорректный запрос.");
}

$job_id = $reply['job_id'];

// Подключаемся к базе и берем оттуда вакансию
$pdo = getPDO();
if ($job_id) {
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch();
    if (!$job) {
        die("Вакансия не найдена.");
    }
} else {
    die("Некорректный запрос.");
}

// Создаем глобальную переменную с id
$_SESSION['replies']['id'] = $id;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/job.css">
    <title><?php echo $reply['title']; ?></title>
</head>
<body class="container">
<div>
    <div>
    <p class="title">Заявка от: <b><?php echo $reply['email']; ?></b></p>
        <p class="text"><b>Резюме:</b></br><?php echo $reply['resume']; ?></p>
        <div class="flex">
            <p><img src="<?php echo $job['image']?>" style="width: 400px; height: 500px;"></p>
            <div>
                <p class="text"><b>Название:</b><br><?php echo $job['title']; ?></p>
                <p class="text"><b>Заказчик:</b><br><?php echo $job['email']; ?></p>
                <p class="text"><b>id:</b> <?php echo $job['id']; ?></p>
                <p class="text"><b>Автор заявки:</b><br><?php echo $reply['email']; ?></p>
                <p class="text"><b>Дата создания:</b> <?php echo $reply['created_at']; ?></p>
                <a style="" href="src/agree-reply.php?id=<?php echo $reply['id']; ?>">Принять</a>
                <a style="" href="src/disagree-reply.php?id=<?php echo $reply['id']; ?>">Отклонить</a>
                <p><a href="jobs.php">Назад к списку заявок</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>