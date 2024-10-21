<?php

require_once 'functions.php';

// Получение данных
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$user = find_user($email);
add_old_value('username', $username);
add_old_value('email', $email);

// Валидация данных
if($user) {
    add_validation_error('email', 'Такой пользователь уже зарегестрирован');
}

if(empty($username)) {
    add_validation_error('username', 'Неверное имя пользователя');
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    add_validation_error('email', 'Указана неправильная почта');
}

if(empty($password)) {
    add_validation_error('password', 'Пустой пароль');
}

if($password != $confirm_password) {
    add_validation_error('password', 'Пароли не совпадают');
}

if(!empty($_SESSION['validation'])) {
    redirect('/register.php');
}

$pdo = getPDO();

$query = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";

$params = [
    'username' => $username,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT)
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (\Exception $e) {
    die($e->getMessage());
}

redirect('/index.php');