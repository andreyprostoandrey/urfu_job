<?php

require_once 'functions.php';

$id = $_GET['id'] ?? null;
$status = 'disagree';

$pdo = getPDO();
$stmt = $pdo->prepare("UPDATE replies SET status = :status WHERE id = :id");
$stmt->bindParam(':status', $status);
$stmt->bindParam(':id', $id);
$stmt->execute();

redirect('/replies-admin.php');