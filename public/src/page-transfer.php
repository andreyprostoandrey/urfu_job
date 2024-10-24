<?php
$jobs_per_page = 4; // Количество вакансий на странице
$total_jobs = count($jobs); // Общее количество вакансий
$total_pages = ceil($total_jobs / $jobs_per_page); // Общее количество страниц

// Получаем текущую страницу
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages)); // Ограничиваем номер страницы

// Вычисляем индекс начальной и конечной вакансий для текущей страницы
$start_index = ($current_page - 1) * $jobs_per_page;
$current_jobs = array_slice($jobs, $start_index, $jobs_per_page); // Вакансии для текущей страниц