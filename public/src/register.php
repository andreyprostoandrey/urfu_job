<?php

require_once 'functions.php';

// Получение данных
$username = $_POST['username'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$group_id = $_POST['group_id'] ?? null;
$confirm_password = $_POST['confirm_password'] ?? null;
$user = find_user($email);
add_old_value('username', $username) ?? null;
add_old_value('email', $email) ?? null;
add_old_value('group_id', $group_id) ?? null;

// Валидация данных
check_string($username);
check_string($email);
check_string($group_id);
check_string($password);

if (mb_strlen($username) > 100 or mb_strlen($username) < 2) {
    add_validation_error('username', 'Количество символов должно быть в диапозоне от 2 до 100');
}

if (mb_strlen($email) > 100 or mb_strlen($email) < 4) {
    add_validation_error('email', 'Количество символов должно быть в диапозоне от 4 до 100');
}

if (mb_strlen($group_id) > 100 or mb_strlen($group_id) < 2) {
    add_validation_error('group_id', 'Количество символов должно быть в диапозоне от 2 до 100');
}

if (mb_strlen($password) > 255 or mb_strlen($password) < 6) {
    add_validation_error('password', 'Количество символов должно быть в диапозоне от 6 до 255');
}

if($user) {
    add_validation_error('email', 'Такой пользователь уже зарегестрирован');
}

if(empty($username)) {
    add_validation_error('username', 'Неверное имя пользователя');
}

if(empty($group_id)) {
    add_validation_error('group_id', 'Не указана группа');
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

// Отправка данных в базу
$pdo = getPDO();
$query = "INSERT INTO users (email, username, password, group_id) VALUES (:email, :username, :password, :group_id)";
$params = [
    'username' => $username,
    'group_id' => $group_id,
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