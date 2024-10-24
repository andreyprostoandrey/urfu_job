<?php

require_once 'functions.php';

// Обработка данных
$title_search = $_POST['title_search'] ?? null;

// Валидация
check_string($title_search);

if (mb_strlen($title_search) > 15 or mb_strlen($title_search) < 3) {
    add_validation_error('title_search', 'Количество символов должно быть в диапозоне от 3 до 15');
}

if (empty(find_jobs($title_search))) {
    add_validation_error('title_search', 'Такого элемента нет');
}

if (empty($title_search)) {
    add_validation_error('title_search', 'Пустое название');
}

if ($title_search != false){
    $_SESSION['jobs']['title'] = $title_search;
}

redirect('/job-search.php');
?>