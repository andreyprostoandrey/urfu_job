<?php

session_start();

require_once __DIR__ . '/pdo.php';

function redirect(string $path) {
    header("Location: $path");
    die();
}

function has_validation_error(string $field_name) {
    return isset($_SESSION['validation'][$field_name]);
}

function validation_error_attr(string $field_name) {
    return isset($_SESSION['validation'][$field_name]) ? 'aria-invalid="true"' : '';
}

function validation_error_message(string $field_name) {
    $message = $_SESSION['validation'][$field_name] ?? '';
    unset($_SESSION['validation'][$field_name]);
    return $message;
}

function add_validation_error(string $field_name, string $message) {
    $_SESSION['validation'][$field_name] = $message;
}

function add_old_value(string $key, $value) {
    $_SESSION['old'][$key] = $value;
}

function old(string $key) {
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function getPDO(): PDO
{
    try {
        return new \PDO('mysql:host=' . DB_HOST . ';charset=utf8;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    } catch (\PDOException $e) {
        die("Connection error: {$e->getMessage()}");
    }
}

function find_user(string $email) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $user = $stmt->fetch(\PDO::FETCH_ASSOC);
}

function clear_validation() {
    $_SESSION['validation'] = [];
}

function current_user() {
    $pdo = getPDO();

    if(!isset($_SESSION['user'])) {
        return false;
    }

    $user_id = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    return $user = $stmt->fetch(\PDO::FETCH_ASSOC);
}

function logout() {
    unset($_SESSION['user']['id']);
    redirect('/index.php');
}

function check_auth() {
    if(!isset($_SESSION['user']['id'])) {
        redirect('/');
    }
}

function check_guest() {
    if(isset($_SESSION['user']['id'])) {
        redirect('/home.php');
    }
}