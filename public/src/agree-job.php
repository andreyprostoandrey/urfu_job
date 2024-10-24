<?php

require_once 'functions.php';

$id = $_GET['id'] ?? null;
$status = 'agree';

$pdo = getPDO();
$stmt = $pdo->prepare("UPDATE jobs SET status = :status WHERE id = :id");
$stmt->bindParam(':status', $status);
$stmt->bindParam(':id', $id);
$stmt->execute();

redirect('/jobs-admin.php');