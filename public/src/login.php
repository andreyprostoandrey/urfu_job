<?php

require_once 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$user = find_user($email);

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    add_validation_error('email', 'Указана неправильная почта');
}
else if (!$user) {
    add_validation_error('email', "Пользователь $email не найден");
}

if(!empty($_SESSION['validation'])) {
    add_old_value('email', $email);
}

if (empty($password)) {
    add_validation_error('password', 'Пустой пароль');
    redirect('/');
}
else if (!password_verify($password, $user['password'])) {
    add_validation_error('password', "Неверный пароль");
    redirect('/');
}

$_SESSION['user']['id'] = $user['id'];

redirect('/home.php');