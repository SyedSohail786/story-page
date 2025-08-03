<?php
require_once 'includes/db.php';
$q = trim($_GET['q'] ?? '');

$stmt = $pdo->prepare("
  SELECT * FROM stories 
  WHERE LOWER(title) LIKE LOWER(?) 
     OR LOWER(content) LIKE LOWER(?)
  ORDER BY created_at DESC
");
$searchPhrase = '%' . $q . '%';
$stmt->execute([$searchPhrase, $searchPhrase]);
$results = $stmt->fetchAll();
?>


<?php include 'includes/header.php'; ?>

<div class="container my-5">
  <h2 class="mb-4 text-orange">Search Results for "<?= htmlspecialchars($q) ?>"</h2>

  <?php if ($results): ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      <?php foreach ($results as $s): ?>
        <div class="col">
          <div class="card h-100 shadow-sm story-card">
            <img src="<?= $s['thumbnail'] ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($s['title']) ?></h5>
              <p class="card-text small text-muted"><?= date('F j, Y', strtotime($s['created_at'])) ?></p>
              <p class="card-text text-truncate-3"><?= htmlspecialchars(substr(strip_tags($s['content']), 0, 100)) ?>...</p>
              <a href="story/<?= urlencode($s['slug']) ?>" class="btn btn-sm btn-orange mt-2">Read More</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No stories found.</div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
