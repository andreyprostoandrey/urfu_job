<?php

require_once 'src/functions.php';

check_auth();

$user = current_user();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/res.css">
    <title>Поиск вакансий</title>
</head>
<body>
    <h1>Вакансии</h1>
</body>
</html>