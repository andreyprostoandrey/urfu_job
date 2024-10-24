<?php

require_once 'functions.php';

$id = $_GET['id'] ?? null;

$pdo = getPDO();

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->execute([$id]);
    $job = $stmt->fetch();
    if (!$job) {
        die("Вакансия не найдена.");
    }
} else {
    die("Некорректный запрос.");
}

redirect('/my-replies.php');