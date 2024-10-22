<?php

require_once 'functions.php';

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_FILES['image'];
add_old_value('title', $title);
add_old_value('description', $description);
$user = current_user();
$email = $user['email'];


if (empty($title)) {
    add_validation_error('title', 'Пустое название');
}

if (empty($description)) {
    add_validation_error('description', 'Пустое описание');
}

if(!empty($_SESSION['validation'])) {
    redirect('/job-create.php');
}

if (!empty($image)) {
    $types = ['image/jpeg', 'image.png'];
}

if (!in_array($image['type'], $types)) {
    add_validation_error('image', 'Изображение имеет неверный тип');
}

if (($image['size'] / 1000000) >= 2) {
    add_validation_error('image', 'Изображение должно быть меньше 2 Мб');
}

if (!empty($image)) {
    $image_path = upload_file($image, 'image_');
}

$pdo = getPDO();

$query = "INSERT INTO jobs (title, description, email, image) VALUES (:title, :description, :email, :image)";

$params = [
    'title' => $title,
    'description' => $description,
    'email' => $email,
    'image' => $image_path
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (\Exception $e) {
    die($e->get_message());
}

redirect('/home.php');