<?php

require_once 'functions.php';

// Получаем данные
$id = $_GET['id'] ?? null;
$status = 'agree';

// Устанавливаем статус вакансии
$pdo = getPDO();
$stmt = $pdo->prepare("UPDATE jobs SET status = :status WHERE id = :id");
$stmt->bindParam(':status', $status);
$stmt->bindParam(':id', $id);
$stmt->execute();

redirect('/jobs-admin.php');