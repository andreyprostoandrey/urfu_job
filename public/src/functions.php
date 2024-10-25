<?php

// Запуск сессий
session_start();

require_once __DIR__ . '/pdo.php';

// Перенаправляет на другую страницу
function redirect(string $path) {
    header("Location: $path");
    die();
}

// Проверяет, есть ли ошибка валидации
function has_validation_error(string $field_name) {
    return isset($_SESSION['validation'][$field_name]);
}

// Отправлет атрибут aria-invalid, если есть ошибка валидации
function validation_error_attr(string $field_name) {
    return isset($_SESSION['validation'][$field_name]) ? 'aria-invalid="true"' : '';
}

// Приcваивает ошибку в переменную
function validation_error_message(string $field_name) {
    $message = $_SESSION['validation'][$field_name] ?? '';
    unset($_SESSION['validation'][$field_name]);
    return $message;
}

// Возвращает сообщение об ошибке
function add_validation_error(string $field_name, string $message) {
    $_SESSION['validation'][$field_name] = $message;
}

// Сохраняет старое значение перменной
function add_old_value(string $key, $value) {
    $_SESSION['old'][$key] = $value;
}

// Возвращает старое значение перменной
function old(string $key) {
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

// Проверяем тип данных на строку
function check_string($string) {
    if (!is_string($string)) {
        add_validation_error("$string", "Не является строкой");
    }
}


// Подключение к базе данных
function getPDO(): PDO
{
    try {
        return new \PDO('mysql:host=' . DB_HOST . ';charset=utf8;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    } catch (\PDOException $e) {
        die("Connection error: {$e->getMessage()}");
    }
}

// Поиск пользователя в базе данных по почте
function find_user(string $email) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $user = $stmt->fetch(\PDO::FETCH_ASSOC);
}

// Поиск вакансий в базе данных по названию
function find_jobs(string $title) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE title = :title");
    $stmt->execute(['title' => $title]);
    return $jobs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

// Возвращает одобренные вакансии по названию
function current_jobs() {
    try {
        $pdo = getPDO();
        $status = 'agree';
        $title = '1';
        $title = $_SESSION['jobs']['title'] ?? null;
        $stmt = $pdo->prepare("SELECT * FROM jobs WHERE title = :title AND status = :status");
        $stmt->execute(['title' => $title, 'status' => $status]);
        return $jobs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Ошибка: не получилось определить вакансии" . $e->getMessage();
    }
}

// Очищает валидацию при необходимости
function clear_validation() {
    $_SESSION['validation'] = [];
}

// Возвращает текущего пользователя
function current_user() {
    try {
        $pdo = getPDO();

        if(!isset($_SESSION['user'])) {
            return false;
        }

        $user_id = $_SESSION['user']['id'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        return $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Ошибка: не получилось определить пользователя" . $e->getMessage();
    }
}

// Выход
function logout() {
    unset($_SESSION['user']['id']);
    redirect('/index.php');
}

// Проверка авторизации
function check_auth() {
    if(!isset($_SESSION['user']['id'])) {
        redirect('/');
    }
}
// Проверка авторизации, когда пользователь авторизирован
function check_guest() {
    if(isset($_SESSION['user']['id'])) {
        redirect('/home.php');
    }
}

// Проверка прав пользователя
function is_admin(array $user) {
    if(!$user['id'] == 1) {
        redirect('/home.php');
    }
}

// Загрузка файла на сервер
function upload_file(array $file, string $prefix) {
    $upload_path = __DIR__ . '../../uploads';

    if (!is_dir($upload_path)) {
        mkdir($upload_path, 007, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = $prefix . time() . ".$ext";

    if (!move_uploaded_file($file['tmp_name'], "$upload_path/$file_name")) {
        redirect('/job-create.php');
    }

    return "uploads/$file_name";
}
