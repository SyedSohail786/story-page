<?php
require_once 'includes/db.php';

function generateSlug($title) {
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

$stories = $pdo->query("SELECT id, title FROM stories")->fetchAll();

foreach ($stories as $story) {
    $slug = generateSlug($story['title']);
    $stmt = $pdo->prepare("UPDATE stories SET slug = ? WHERE id = ?");
    $stmt->execute([$slug, $story['id']]);
}

echo "✅ All slugs updated!";
