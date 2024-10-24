<?php

require_once 'functions.php';

$title_search = $_POST['title_search'];

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