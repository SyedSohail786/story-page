<?php
require_once 'includes/auth.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? 0;
$type = $_GET['type'] ?? '';

$table = [
    'story' => 'stories',
    'category' => 'categories'
][$type] ?? null;

if ($table) {
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
