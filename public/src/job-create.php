<?php

require_once 'functions.php';

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_FILES['image'];
$shift = $_POST['shift'];
$salary = $_POST['salary'];
add_old_value('title', $title);
add_old_value('description', $description);
add_old_value('shift', $shift);
add_old_value('salary', $salary);
$user = current_user();
$email = $user['email'];


if (empty($title)) {
    add_validation_error('title', 'Пустое название');
}

if (empty($description)) {
    add_validation_error('description', 'Пустое описание');
}

if (empty($shift)) {
    add_validation_error('shift', 'Укажите режим работы');
}

if (empty($salary)) {
    add_validation_error('salary', 'Укажите зарплату');
}

if (empty($image)) {
    add_validation_error('image', 'Загрузите картинку в формате jpeg или png');
}

if(!empty($_SESSION['validation'])) {
    redirect('/job-create.php');
}

if (!empty($image)) {
    $types = ['image/jpeg', 'image/png'];
}

if (!in_array($image['type'], $types)) {
    add_validation_error('image', 'Загрузите картинку в формате jpeg или png');
}

if (($image['size'] / 1000000) >= 2) {
    add_validation_error('image', 'Изображение должно быть меньше 2 Мб');
}

if (!empty($image)) {
    $image_path = upload_file($image, 'image_');
}

$pdo = getPDO();

$query = "INSERT INTO jobs (title, description, email, image, shift, salary) VALUES (:title, :description, :email, :image, :shift, :salary)";

$params = [
    'title' => $title,
    'description' => $description,
    'email' => $email,
    'image' => $image_path,
    'shift' => $shift,
    'salary' => $salary,
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (\Exception $e) {
    die($e->getMessage());
}

redirect('/jobs.php');