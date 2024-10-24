<?php

require_once 'functions.php';

// Обработка данных
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$user = find_user($email);
add_old_value('email', $email) ?? null;

// Валидация
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    add_validation_error('email', 'Указана неправильная почта');
}
else if (!$user) {
    add_validation_error('email', "Пользователь $email не найден");
}

if (empty($password)) {
    add_validation_error('password', 'Пустой пароль');
    redirect('/');
}
else if (!password_verify($password, $user['password'])) {
    add_validation_error('password', "Неверный пароль");
    redirect('/');
}

// Присваиваем глобальное значение в текущей сессии
$_SESSION['user']['id'] = $user['id'];

redirect('/home.php');