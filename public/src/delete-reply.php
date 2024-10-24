<?php

require_once 'functions.php';

// Сохраняем id заявки
$id = $_GET['id'] ?? null;

// Удаляем заявку по id
$pdo = getPDO();
$stmt = $pdo->prepare("DELETE FROM replies WHERE id = :id");
$stmt->execute(['id' => $id]);

redirect('/my-replies.php');