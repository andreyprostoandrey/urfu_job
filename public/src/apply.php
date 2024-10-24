<?php

require_once 'functions.php';

$user = current_user();

$resume = $_POST['resume'];
$username = $user['username'];
$email = $user['email'];
$group_id = $user['group_id'];
$job_id = $_SESSION['jobs']['id'];

if (empty($resume)) {
    add_validation_error('resume', 'Пустое резюме');
    die("Отправка не удалась, заполните резюме");
}

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