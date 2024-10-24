<?php

require_once 'functions.php';

$id = $_GET['id'] ?? null;

$pdo = getPDO();
$stmt = $pdo->prepare("DELETE FROM replies WHERE id = :id");
$stmt->execute(['id' => $id]);

redirect('/my-replies.php');