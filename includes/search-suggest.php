<?php
require_once 'db.php';

$term = $_GET['term'] ?? '';

if (strlen($term) < 2) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT title FROM stories WHERE title LIKE ? LIMIT 10");
$stmt->execute(["%$term%"]);
$results = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($results);
