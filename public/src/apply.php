<?php

require_once 'functions.php';

// Обработка данных
$user = current_user();
$resume = $_POST['resume'] ?? null;
$username = $user['username'] ?? null;
$email = $user['email'] ?? null;
$group_id = $user['group_id'] ?? null;
$job_id = $_SESSION['jobs']['id'] ?? null;

//Валидация
if (empty($resume)) {
    add_validation_error('resume', 'Пустое резюме');
    die("Отправка не удалась, заполните резюме");
}

check_string($resume);

if (mb_strlen($resume) > 555 or mb_strlen($resume) < 15) {
    add_validation_error('resume', 'Количество символов должно быть в диапозоне от 15 до 555');
}

// Отправка заявки в базу данных
$pdo = getPDO();
$query = "INSERT INTO replies (job_id, email, username, group_id, resume) VALUES (:job_id, :email, :username, :group_id, :resume)";
$params = [
    'job_id' => $job_id,
    'email' => $email,
    'username' => $username,
    'group_id' => $group_id,
    'resume' => $resume
];
$stmt = $pdo->prepare($query);
try {
    $stmt->execute($params);
} catch (\Exception $e) {
    die($e->getMessage());
}

redirect('/my-replies.php');