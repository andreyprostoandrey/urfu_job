<?php

require_once 'src/functions.php';
// Обрабатка вакансии админом

// Проверка пользователя
check_auth();
$user = current_user();
is_admin($user);

// Фиксируем id вакнсии методом GET
$id = $_GET['id'] ?? null;

// Выводим вакансию из базы данных
$pdo = getPDO();
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->execute([$id]);
    $job = $stmt->fetch();
    if (!$job) {
        die("Вакансия не найдена.");
    }
} else {
    die("Некорректный запрос.");
}

// Сохраняем id в глобальную переменную в текущей сессии
$_SESSION['jobs']['id'] = $id;
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
    <title><?php echo $job['title']; ?></title>
</head>
<body class="container">
<div>
    <div>
    <p class="title"><b><?php echo $job['title']; ?></b></p>
        <p class="text"><b>Описание:</b></br><?php echo $job['description']; ?></p>
        <div class="flex">
            <p><img src="<?php echo $job['image']?>" style="width: 400px; height: 500px;"></p>
            <div>
                <p class="text"><b>Дата создания:</b> <?php echo $job['created_at']; ?></p>
                <p class="text"><b>Режим работы:</b><br><?php echo $job['shift']; ?></p>
                <p class="text"><b>Зарплата:</b><br><?php echo $job['salary']; ?></p>
                <p class="text"><b>Заказчик:</b><br><?php echo $job['email']; ?></p>
                <p><a href="jobs-admin.php">Назад к списку вакансий</a></p>
                <a style="" href="src/agree-job.php?id=<?php echo $id; ?>">Принять</a>
                <a style="" href="src/disagree-job.php?id=<?php echo $id; ?>">Отклонить заявку</a>
                <?php clear_validation(); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>