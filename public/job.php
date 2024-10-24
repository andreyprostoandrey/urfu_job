<?php

require_once 'src/functions.php';

$user = current_user();

$id = $_GET['id'] ?? null;
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
check_auth();

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
                <p><a href="jobs.php">Назад к списку вакансий</a></p>
                <form action="src/apply.php?>" method="post" enctype="multipart/form-data">
                    <label for="resume">
                        <textarea
                            style="<?php if(has_validation_error('resume')): ?>
                                <?php echo "border: 0.0625rem solid #964a50;" ?>
                                <?php endif; ?>"
                            name="resume"
                            id="resume" 
                            placeholder="Резюме для подачи заявки (максимум 555 символов)"
                            maxlength="555"><?php echo old('resume') ?></textarea>
                        <?php if(has_validation_error('resume')): ?>
                            <small style="color: #ce7e7b;"><?php echo validation_error_message('resume'); ?></small>
                        <?php endif; ?>
                    </label>

                    <button type="submit" name="reply">Откликнуться</button>
                </form>
                <?php clear_validation(); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>