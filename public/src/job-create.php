<?php

require_once 'functions.php';

// Обработка данных
$title = $_POST['title'] ?? null;
$description = $_POST['description'] ?? null;
$image = $_FILES['image'] ?? null;
$shift = $_POST['shift'] ?? null;
$salary = $_POST['salary'] ?? null;
add_old_value('title', $title) ?? null;
add_old_value('description', $description) ?? null;
add_old_value('shift', $shift) ?? null;
add_old_value('salary', $salary) ?? null;
$user = current_user();
$email = $user['email'] ?? null;

// Валидация данных
check_string($title);
check_string($description);
check_string($shift);
check_string($salary);

if (mb_strlen($title) > 15 or mb_strlen($title) < 3) {
    add_validation_error('title', 'Количество символов должно быть в диапозоне от 3 до 15');
}

if (mb_strlen($description) > 2055 or mb_strlen($description) < 25) {
    add_validation_error('description', 'Количество символов должно быть в диапозоне от 25 до 2055');
}

if (mb_strlen($shift) > 25 or mb_strlen($shift) < 5) {
    add_validation_error('shift', 'Количество символов должно быть в диапозоне от 5 до 25');
}

if (mb_strlen($salary) > 25 or mb_strlen($salary) < 5) {
    add_validation_error('salary', 'Количество символов должно быть в диапозоне от 5 до 25');
}

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

// Добавляем вакансию в базу данных
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