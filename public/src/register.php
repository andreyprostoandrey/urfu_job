<?php

require_once 'functions.php';

// Получение данных
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Валидация данных
if(empty($username)) {
    add_validation_error('username', 'Неверное имя пользователя');
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    add_validation_error('email', 'Указана неправильная почта');
}

if(empty($password)) {
    add_validation_error('password', 'Пароль пустой');
}

if($password != $confirm_password) {
    add_validation_error('password', 'Пароли не совпадают');
}

if(!empty($_SESSION['validation'])) {
    redirect('/register.php');
}